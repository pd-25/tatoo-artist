<?php
// Allow all origins - update to restrict if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Require 'url' parameter
if (!isset($_GET['url'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'url' parameter"]);
    exit;
}

$target_url = $_GET['url'];

// Validate URL
if (!filter_var($target_url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid URL"]);
    exit;
}

// Handle POST with JSON only
$method = $_SERVER['REQUEST_METHOD'];
$headers = getallheaders();

if ($method === 'POST' && (!isset($headers['Content-Type']) || stripos($headers['Content-Type'], 'application/json') === false)) {
    http_response_code(415); // Unsupported Media Type
    echo json_encode(["error" => "Content-Type must be application/json"]);
    exit;
}

// Set up cURL
$ch = curl_init($target_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Forward POST data
if ($method === 'POST') {
    $postData = file_get_contents('php://input');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
}

// Execute request
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// Forward appropriate Content-Type
if (stripos($content_type, 'application/json') !== false) {
    header("Content-Type: application/json");
} else {
    header("Content-Type: text/plain");
}

// Return response
http_response_code($httpcode);
echo $response;
