<?php
header('Content-Type: application/json');

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

// Accept POST request with file URL
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['fileUrl'])) {
    try {
        error_log("Received file URL: " . $data['fileUrl']);
        
        // Extract the key from URL
        $url = parse_url($data['fileUrl']);
        error_log("Parsed URL: " . print_r($url, true));
        
        $path = ltrim($url['path'], '/');
        error_log("Path after trim: " . $path);
        
        $bucketName = $_ENV['AWS_BUCKET_NAME'];
        
        // Get the key after "primeyards-uploads/"
        if (strpos($path, 'primeyards-uploads/') !== false) {
            $key = substr($path, strpos($path, 'primeyards-uploads/'));
        } else {
            $key = $path;
        }
        
        error_log("Final key for deletion: " . $key);
        error_log("Bucket name: " . $bucketName);

        // Delete the object
        $result = $s3->deleteObject([
            'Bucket' => $bucketName,
            'Key'    => $key
        ]);

        error_log("Delete successful for key: " . $key);
        echo json_encode([
            'success' => true,
            'message' => 'File deleted successfully',
            'key' => $key,
            'bucket' => $bucketName
        ]);
    } catch (Aws\Exception\AwsException $e) {
        error_log("AWS Delete Error: " . $e->getMessage());
        error_log("AWS Error Code: " . $e->getAwsErrorCode());
        error_log("AWS Error Type: " . $e->getAwsErrorType());
        error_log("Error details - Bucket: " . $bucketName . ", Key: " . $key);
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'errorCode' => $e->getAwsErrorCode(),
            'key' => $key,
            'bucket' => $bucketName
        ]);
    } catch (Exception $e) {
        error_log("General Error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'No file URL provided'
    ]);
}
?>