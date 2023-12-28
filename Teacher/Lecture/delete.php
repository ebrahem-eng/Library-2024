<?php
require '/Applications/MAMP/htdocs/maria/Library-2024-2/vendor/autoload.php';
if (isset($_POST['deleteLecture'])) {
    include('../../Config/config.php');

    $lectureID = $_POST['lectureID'];

    // Retrieve lecture details from the database
    $select = $database->prepare("SELECT * FROM lecture WHERE id = :lectureID");
    $select->bindParam(":lectureID", $lectureID);
    $select->execute();
    $lecture = $select->fetch(PDO::FETCH_ASSOC);

    if (!$lecture) {
        echo "Error: Lecture not found.";
        exit;
    }

    // Google Drive API credentials
    $googleDriveCredentialsPath = '/Applications/MAMP/htdocs/maria/Library-2024-2/library-409518-fada4b669aed.json';

    // Create Google Client
    $client = new Google_Client();
    $client->setAuthConfig($googleDriveCredentialsPath);
    $client->addScope(Google_Service_Drive::DRIVE_FILE);
    $client->setAccessType('offline');

    // Create Google Drive service
    $driveService = new Google_Service_Drive($client);

    // Retrieve lecture folder ID from the database
    $lectureFolderId = $lecture['cloudFilePath'];

    // Delete files from Google Drive
    $files = $driveService->files->listFiles([
        'q' => "'$lectureFolderId' in parents",
    ]);

    foreach ($files as $file) {
        $driveService->files->delete($file->getId());
    }

    // Delete the lecture record from the database
    $delete = $database->prepare("DELETE FROM lecture WHERE id = :lectureID");
    $delete->bindParam(":lectureID", $lectureID);

    if ($delete->execute()) {
        header("location:SpecializationTeacher.php?success=1&type=success&message=Lecture Deleted Successfully", true);
    } else {
        echo 'Failed to delete lecture from the database.';
    }
}
?>
