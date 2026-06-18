<?php
require_once 'config/database.php';
// Mengambil data log akses terbaru dengan nama pengguna jika tersedia
$query = "SELECT al.waktu_akses, al.status_akses, COALESCE(rc.nama_pengguna, 'Kartu Asing') as nama_user, al.uid_kartu
          FROM access_logs al
          LEFT JOIN registered_cards rc ON al.uid_kartu = rc.uid_kartu
          ORDER BY al.waktu_akses DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Secure Access Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 20px;}
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #007BFF; color: white; }
        a.button { display: inline-block; padding: 10px 15px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        a.button:hover { background-color: #218838; }
        .status-aman { color: green; font-weight: bold; }
        .status-bahaya { color: red; font-weight: bold; }
        .hash-tag { font-size: 11px; background-color: #333; color: #fff; padding: 2px 5px; border-radius: 3px; margin-left: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔐 Sistem Monitoring Akses Keamanan</h2>
        <a href="admin/add_card.php" class="button">➕ Tambah / Kelola Pengguna</a>
        <hr style="margin-top: 20px;">
        <table>
            <tr>
                <th>Waktu (Timestamp)</th>
                <th>Nama Pengguna</th>
                <th>Fingerprint UID</th>
                <th>Status Akses</th>
            </tr>
            <?php foreach ($logs as $row): 
                $status_class = ($row['status_akses'] == 'DITERIMA') ? 'status-aman' : 'status-bahaya';
                
                // Mengambil 12 karakter pertama dari hash SHA256
                $short_uid = substr($row['uid_kartu'], 0, 12) . '...';
            ?>
            <tr>
                <td><?= htmlspecialchars($row['waktu_akses'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><strong><?= htmlspecialchars($row['nama_user'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                <td>
                    <span style="font-family: monospace;"><?= htmlspecialchars($short_uid, ENT_QUOTES, 'UTF-8') ?></span>
                </td>
                <td class="<?= $status_class ?>"><?= htmlspecialchars($row['status_akses'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>