<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "db_chatgpt";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $kode_produk = $_POST['kode_produk'];
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    // Query untuk menyimpan data ke database
    $sql = "INSERT INTO produk (id_produk, kode_produk, nama_produk, kategori, harga_beli, harga_jual, stok, satuan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssddds", $id_produk, $kode_produk, $nama_produk, $kategori, $harga_beli, $harga_jual, $stok, $satuan);
    $stmt->execute();
    $stmt->close();
}

// Pagination
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT * FROM produk LIMIT $start, $limit");
$produk_list = $result->fetch_all(MYSQLI_ASSOC);

$total_result = $conn->query("SELECT COUNT(*) AS total FROM produk")->fetch_assoc();
$total_pages = ceil($total_result['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Produk</title>
    <!-- Link ke CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Fungsi untuk show/hide form input produk
        function toggleForm() {
            var form = document.getElementById("formInputProduk");
            var button = document.getElementById("toggleButton");
            if (form.style.display === "none") {
                form.style.display = "block";
                button.textContent = "Sembunyikan Form";
            } else {
                form.style.display = "none";
                button.textContent = "Input Produk";
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Manajemen Produk</h2>

        <button id="toggleButton" class="btn btn-primary mb-3" onclick="toggleForm()">Input Produk</button>

        <!-- Form Input Produk -->
        <div id="formInputProduk" style="display: none;">
            <form action="" method="POST" class="mb-4 p-4 border rounded">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="id_produk" class="form-label">ID Produk</label>
                        <input type="text" name="id_produk" id="id_produk" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="kode_produk" class="form-label">Kode Produk</label>
                        <input type="text" name="kode_produk" id="kode_produk" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select" required>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                            <option value="cemilan">Cemilan</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select name="satuan" id="satuan" class="form-select" required>
                            <option value="pcs">PCS</option>
                            <option value="paket">Paket</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Tambah Produk</button>
            </form>
        </div>

        <!-- Tabel Daftar Produk -->
        <h3 class="text-center mb-4">Daftar Produk</h3>
        <table class="table table-striped table-responsive">
            <thead class="table-dark">
                <tr>
                    <th>ID Produk</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk_list as $produk) : ?>
                    <tr>
                        <td><?php echo $produk['id_produk']; ?></td>
                        <td><?php echo $produk['kode_produk']; ?></td>
                        <td><?php echo $produk['nama_produk']; ?></td>
                        <td><?php echo $produk['kategori']; ?></td>
                        <td><?php echo $produk['harga_beli']; ?></td>
                        <td><?php echo $produk['harga_jual']; ?></td>
                        <td><?php echo $produk['stok']; ?></td>
                        <td><?php echo $produk['satuan']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>
</html>
