<?php
// File: api/access.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->uid_encrypted)) {
    $encrypted_hex = $data->uid_encrypted;
    $secret_key = "Salman_aja_3011"; 
    
    // 1. Dekripsi data in transit (XOR) dari ESP32
    $encrypted_str = hex2bin($encrypted_hex);
    $decrypted_uid = "";
    $key_len = strlen($secret_key);
    for ($i = 0; $i < strlen($encrypted_str); $i++) {
        $decrypted_uid .= $encrypted_str[$i] ^ $secret_key[$i % $key_len];
    }
    
    $uid_bersih = strtoupper(trim($decrypted_uid));

    // 2. PROTEKSI SHA256 (Data at Rest) sebelum masuk ke pencocokan Database
    $uid_hash = hash('sha256', $uid_bersih);

    // Pencocokan sekarang menggunakan UID yang sudah di-hash
    $cek_query = "SELECT nama_pengguna, is_active FROM registered_cards WHERE uid_kartu = :uid";
    $stmt_cek = $conn->prepare($cek_query);
    $stmt_cek->bindParam(":uid", $uid_hash);
    $stmt_cek->execute();

    if ($stmt_cek->rowCount() > 0) {
        $user = $stmt_cek->fetch(PDO::FETCH_ASSOC);
        if ($user['is_active'] == 1) {
            $status = "DITERIMA";
            http_response_code(200); 
        } else {
            $status = "DITOLAK (DIBLOKIR)";
            http_response_code(403); 
        }
    } else {
        $status = "DITOLAK (TIDAK DIKENAL)";
        http_response_code(403); 
    }

    // Menyimpan Log juga menggunakan UID yang sudah di-hash
    $query_log = "INSERT INTO access_logs (uid_kartu, status_akses) VALUES (:uid, :status)";
    $stmt_log = $conn->prepare($query_log);
    $stmt_log->bindParam(":uid", $uid_hash);
    $stmt_log->bindParam(":status", $status);
    $stmt_log->execute();

    echo json_encode(["status" => $status]);
} else {
    http_response_code(400);
    echo json_encode(["status" => "DITOLAK (DATA KOSONG)"]);
}
?>