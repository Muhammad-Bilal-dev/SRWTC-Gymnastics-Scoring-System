<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit; }

require_once __DIR__ . '/config.php';

$sheet = isset($_GET['sheet']) ? $_GET['sheet'] : $RESULTS_SHEET; // default ALL
$url   = $GOOGLE_SCRIPT_WEB_APP . '?' . http_build_query(['sheet' => $sheet]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
if (curl_errno($ch)) {
  echo json_encode(['status'=>'error','message'=>'cURL error: '.curl_error($ch)]);
  curl_close($ch); exit;
}
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
  echo json_encode(['status'=>'error','message'=>'Upstream returned HTTP '.$httpCode,'body'=>$response]);
  exit;
}
echo $response;
