<?php

$errorMSG = '';
$successMSG = '';

include './../inc/connection.php';
include './../inc/config.php';
include './../inc/layouts/navbar.php';
include './../inc/auth.admin.php';

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_stok = $_POST['product_stok'];
    $description = $_POST['description'];

    $filename = $_FILES['product_image']['name'];

    if ($filename != '') {
        $allowedExtension = array('png', 'jpg', 'jpeg', 'gif');
        $regex = explode('.', $filename);
        $extension = strtolower(end($regex));

        $filesize = $_FILES['product_image']['size'];
        $file_tmp = $_FILES['product_image']['tmp_name'];

        if (in_array($extension, $allowedExtension) === true) {
            if ($filesize < 1044070) {
                $filenameHash = md5($filename) . '.'. $extension;
                move_uploaded_file($file_tmp, './../src/img/' . $filenameHash);
                $query = "UPDATE products
                          SET name='$product_name', description='$description', count='$product_stok', image='$filenameHash', price='$product_price'
                          WHERE id = '$id'";
                $update = mysqli_query($conn, $query);
                if ($update) {
                    $successMSG = 'Sukses Mengubah Produk!';
                } else {
                    $errorMSG = 'Gagal Mengubah Produk!';
                }
            } else {
                $errorMSG = 'File Yang Di Unggah Terlalu Besar!';
            }
        } else {
            $errorMSG = 'Ekstensi File Di Luar Dari Yang Di Izinkan (PNG, JPG, JPEG, GIF)!';
        }
    } else {
        $query = "SELECT * FROM products WHERE id = '$id'";
        $sql = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($sql);
        $filename = $data['image'];

        $query = "UPDATE products
                  SET name='$product_name', description='$description', count='$product_stok', image='$filename', price='$product_price'
                  WHERE id = '$id'";
        $update = mysqli_query($conn, $query);
        if ($update) {
            $successMSG = 'Sukses Mengubah Produk!';
        } else {
            $errorMSG = 'Gagal Mengubah Produk!';
        }
    }
}

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    $query = "SELECT * FROM products WHERE id = '$id'";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);
}

?>

<main class="container">
    <form class="row mt-3 mb-5 pt-3" method="POST" action="<?php echo $siteURL; ?>/admin/editproduct.php?product_id=<?php echo $data['id']; ?>" enctype="multipart/form-data">
        <?php include './../inc/layouts/notification.php'; ?>
        <div class="col-sm-6 mb-3">
            <label class="mb-2">Nama Produk</label>
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>"/>
            <input type="text" class="form-control" name="product_name" value="<?php echo $data['name']; ?>"/>
        </div>
        <div class="col-sm-3 mb-3">
            <label class="mb-2">Harga Produk</label>
            <input type="number" class="form-control" name="product_price" value="<?php echo $data['price']; ?>"/>
        </div>
        <div class="col-sm-3 mb-3">
            <label class="mb-2">Stok Produk</label>
            <input type="number" class="form-control" name="product_stok" value="<?php echo $data['count']; ?>"/>
        </div>
        <div class="col-sm-12 mb-3">
            <label class="mb-2">Thumbnail Produk</label>
            <input type="file" class="form-control" name="product_image" />
        </div>
        <div class="col-sm-12 mb-3">
            <label class="mb-2">Deskripsi Produk</label>
            <textarea name="description" class="form-control" rows="8"><?php echo $data['description']; ?></textarea>
        </div>

        <div class="col-sm-2">
            <a href="<?php echo $siteURL; ?>/admin/" class="btn btn-secondary w-100 py-2">Kembali</a>
        </div>
        <div class="col-sm-8"></div>
        <div class="col-sm-2">
            <button type="submit" name="submit" class="btn btn-primary w-100 py-2">Edit Produk</button>
        </div>
    </form>
</main>

<?php include './../inc/layouts/footer.php'; ?>