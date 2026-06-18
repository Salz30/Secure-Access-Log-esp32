<?php
require_once '../config/database.php';

// Menangani form submission untuk menambahkan kartu baru
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = strtoupper(trim(htmlspecialchars($_POST['uid_kartu'])));
    $nama = htmlspecialchars($_POST['nama_pengguna']);
    
    // Validasi format UID: Hanya menerima karakter Hexadecimal (A-F, 0-9)
    if (!preg_match('/^[A-F0-9]+$/', $uid)) {
        $pesan = "<span style='color:red;'>Format UID tidak valid! Hanya menerima format Hex (A-F, 0-9).</span>";
    } else {
        // PROTEKSI SHA256: Hashing otomatis sebelum input ke tabel
        $uid_hash = hash('sha256', $uid);

        // Cek apakah UID sudah terdaftar (berdasarkan hash)
        $cek_query = "SELECT id FROM registered_cards WHERE uid_kartu = :uid";
        $stmt_cek = $conn->prepare($cek_query);
        $stmt_cek->bindParam(":uid", $uid_hash);
        $stmt_cek->execute();
        if ($stmt_cek->rowCount() > 0) {
            $pesan = "<span style='color:red;'>UID ini sudah terdaftar!</span>";
        }
        // Jika valid, masukkan ke database dengan hash UID
        try {
            $query = "INSERT INTO registered_cards (uid_kartu, nama_pengguna) VALUES (:uid, :nama)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":uid", $uid_hash);
            $stmt->bindParam(":nama", $nama);
            $stmt->execute();
            $pesan = "<span style='color:green;'>Kartu berhasil didaftarkan dengan enkripsi!</span>";
        } catch(PDOException $e) {
            $pesan = "<span style='color:red;'>Gagal mendaftar. Kartu ini mungkin sudah ada.</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Kartu Akses</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 900px; margin: auto; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .btn-blokir { background-color: #dc3545; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px; font-weight: bold;}
        .btn-izinkan { background-color: #28a745; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px; font-weight: bold;}
        input[type="text"] { padding: 10px; width: 250px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;}
        button[type="submit"] { background-color: #007bff; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; font-weight: bold;}
        .hash-text { font-family: monospace; color: #555; background: #eee; padding: 2px 6px; border-radius: 4px;}
    </style>
</head>
<body>
    <div class="container">
        <h2>➕ Daftarkan Kartu Baru</h2>
        <?php if(isset($pesan)) echo "<p>$pesan</p>"; ?>
        
        <form method="POST" action="">
            <label>UID Kartu Fisik (Format Hex):</label><br>
            <input type="text" name="uid_kartu" required placeholder="Contoh: F3942D09"><br>
            
            <label>Nama Pemilik:</label><br>
            <input type="text" name="nama_pengguna" required placeholder="Masukkan Nama"><br>
            
            <button type="submit">Daftarkan Kartu</button>
        </form>
        <br>
        <a href="../index.php" style="text-decoration: none; color: #007bff; font-weight: bold;">⬅ Kembali ke Dashboard Utama</a>

        <hr style="margin: 30px 0;">
        
        <h3>📋 Daftar Kartu Terdaftar</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>UID Kartu (SHA256 Hash)</th>
                <th>Nama Pemilik</th>
                <th>Status Akses</th>
                <th>Aksi</th>
            </tr>
            <?php
            $list_query = "SELECT * FROM registered_cards ORDER BY id DESC";
            $list_stmt = $conn->prepare($list_query);
            $list_stmt->execute();
            $cards = $list_stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($cards as $card): 
                $status_teks = $card['is_active'] ? "<span style='color:green; font-weight:bold;'>Aktif</span>" : "<span style='color:red; font-weight:bold;'>Diblokir</span>";
                $tombol_teks = $card['is_active'] ? "Blokir Akses" : "Buka Blokir";
                $tombol_class = $card['is_active'] ? "btn-blokir" : "btn-izinkan";
                
                // Menyingkat tampilan hash agar tidak terlalu panjang
                $short_hash = substr($card['uid_kartu'], 0, 16) . '...';
            ?>
            <tr>
                <td><?= $card['id'] ?></td>
                <td><span class="hash-text"><?= htmlspecialchars($short_hash, ENT_QUOTES, 'UTF-8') ?></span></td>
                <td><?= htmlspecialchars($card['nama_pengguna'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= $status_teks ?></td>
                <td>
                    <a href="toggle_access.php?id=<?= $card['id'] ?>">
                        <button class="<?= $tombol_class ?>"><?= $tombol_teks ?></button>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>