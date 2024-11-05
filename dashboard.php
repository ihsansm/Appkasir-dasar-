<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Link ke CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link ke ikon Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .menu-button {
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: background-color 0.3s;
        }
        .menu-button:hover {
            background-color: #f8f9fa;
        }
        .menu-button i {
            font-size: 50px;
            margin-bottom: 10px;
        }
        .menu-button h3 {
            font-size: 20px;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="container text-center mt-5">
        <!-- Logo besar di atas tombol -->
        <img src="https://via.placeholder.com/150" class="logo" alt="Logo Aplikasi Kasir">

        <h1>Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Pilih menu di bawah ini:</p>
        
        <div class="row justify-content-center">
            <!-- Tombol Produk -->
            <div class="col-md-4">
                <a href="produk.php" class="menu-button">
                    <i class="fas fa-box"></i>
                    <h3>Produk</h3>
                </a>
            </div>
            <!-- Tombol Kasir -->
            <div class="col-md-4">
                <a href="kasir.php" class="menu-button">
                    <i class="fas fa-cash-register"></i>
                    <h3>Kasir</h3>
                </a>
            </div>
            <!-- Tombol Laporan -->
            <div class="col-md-4">
                <a href="laporan.php" class="menu-button">
                    <i class="fas fa-file-alt"></i>
                    <h3>Laporan</h3>
                </a>
            </div>
        </div>
    </div>

    <!-- Link ke JS Bootstrap dan dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Link ke Font Awesome untuk ikon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
