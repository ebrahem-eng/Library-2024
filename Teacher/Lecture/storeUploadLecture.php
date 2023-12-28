<?php
require '/Applications/MAMP/htdocs/maria/Library-2024-2/vendor/autoload.php';

define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10 MB
define('CHUNK_SIZE', 100 * 1024); // 100 KB chunks

if (isset($_POST['UploadLecture'])) {
    include('../../Config/config.php'); // Assuming database connection details

    $name = $_POST['name'];
    $specializationID = $_POST['specializationID'];
    $subjectID = $_POST['subjectID'];
    $teacherID = $_POST['teacherID'];
    $uploadedFile = $_FILES['lectureFile'];

    // Check file size and handle upload errors
    if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
        echo "Error: File upload failed with error code " . $uploadedFile['error'];
        exit;
    }

    if ($uploadedFile['size'] > MAX_FILE_SIZE) {
        echo "Error: File size exceeds the maximum allowed limit.";
        exit;
    }

    // Read the file contents
    $fileContents = file_get_contents($uploadedFile['tmp_name']);

    // Chunk the file
    $chunks = str_split($fileContents, CHUNK_SIZE);

    // Encrypt each chunk and maintain order
    $encryptedChunks = [];
    foreach ($chunks as $index => $chunk) {
        $encryptedChunk = encryptFile($chunk, 'MySuperSecretKey1234567890');
        $encryptedChunks[$index] = $encryptedChunk;
    }

    // Google Drive API credentials
    $googleDriveCredentialsPath = '/Applications/MAMP/htdocs/maria/Library-2024-2/library-409411-a5ab9551b06e.json';
    $googleDriveFolderId = '17lZvfLFLqu0Qh6Hy_QwiVB6nW2OskCTA';

    // Create Google Client
    $client = new Google_Client();
    $client->setAuthConfig($googleDriveCredentialsPath);
    $client->addScope(Google_Service_Drive::DRIVE_FILE);
    $client->setAccessType('offline');

    // Create Google Drive service
    $driveService = new Google_Service_Drive($client);

    // Create a folder for the lecture
    $folderMetadata = new Google_Service_Drive_DriveFile([
        'name' => $name,
        'mimeType' => 'application/vnd.google-apps.folder',
        'parents' => [$googleDriveFolderId],
    ]);

    $folder = $driveService->files->create($folderMetadata);
    $lectureFolderId = $folder->id;

    // Upload encrypted chunks to the folder with explicit order
    foreach ($encryptedChunks as $index => $encryptedChunk) {
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $uploadedFile['name'] . '_chunk_' . $index,
            'parents' => [$lectureFolderId],
        ]);

        $file = $driveService->files->create($fileMetadata, [
            'data' => $encryptedChunk,
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media',
        ]);
    }

    // Insert into database
    $sql = "INSERT INTO lecture (name, cloudFilePath, specialization_id, subject_id, created_by)
          VALUES (:name, :cloudFilePath, :specializationID, :subjectID, :teacherID)";

    $stmt = $database->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':cloudFilePath', $lectureFolderId); // Save folder link
    $stmt->bindValue(':specializationID', $specializationID);
    $stmt->bindValue(':subjectID', $subjectID);
    $stmt->bindValue(':teacherID', $teacherID);

    if ($stmt->execute()) {
        header("location:index.php?success=1&type=success&message=Lecture Uploaded Successfully", true);
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

function encryptFile($data, $key)
{
    $cipher = "AES-256-CBC";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
    $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);

    return $ciphertext;
}
?>
