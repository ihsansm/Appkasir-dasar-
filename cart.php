<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
    <div class="container mt-5">
        <!-- Daftar Produk -->
        <h2 class="text-center mb-4">Daftar Produk</h2>
        <div id="productList"></div>

        <!-- Cart Belanja -->
        <h2 class="text-center mt-3 mb-3">Cart Belanja</h2>
        <table id="cart" class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga Jual</th>
                    <th>Qty</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <!-- Formulir Total Belanja, Total Bayar, dan Kembalian -->
        <div class="row">
            <div class="col-md-4">
                <label for="totalBelanja">Total Belanja</label>
                <input type="text" class="form-control mb-3" id="totalBelanja" readonly>
            </div>
            <div class="col-md-4">
                <label for="totalBayar">Total Bayar</label>
                <input type="text" class="form-control mb-3" id="totalBayar">
            </div>
            <div class="col-md-4">
                <label for="kembalian">Kembalian</label>
                <input type="text" class="form-control mb-3" id="kembalian" readonly>
            </div>
        </div>

        <div class="text-center mb-5">
            <button id="bayar" class="btn btn-primary">Bayar</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            loadProducts();

            // Fungsi untuk menampilkan daftar produk
            function loadProducts(page = 1) {
                $.ajax({
                    url: 'load_products.php',
                    method: 'POST',
                    data: {
                        page: page
                    },
                    success: function(response) {
                        $('#productList').html(response);
                    }
                });
            }

            // Fungsi untuk menambah produk ke cart
            $(document).on('click', '.addToCart', function() {
                var productId = $(this).data('id');
                var productName = $(this).data('name');
                var productPrice = $(this).data('price');
                addToCart(productId, productName, productPrice);
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            loadProducts();

            // Fungsi untuk menampilkan daftar produk
            function loadProducts(page = 1) {
                $.ajax({
                    url: 'load_products.php',
                    method: 'POST',
                    data: {
                        page: page
                    },
                    success: function(response) {
                        $('#productList').html(response);
                    }
                });
            }

            // Fungsi untuk menambah produk ke cart
            $(document).on('click', '.addToCart', function() {
                var productId = $(this).data('id');
                var productName = $(this).data('name');
                var productPrice = $(this).data('price');
                addToCart(productId, productName, productPrice);
            });
        });
        // Fungsi untuk menambah produk ke cart
        function addToCart(productId, productName, productPrice) {
            var existingProduct = $('#cart tbody tr[data-id="' + productId + '"]');
            if (existingProduct.length > 0) {
                var qty = parseInt(existingProduct.find('.qty').text()) + 1;
                existingProduct.find('.qty').text(qty);
                existingProduct.find('.totalPrice').text((qty * productPrice).toFixed(2));
            } else {
                var newRow = $('<tr>').attr('data-id', productId);
                newRow.append('<td>' + productName + '</td>');
                newRow.append('<td>' + productPrice + '</td>');
                newRow.append('<td class="qty">1</td>');
                newRow.append('<td class="totalPrice">' + productPrice + '</td>');
                $('#cart tbody').append(newRow);
            }
            updateCartTotal();
        }

        // Fungsi untuk menghitung total belanja -->
        function updateCartTotal() {
            var total = 0;
            $('#cart tbody tr').each(function() {
                var price = parseFloat($(this).find('.totalPrice').text());
                total += price;
            });
            $('#totalBelanja').val(total.toFixed(2));
        }
        // Fungsi untuk menambah produk ke cart
        function addToCart(productId, productName, productPrice) {
            var existingProduct = $('#cart tbody tr[data-id="' + productId + '"]');
            if (existingProduct.length > 0) {
                var qty = parseInt(existingProduct.find('.qty').text()) + 1;
                existingProduct.find('.qty').text(qty);
                existingProduct.find('.totalPrice').text((qty * productPrice).toFixed(2));
            } else {
                var newRow = $('<tr>').attr('data-id', productId);
                newRow.append('<td>' + productName + '</td>');
                newRow.append('<td>' + productPrice + '</td>');
                newRow.append('<td class="qty">1</td>');
                newRow.append('<td class="totalPrice">' + productPrice + '</td>');
                $('#cart tbody').append(newRow);
            }
            updateCartTotal();
        }

        // Fungsi untuk menghitung total belanja
        function updateCartTotal() {
            var total = 0;
            $('#cart tbody tr').each(function() {
                var price = parseFloat($(this).find('.totalPrice').text());
                total += price;
            });
            $('#totalBelanja').val(total.toFixed(2));
        }

        // Fungsi untuk menghitung kembalian
        $('#totalBayar').on('input', function() {
            var totalBayar = parseFloat($(this).val());
            var totalBelanja = parseFloat($('#totalBelanja').val());
            var kembalian = totalBayar - totalBelanja;
            $('#kembalian').val(kembalian.toFixed(2));
        });

        // Fungsi untuk melakukan pembayaran
        $('#bayar').click(function() {
            var totalBelanja = parseFloat($('#totalBelanja').val());
            var totalBayar = parseFloat($('#totalBayar').val());
            var kembalian = parseFloat($('#kembalian').val());
            var produk = [];
            $('#cart tbody tr').each(function() {
                var productId = $(this).data('id');
                var qty = parseInt($(this).find('.qty').text());
                produk.push({
                    id: productId,
                    qty: qty
                });
            });
            // Kirim data ke server menggunakan Ajax
            $.ajax({
                url: 'proses_pembayaran.php',
                method: 'POST',
                data: {
                    totalBelanja: totalBelanja,
                    totalBayar: totalBayar,
                    kembalian: kembalian,
                    produk: produk
                },
                success: function(response) {
                    alert(response); // Tampilkan pesan sukses atau error
                    // Reset halaman kasir
                    $('#cart tbody').empty();
                    $('#totalBayar, #kembalian').val('');
                    loadProducts();
                }
            });
        });
    </script>
    </body>

</html>