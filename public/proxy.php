<?php
// proxy.php

// Allow CORS for all origins or specify your frontend URL instead of '*'
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Get the target URL from the 'url' query parameter
if (!isset($_GET['url'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No url specified']);
    exit;
}

$targetUrl = $_GET['url'];

// Initialize cURL session
$ch = curl_init();

// Prepare headers to forward from client (optional, can be improved)
$headers = [];
foreach (getallheaders() as $name => $value) {
    if (strtolower($name) !== 'host' && strtolower($name) !== 'content-length') {
        $headers[] = "$name: $value";
    }
}

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Detect method and forward body for POST/PUT/PATCH
$method = $_SERVER['REQUEST_METHOD'];
if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('php://input'));
} elseif ($method === 'DELETE') {
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
}

// Execute cURL request
$response = curl_exec($ch);
if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Proxy error: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

// Separate headers and body
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$response_headers = substr($response, 0, $header_size);
$response_body = substr($response, $header_size);

// Forward status code from target server
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
http_response_code($httpcode);

// Forward selected headers from target response (avoid overriding CORS headers)
$headersToSkip = ['content-length', 'transfer-encoding', 'connection', 'access-control-allow-origin'];
$header_lines = explode("\r\n", $response_headers);
foreach ($header_lines as $header_line) {
    if (stripos($header_line, ':') !== false) {
        list($key, $value) = explode(':', $header_line, 2);
        $key = trim($key);
        $value = trim($value);
        if (!in_array(strtolower($key), $headersToSkip)) {
            header("$key: $value");
        }
    }
}

curl_close($ch);

// Output the response body
echo $response_body;
