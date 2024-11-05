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

// Ambil tanggal dari POST
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

// Query untuk mengambil data penjualan dari rentang tanggal
$query = "
    SELECT j.tanggal_beli, p.nama_produk, r.harga_jual, r.qty, r.total_harga 
    FROM jual j
    JOIN rinci_jual r ON j.nomor_faktur = r.nomor_faktur
    JOIN produk p ON r.kode_produk = p.id_produk
    WHERE j.tanggal_beli BETWEEN ? AND ?
    ORDER BY j.tanggal_beli ASC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

// Buat output HTML untuk tabel laporan
$output = "";
while ($row = $result->fetch_assoc()) {
    $output .= "<tr>
        <td>{$row['tanggal_beli']}</td>
        <td>{$row['nama_produk']}</td>
        <td>{$row['harga_jual']}</td>
        <td>{$row['qty']}</td>
        <td>{$row['total_harga']}</td>
    </tr>";
}

echo $output;

// Tutup koneksi
$stmt->close();
$conn->close();
?>
