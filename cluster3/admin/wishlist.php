<?php
$errorMSG = '';
$successMSG = '';

include './../inc/connection.php';
include './../inc/config.php';
include './../inc/layouts/navbar.php';
include './../inc/auth.admin.php';

function dataProduct($id, $column) {
    include './../inc/connection.php';
    $query = "SELECT * FROM products WHERE id = '$id'";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);
    return $data[$column];
}

function dataUser($id, $column) {
    include './../inc/connection.php';
    $query = "SELECT * FROM users WHERE id = '$id'";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);
    return $data[$column];
}

$query = "SELECT * FROM whistlist";
$sql = mysqli_query($conn, $query);
$count = $sql->num_rows;
?>

<main class="container">
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
    } if (isset($_SESSION['successMSG'])) {
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

    <div class="row mt-4">
        <div class="col-sm-9">
            <h3>Daftar keranjang Pelanggan</h3>
            <span class="badge bg-primary"><?php echo $count; ?> PRODUK</span>
        </div>
        <div class="col-sm-3"></div>
    </div>

    <div class="row mt-3">
        <?php
        while ($data = mysqli_fetch_array($sql)){ 
            $id = $data['product_id'];
        ?>
            <div class="col-sm-3">
                <div class="card w-100 rounded-3 border mb-3">
                    <img src="<?php echo $siteURL. '/src/img/'. dataProduct($id, 'image'); ?>" class="card-img-top" alt="<?php echo dataProduct($id, 'name'); ?>" style="height: 200px;">
                    <div class="card-body">
                        <span class="badge bg-primary float-end">
                            <?php
                                $uid = $data['user_id'];
                                echo dataUser($uid, 'username');
                            ?>
                        </span>
                        <h5 class="card-title">
                            <?php echo dataProduct($id, 'name'); ?>
                        </h5>
                    </div>
                </div>
            </div>
        <?php    
        }
        ?>

    </div>
</main>

<?php include './../inc/layouts/footer.php'; ?>