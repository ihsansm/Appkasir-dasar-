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

$totalQuery = "select count(*) as total from produk";
$totalResults = $conn->query($totalQuery);
$totalData = $totalResults->fetch_assoc()['total'];

// pagination
$limit = 10;    // jumlah produk perhalaman
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM produk LIMIT $start, $limit";
$result = $conn->query($sql);

// tampilkan daftar produk
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo '<table id="cart" class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo    '<td class="col-md-6">' . $row['nama_produk'] . '</td>';
        echo    '<td class="col-md-4">' . $row['harga_jual'] . '</td>';
        echo    '<td>' . "<button class='btn btn-primary addToCart' data-id='" . $row['id_produk'] . "' data-name='" . $row['nama_produk'] . "' data-price='" . $row['harga_jual'] . "'>Add to Cart</button>" . '</td>';
        echo '</tr>';
        echo '</thead>';
        echo '</table>';
        echo "</div>";
    }
} else {
    echo "Tidak ada produk.";
}

// Ambil halaman saat ini dari parameter URL, default ke halaman 1 jika tidak ada
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Query untuk mendapatkan data produk dengan limit dan offset untuk pagination
$query = "SELECT * FROM produk LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

// Menyusun tabel produk sebagai HTML

// Hitung total produk untuk menentukan jumlah halaman
$totalResult = $conn->query("SELECT COUNT(*) as count FROM produk")->fetch_assoc()['count'];
$totalPages = ceil($totalResult / $limit);

// Membuat elemen pagination sebagai HTML
$pagination = "<ul class='pagination'>";
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == $page) ? "active" : "";
    $pagination .= "<li class='page-item $activeClass'><a href='#' class='page-link' data-page='$i'>$i</a></li>";
}
$pagination .= "</ul>";

// Mengembalikan data produk dan pagination dalam format JSON

$conn->close();
