<?php

$errorMSG = '';
$successMSG = '';

include './../inc/connection.php';
include './../inc/config.php';
include './../inc/layouts/navbar.php';
include './../inc/auth.admin.php';

if (isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_stok = $_POST['product_stok'];
    $description = $_POST['description'];

    $allowedExtension = array('png', 'jpg', 'jpeg', 'gif');
    $filename = $_FILES['product_image']['name'];
    $regex = explode('.', $filename);
    $extension = strtolower(end($regex));

    $filesize = $_FILES['product_image']['size'];
    $file_tmp = $_FILES['product_image']['tmp_name'];

    if (in_array($extension, $allowedExtension) === true) {
        if ($filesize < 1044070) {
            $filenameHash = md5($filename) . '.'. $extension;
            move_uploaded_file($file_tmp, './../src/img/' . $filenameHash);
            $query = "INSERT INTO products (name, description, count, image, price)
                             VALUES ('$product_name', '$description', '$product_stok', '$filenameHash', '$product_price')";
            $insert = mysqli_query($conn, $query);
            if (!$insert) {
                $errorMSG = 'Gagal Menambahkan Produk!';
            } else {
                $successMSG = 'Sukses Menambahkan Produk!';
            }
        } else {
            $errorMSG = 'File Yang Di Unggah Terlalu Besar!';
        }
    } else {
        $errorMSG = 'Ekstensi File Di Luar Dari Yang Di Izinkan (PNG, JPG, JPEG, GIF)!';
    }
}
?>

<main class="container">
    <form class="row mt-3 mb-5 pt-3" method="POST" action="<?php echo $siteURL; ?>/admin/addproduct.php" enctype="multipart/form-data">
        <?php include './../inc/layouts/notification.php'; ?>
        <div class="col-sm-6 mb-3">
            <label class="mb-2">Nama Produk</label>
            <input type="text" class="form-control" name="product_name" />
        </div>
        <div class="col-sm-3 mb-3">
            <label class="mb-2">Harga Produk</label>
            <input type="number" class="form-control" name="product_price" />
        </div>
        <div class="col-sm-3 mb-3">
            <label class="mb-2">Stok Produk</label>
            <input type="number" class="form-control" name="product_stok" />
        </div>
        <div class="col-sm-12 mb-3">
            <label class="mb-2">Thumbnail Produk</label>
            <input type="file" class="form-control" name="product_image" />
        </div>
        <div class="col-sm-12 mb-3">
            <label class="mb-2">Deskripsi Produk</label>
            <textarea name="description" class="form-control" rows="8"></textarea>
        </div>

        <div class="col-sm-2">
            <a href="<?php echo $siteURL; ?>/admin/" class="btn btn-danger w-100 py-2">Kembali</a>
        </div>
        <div class="col-sm-8"></div>
        <div class="col-sm-2">
            <button type="submit" name="submit" class="btn btn-success w-100 py-2">Tambah Produk</button>
        </div>
    </form>
</main>

<?php include './../inc/layouts/footer.php'; ?>