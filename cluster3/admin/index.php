<?php
$errorMSG = '';
$successMSG = '';

include './../inc/connection.php';
include './../inc/config.php';
include './../inc/layouts/navbar.php';
include './../inc/auth.admin.php';

$query = "SELECT * FROM products";
$sql = mysqli_query($conn, $query);
$count = $sql->num_rows;

?>

<main class="container">
    <div class="alert alert-primary mt-4" role="alert">
        Selamat Datang di Toko Pencari Cuan
        <b><?php echo $_SESSION['user']; ?>!</b>
    </div>
    
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
        <div class="col-sm-10">
            <h3>Daftar Produk</h3>
            <span class="badge bg-secondary"><?php echo $count; ?> PRODUK</span>
        </div>
        <div class="col-sm-2">
            <a href="<?php echo $siteURL; ?>/admin/addproduct.php" class="btn btn-outline-dark w-100 text-danger">Produk Baru</a>
        </div>
    </div>

    <div class="row mt-3">
        <?php
        while ($data = mysqli_fetch_array($sql)){ 
        ?>
            <div class="col-sm-3">
                <div class="card w-100 border-0 rounded-3 shadow-sm mb-3">
                    <img src="<?php echo $siteURL. '/src/img/'. $data['image']; ?>" class="card-img-top" alt="<?php echo $data['name']; ?>" style="height: 200px;">
                    <div class="card-body">
                        <span class="badge bg-primary float-end">
                            <?php echo $data['count']; ?> Stok
                        </span>
                        <h5 class="card-title">
                            <?php echo $data['name']; ?>
                        </h5>
                        <p class="card-text text-secondary" style="font-size: 13px;">
                            <?php echo substr($data['description'], 0, 200); ?>
                        </p>
                        <b class="text-warning d-block mb-3" style="font-size: 13px;">
                            Rp. <?php echo number_format($data['price']); ?>
                        </b>
                        <div class="row">
                            <div class="col-sm-3">
                                <a href="<?php echo $siteURL .'/admin/delproduct.php?product_id='. $data['id']; ?>" class="btn btn-outline-danger w-100">X</a>
                            </div>
                            <div class="col-sm-9">
                                <a href="<?php echo $siteURL .'/admin/editproduct.php?product_id='. $data['id']; ?>" class="btn btn-outline-warning w-100 text-dark">Edit Produk</a>
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