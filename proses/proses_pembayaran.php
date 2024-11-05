<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_chatgpt";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari POST
$faktur = uniqid(); // generate nomor faktur secara unik
$totalBelanja = $_POST['totalBelanja'];
$totalBayar = $_POST['totalBayar'];
$kembalian = $_POST['kembalian'];
$cart = json_decode($_POST['cart'], true); // Decode data cart yang dikirim dalam format JSON

// Mulai transaksi
$conn->begin_transaction();

try {
    // Insert data transaksi ke tabel jual
    $stmt = $conn->prepare("INSERT INTO jual (nomor_faktur, tanggal_beli, total_belanja, total_bayar, kembalian) VALUES (?, NOW(), ?, ?, ?)");
    $stmt->bind_param("sddd", $faktur, $totalBelanja, $totalBayar, $kembalian);
    $stmt->execute();
    
    // Insert detail produk yang dibeli ke tabel rinci_jual
    $stmtDetail = $conn->prepare("INSERT INTO rinci_jual (nomor_faktur, kode_produk, harga_modal, harga_jual, qty, total_harga, untung) VALUES (?, ?, ?, ?, ?, ?, ?)");

    foreach ($cart as $productId => $item) {
        $kode_produk = $productId;
        $harga_modal = 0; // Placeholder untuk harga modal, tergantung database produk
        $harga_jual = $item['price'];
        $qty = $item['qty'];
        $total_harga = $harga_jual * $qty;
        $untung = ($harga_jual - $harga_modal) * $qty;

        $stmtDetail->bind_param("siddidd", $faktur, $kode_produk, $harga_modal, $harga_jual, $qty, $total_harga, $untung);
        $stmtDetail->execute();
    }

    // Commit transaksi jika berhasil
    $conn->commit();
    echo "Transaksi berhasil disimpan";

} catch (Exception $e) {
    // Rollback jika ada error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Tutup koneksi dan statement
$stmt->close();
$stmtDetail->close();
$conn->close();
?>
