<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data === null) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
    exit;
}

// Convert gymnast numbers to integers
if (isset($data['scores'])) {
    foreach ($data['scores'] as &$score) {
        $score['gymnast_number'] = (int)$score['gymnast_number'];
    }
}

$googleScriptUrl = 'https://script.google.com/macros/s/AKfycbyGcr4vYa1V-JgN0r9nNIitQMytBzJA041qOzqWKWIMEXtZug59EH46Fs5-_ZeZ0MH_qg/exec';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $googleScriptUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(['status' => 'error', 'message' => 'cURL error: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);
echo $response;
?>