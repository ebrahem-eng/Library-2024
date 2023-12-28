<?php
require '/Applications/MAMP/htdocs/maria/Library-2024-2/vendor/autoload.php';

if (isset($_GET['downloadLec'])) {
    include('../../Config/config.php'); // Assuming database connection details

    // Retrieve lecture ID from the URL parameter
    $lectureID = $_GET['lectureID'];

    // Retrieve lecture details from the database
    $sql = "SELECT * FROM lecture WHERE id = :lectureID";
    $stmt = $database->prepare($sql);
    $stmt->bindValue(':lectureID', $lectureID, PDO::PARAM_INT);
    $stmt->execute();
    $lecture = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$lecture) {
        echo "Error: Lecture not found.";
        exit;
    }

    // Google Drive API credentials
    $googleDriveCredentialsPath = '/Applications/MAMP/htdocs/maria/Library-2024-2/library-409411-a5ab9551b06e.json';

    // Create Google Client
    $client = new Google_Client();
    $client->setAuthConfig($googleDriveCredentialsPath);
    $client->addScope(Google_Service_Drive::DRIVE_FILE);
    $client->setAccessType('offline');

    // Create Google Drive service
    $driveService = new Google_Service_Drive($client);

    // Retrieve encrypted chunks from Google Drive in order
    $lectureFolderId = $lecture['cloudFilePath'];
    $files = $driveService->files->listFiles([
        'q' => "'$lectureFolderId' in parents",
        'orderBy' => 'name',  // Order by name to ensure chunks are retrieved in order
    ]);

    $encryptedChunks = [];
    foreach ($files as $file) {
        $response = $driveService->files->get($file->getId(), ['alt' => 'media']);
        $encryptedChunks[] = $response->getBody()->getContents();
    }

    // Decrypt and reassemble the lecture in the same order
    $decryptedChunks = [];
    foreach ($encryptedChunks as $encryptedChunk) {
        $decryptedChunk = decryptFile($encryptedChunk, 'MySuperSecretKey1234567890');
        if ($decryptedChunk === false) {
            echo "Error: Decryption failed.";
            exit;
        }
        $decryptedChunks[] = $decryptedChunk;
    }

    $decryptedContent = implode('', $decryptedChunks);

    // Provide the decrypted content for download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $lecture['name'] . '.pdf"');
    ob_clean(); // Clear output buffer
    echo $decryptedContent;
    exit;
}

function decryptFile($data, $key)
{
    $data = base64_decode($data);
    $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
    $iv = substr($data, 0, $ivlen);
    $hmac = substr($data, $ivlen, $sha2len = 32);
    $ciphertext_raw = substr($data, $ivlen + $sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);

    if (hash_equals($hmac, $calcmac)) {
        return $original_plaintext;
    }

    return false;
}
?>
