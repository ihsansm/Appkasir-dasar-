<?php
session_start();

if(!isset($_SESSION['email'])) {
    header("location: login.html");
    exit();
}

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "db_chatgpt";

$conn = new mysqli($servername, $username_db, $password_db,
$dbname );

if ($conn->connect_error) {
    die("koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_produk = $_POST['kode_produk'];
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    // query simpen data - db
    $sql = "INSERT INTO produk (kode_produk, nama_produk, kategori, harga_beli, harga_jual, stok, satuan)
            VALUES ('$kode_produk', '$nama_produk', '$kategori', '$harga_beli', '$harga_jual', '$stok', '$satuan')";

    if ($conn->query($sql) === TRUE) {
        header("Location: produk.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Form tidak diakses dengan metode POST.";
}

$conn->close();
?>