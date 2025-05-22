<?php
// proxy.php

// Allow from any origin (adjust for production)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle OPTIONS preflight request and exit early
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get the URL parameter to proxy
if (!isset($_GET['url'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No url parameter provided']);
    exit;
}

// The URL you want to proxy to
$targetUrl = $_GET['url'];

// Initialize cURL
$ch = curl_init($targetUrl);

// Forward HTTP method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $_SERVER['REQUEST_METHOD']);

// Forward headers from client (except Host and some restricted ones)
$headers = [];
foreach (getallheaders() as $name => $value) {
    if (strtolower($name) === 'host') continue; // don't send original host header
    if (strtolower($name) === 'content-length') continue; // let curl set content length
    $headers[] = "$name: $value";
}
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Forward POST/PUT/PATCH body
if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'PATCH'])) {
    $input = file_get_contents('php://input');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
}

// Return response headers and body
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);

// Execute the request
$response = curl_exec($ch);

if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}

// Separate headers and body
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $headerSize);
$body = substr($response, $headerSize);

// Forward status code from backend
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
http_response_code($httpCode);

// Forward headers from backend (filter some headers)
$headerLines = explode("\r\n", $header);
foreach ($headerLines as $headerLine) {
    if (stripos($headerLine, 'Transfer-Encoding:') === 0) continue;
    if (stripos($headerLine, 'Content-Length:') === 0) continue;
    if (stripos($headerLine, 'Content-Encoding:') === 0) continue;
    if (stripos($headerLine, 'Connection:') === 0) continue;
    if ($headerLine !== '') {
        header($headerLine);
    }
}

echo $body;

curl_close($ch);
