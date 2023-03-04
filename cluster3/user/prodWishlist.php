<?php
$errorMSG = '';
$successMSG = '';

include './../inc/connection.php';
include './../inc/config.php';
include './../inc/layouts/navbar.php';
include './../inc/auth.user.php';

function dataProduct($id, $column) {
    include './../inc/connection.php';
    $query = "SELECT * FROM products WHERE id = '$id'";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);
    return $data[$column];
}
$uid = $_SESSION['uid'];
$query = "SELECT * FROM whistlist WHERE user_id = '$uid'";
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
            <h3>Daftar Produk Whistlist</h3>
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
                <div class="card w-100 border-0 rounded-3 shadow-sm mb-3">
                    <img src="<?php echo $siteURL. '/src/img/'. dataProduct($id, 'image'); ?>" class="card-img-top" alt="<?php echo dataProduct($id, 'name'); ?>" style="height: 200px;">
                    <div class="card-body">
                        <span class="badge bg-primary float-end">
                            <?php echo dataProduct($id, 'count'); ?> Stok
                        </span>
                        <h5 class="card-title">
                            <?php echo dataProduct($id, 'name'); ?>
                        </h5>
                        <p class="card-text text-secondary" style="font-size: 13px;">
                            <?php
                                $desc = dataProduct($id, 'description');
                                echo substr($desc, 0, 200);
                            ?>
                        </p>
                        <b class="text-warning d-block mb-3" style="font-size: 13px;">
                            Rp. <?php
                                    $price = dataProduct($id, 'price');
                                    echo number_format($price);
                                ?>
                        </b>
                        <div class="row">
                            <div class="col-sm-3">
                                <a href="<?php echo $siteURL .'/user/delWishlist.php?product_id='. $id; ?>" class="btn bg-danger text-white w-100">X</a>
                            </div>
                            <div class="col-sm-9">
                                <a href="<?php echo $siteURL .'/user/detail.php?product_id='. $id; ?>" class="btn btn-primary w-100">Detail Produk</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php    
        }
        ?>

    </div>
</main>

<?php include './../inc/layouts/footer.php'; ?>