<?php
require(__DIR__ . '/./vendor/autoload.php');

use Aws\S3\S3Client;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/.');
$dotenv->load();

$s3 = new S3Client([
    'region'  => $_ENV['AWS_REGION'], 
    'version' => 'latest',
    'credentials' => [
        'key'    => $_ENV['AWS_ACCESS_KEY_ID'],
        'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'],
    ],
]);

if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $file = $_FILES['file'];
    $isDocument = isset($_POST['isDocument']) && $_POST['isDocument'] === 'true';

    try {
        // Log environment variables (excluding sensitive data)
        error_log("AWS Region: " . $_ENV['AWS_REGION']);
        error_log("AWS Bucket: " . $_ENV['AWS_BUCKET_NAME']);
        error_log("File details: " . json_encode([
            'name' => $file['name'],
            'type' => $file['type'],
            'size' => $file['size']
        ]));
        
        $bucketName = $_ENV['AWS_BUCKET_NAME'];
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (empty($extension) && $file['type']) {
            // If no extension but we have mime type, try to get extension from mime type
            $mime_types = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'application/pdf' => 'pdf',
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
            ];
            $extension = isset($mime_types[$file['type']]) ? $mime_types[$file['type']] : 'unknown';
        }
        
        $uniqueName = uniqid() . '_' . time() . '.' . $extension;
        $key = 'primeyards-uploads/' . $uniqueName;

        $uploadResponse = $s3->putObject([
            'Bucket' => $bucketName,
            'Key'    => $key,
            'SourceFile' => $file['tmp_name'], 
            'ContentType' => $isDocument ? $file['type'] : 'image/jpeg'
        ]);

        error_log("Upload successful. Object URL: " . $uploadResponse['ObjectURL']);
        echo json_encode([
            'url' => $uploadResponse['ObjectURL'],
            'filename' => $uniqueName,
            'originalname' => $file['name']
        ]);
    } catch (Aws\Exception\AwsException $e) {
        error_log("AWS Upload Error: " . $e->getMessage());
        error_log("AWS Error Code: " . $e->getAwsErrorCode());
        error_log("AWS Error Type: " . $e->getAwsErrorType());
        echo json_encode(['error' => 'Upload failed: ' . $e->getMessage()]);
    }
} else {
    $uploadError = isset($_FILES['file']) ? $_FILES['file']['error'] : 'No file in $_FILES';
    error_log("File upload error: " . $uploadError);
    echo json_encode(['error' => 'No file uploaded or file error. Error code: ' . $uploadError]);
}
