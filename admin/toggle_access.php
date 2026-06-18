<?php
// File: admin/toggle_access.php
require_once '../config/database.php';

if (isset($_GET['id'])) {
    // MENCEGAH SQL INJECTION: Memaksa parameter id menjadi format Integer murni
    $id = intval($_GET['id']); 

// Validasi tambahan untuk memastikan id adalah angka positif
    if ($id > 0) {
    try {
        $query = "SELECT is_active FROM registered_cards WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $current_status = $row['is_active'];
            
            // Toggle status (1 jadi 0, 0 jadi 1)
            $new_status = ($current_status == 1) ? 0 : 1;
            
            $update_query = "UPDATE registered_cards SET is_active = :new_status WHERE id = :id";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bindParam(':new_status', $new_status);
            $update_stmt->bindParam(':id', $id);
            $update_stmt->execute();
            
            // Redirect kembali ke halaman add_card.php dengan pesan sukses
            header("Location: add_card.php?msg=Status+berhasil+diperbarui");
            exit();
        } else {
            echo "Data kartu tidak ditemukan.";
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo "Terjadi kesalahan sistem.";
    }
} else {
    echo "ID kartu tidak valid.";
}
} else {
    echo "ID kartu tidak ditemukan.";
}
?>