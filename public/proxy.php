<?php
// Allow all origins - you can restrict this to specific domains if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization");

// Handle preflight OPTIONS request for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// The target URL to proxy requests to, pass as a query parameter ?url=...
if (!isset($_GET['url'])) {
    http_response_code(400);
    echo json_encode(["error" => "No url parameter provided"]);
    exit;
}

$target_url = $_GET['url'];

// Validate URL (basic check)
if (!filter_var($target_url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid url parameter"]);
    exit;
}

// Initialize cURL
$ch = curl_init($target_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Forward request method and data if POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('php://input'));
}

// Forward request headers except Host (optional: implement if needed)

// Execute cURL
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// Forward content type header to client
if ($content_type) {
    header("Content-Type: $content_type");
}

// Return proxied response with original status code
http_response_code($httpcode);
echo $response;
