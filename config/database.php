<?php
$host = "localhost";
$db_name = "iot_access_log";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    // Set mode error PDO ke exception untuk keamanan
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $exception) {
    // Jangan tampilkan pesan error asli ke layar agar tidak membocorkan struktur server
    http_response_code(500);
    die(json_encode(["error" => "Koneksi database gagal."]));
}
?>