<?php
$errorMSG = '';
$successMSG = '';

include './../inc/connection.php';
include './../inc/config.php';
include './../inc/layouts/navbar.php';
include './../inc/auth.user.php';

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    $query = "SELECT * FROM products WHERE id = '$id'";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $uid = $_SESSION['uid'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $poscode = $_POST['poscode'];
    $telp = $_POST['telp'];
    $count = $_POST['count'];

    $dataProduct = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    $dataProduct = mysqli_fetch_assoc($dataProduct);
    $basePrice = $dataProduct['price'];
    $baseCount = $dataProduct['count'];
    $newCount = $baseCount - $count;
    if ($newCount <= 0) {
        $_SESSION['errorMSG'] = 'Persediaan Produk Tidak Mencukupi Jumlah Permintaan Anda';
        header('Location: ' . $siteURL . '/user/checkout.php?product_id=' . $id);
        exit();
    } else {
        $totalPrice = $basePrice * $count;
        $query = "INSERT INTO orders (user_id, product_id, name, address, poscode, telp, count, price, is_confirmed)
                  VALUES ('$uid', '$id', '$name', '$address', '$poscode', '$telp', '$count', '$totalPrice', '0')";
        $sql = mysqli_query($conn, $query);
        if ($query) {
            $query = "UPDATE products SET count='$newCount' WHERE id='$id'";
            $sql = mysqli_query($conn, $query);
            if ($query) {
                $_SESSION['successMSG'] = 'Order Product Successfully!';
                header('Location: ' . $siteURL . '/user/checkout.php?product_id=' . $id);
                exit();
            }
        } else {
            $_SESSION['errorMSG'] = 'Order Product Failed!';
            header('Location: ' . $siteURL . '/user/checkout.php?product_id=' . $id);
            exit();
        }
    }
}
?>

<main class="container mt-5">
    <div class="mt-3">
        <?php
        if (isset($_SESSION['errorMSG'])) {
        ?>
            <div class="mb-3">
                <div class="alert alert-danger" role="alert" style="font-size: 14px;">
                    <?php
                    echo $_SESSION['errorMSG'];
                    unset($_SESSION['errorMSG']);
                    ?>
                </div>
            </div>
        <?php
        }
        if (isset($_SESSION['successMSG'])) {
        ?>
            <div class="mb-3">
                <div class="alert alert-success" role="alert" style="font-size: 14px;">
                    <?php
                    echo $_SESSION['successMSG'];
                    unset($_SESSION['successMSG']);
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="row bg-white border shadow-sm rounded-3 p-0">
        <div class="col-sm-4 p-0">
            <img src="<?php echo $siteURL . '/src/img/' . $data['image']; ?>" class="w-100 rounded-start" />
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-6 pt-2">
                    <h3 style="font-weight: 700;" class="text-primary"><?php echo $data['name']; ?></h3>
                </div>
                <div class="col-sm-6 pt-2">
                    <span class="badge bg-primary float-end"><?php echo $data['count']; ?> PRODUK</span>
                </div>
            </div>
            <b class="text-warning d-block mb-3" style="font-size: 13px;">
                Rp. <?php echo number_format($data['price']); ?>
            </b>

            <form method="POST" action="<?php echo $siteURL; ?>/user/checkout.php" class="row border-top">
                <div class="mt-3 col-sm-6">
                    <label for="name" class="mb-2 text-secondary">Nama</label>
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
                    <input type="text" class="form-control bg-light" name="name" />
                </div>
                <div class="mt-3 col-sm-6">
                    <label for="address" class="mb-2 text-secondary">Alamat</label>
                    <input type="text" class="form-control bg-light" name="address" />
                </div>
                <div class="mt-3 col-sm-4">
                    <label for="poscode" class="mb-2 text-secondary">Pos Code</label>
                    <input type="number" class="form-control bg-light" name="poscode" />
                </div>
                <div class="mt-3 col-sm-4">
                    <label for="telp" class="mb-2 text-secondary">Telp</label>
                    <input type="text" class="form-control bg-light" name="telp" />
                </div>
                <div class="mt-3 col-sm-4">
                    <label for="count" class="mb-2 text-secondary">Count</label>
                    <input type="number" class="form-control bg-light" name="count" />
                </div>

                <div class="col-sm-12 mt-4">
                    <button type="submit" name="submit" class="btn btn-info px-5 py-2 float-end">Checkout Now!</button>
                </div>
            </form>
        </div>
    </div>

    <div class="fixed-bottom pb-5 container">
        <div class="row">
            <div class="col-sm-2">
                <a href="<?php echo $siteURL; ?>/user/detail.php?product_id=<?php echo $data['id']; ?>" class="btn btn-light text-secondary w-100 py-2">Kembali</a>
            </div>
        </div>
    </div>
</main>

<?php include './../inc/layouts/footer.php'; ?>