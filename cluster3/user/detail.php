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

?>

<main class="container mt-5">
    <div class="row bg-white border shadow-sm rounded-3 p-0">
        <div class="col-sm-4 p-0">
            <img src="<?php echo $siteURL . '/src/img/'. $data['image'];?>" class="w-100 rounded-start"/>
        </div>
        <div class="col-sm-8">
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
            <div class="row">
                <div class="col-sm-6">
                    <h3 style="font-weight: 700;" class="text-primary"><?php echo $data['name']; ?></h3>
                </div>
                <div class="col-sm-6">
                    <span class="badge bg-primary float-end"><?php echo $data['count']; ?> PRODUK</span>
                </div>
            </div>
            <b class="text-warning d-block mb-3" style="font-size: 13px;">
                Rp. <?php echo number_format($data['price']); ?>
            </b>
            <p class="text-secondary" style="font-size: 15px;"><?php echo $data['description']; ?></p>
            
        </div>
    </div>

    <div class="fixed-bottom pb-5 container">
        <div class="row">
            <div class="col-sm-2">
                <a href="<?php echo $siteURL; ?>/user/" class="btn btn-light text-secondary w-100 py-2">Back</a>
            </div>
            <div class="col-sm-6"></div>
            <div class="col-sm-2">
                <a href="<?php echo $siteURL; ?>/user/whistlist.php?product_id=<?php echo $data['id']; ?>" class="btn btn-info w-100 py-2 text-white">Wishlist</a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo $siteURL; ?>/user/checkout.php?product_id=<?php echo $data['id']; ?>" class="btn btn-primary w-100 py-2">Checkout</a>
            </div>
        </div>
    </div>
</main>

<?php include './../inc/layouts/footer.php'; ?>