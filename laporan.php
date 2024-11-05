<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Laporan Penjualan</h2>

        <!-- Form Filter Rentang Tanggal -->
        <div class="mb-4">
            <form id="filterForm" class="form-inline justify-content-center">
                <label for="startDate" class="mr-2">Mulai Tanggal:</label>
                <input type="date" id="startDate" class="form-control mr-2" required>

                <label for="endDate" class="mr-2">Sampai Tanggal:</label>
                <input type="date" id="endDate" class="form-control mr-2" required>

                <button type="button" class="btn btn-primary" onclick="loadLaporan()">Tampilkan</button>
            </form>
        </div>

        <!-- Tabel Laporan Penjualan -->
        <div id="laporanContainer">
            <table class="table table-bordered table-striped table-responsive w-100">
                <thead class="thead-dark">
                    <tr>
                        <th>Tanggal Beli</th>
                        <th>Nama Produk</th>
                        <th>Harga Jual</th>
                        <th>Qty</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody id="laporanTable">
                    <!-- Data akan di-load di sini melalui AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script AJAX untuk mengambil data laporan -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function loadLaporan() {
            // Ambil nilai tanggal dari form
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            // Pastikan tanggal diisi
            if (!startDate || !endDate) {
                alert("Mohon isi rentang tanggal terlebih dahulu.");
                return;
            }

            // Request AJAX ke laporan_data.php
            $.ajax({
                url: 'laporan_data.php',
                type: 'POST',
                data: { startDate: startDate, endDate: endDate },
                success: function(response) {
                    $('#laporanTable').html(response); // Update tabel dengan data yang diterima
                },
                error: function() {
                    alert("Gagal mengambil data.");
                }
            });
        }
    </script>
</body>
</html>
