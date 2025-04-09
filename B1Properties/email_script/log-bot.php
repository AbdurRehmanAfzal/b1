<?php
$data = json_decode(file_get_contents("php://input"), true);
$userAgent = $data["userAgent"] ?? 'Unknown';

$ip = $_SERVER["REMOTE_ADDR"];
$log = "[" . date("Y-m-d H:i:s") . "] IP: $ip | UA: $userAgent\n";

file_put_contents("bot_logs.txt", $log, FILE_APPEND);
http_response_code(200);
?>