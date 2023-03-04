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

$query = "SELECT * FROM orders";
$sql = mysqli_query($conn, $query);
$count = $sql->num_rows;

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'pendding') {
        $query = "SELECT * FROM orders WHERE is_confirmed = '0'";
    } elseif ($status == 'confirmed') {
        $query = "SELECT * FROM orders WHERE is_confirmed = '1'";
    } else {
        $query = "SELECT * FROM orders";
    }
    $sql = mysqli_query($conn, $query);
    $count = $sql->num_rows;
}
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
            <h3>Daftar Pesanan</h3>
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
                            <?php echo $data['count']; ?> Pesanan
                        </span>
                        <h5 class="card-title">
                            <?php echo dataProduct($id, 'name'); ?>
                        </h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="font-size: 13px;width: 30px;" class="text-secondary">Pemesan</td>
                                    <td style="font-size: 13px;" class="text-secondary">: <?php echo $data['name']; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px;width: 30px;" class="text-secondary">Telp</td>
                                    <td style="font-size: 13px;" class="text-secondary">: <?php echo $data['telp']; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px;width: 30px;" class="text-secondary">Alamat</td>
                                    <td style="font-size: 13px;" class="text-secondary">: <?php echo $data['address']; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px;width: 30px;" class="text-secondary">Pos</td>
                                    <td style="font-size: 13px;" class="text-secondary">: <?php echo $data['poscode']; ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px;width: 30px;" class="text-secondary">Status</td>
                                    <td style="font-size: 13px;" class="text-secondary">:
                                        <?php if ($data['is_confirmed'] == false) { echo 'Pendding'; } else { echo 'Confirmed'; } ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <b class="text-warning d-block mb-3" style="font-size: 13px;">
                            Total Harga : Rp. <?php echo number_format($data['price']); ?>
                        </b>
                        <div class="mt-3">
                            <?php if ($data['is_confirmed'] == false) {
                            ?>
                                <a href="<?php echo $siteURL. '/admin/handleOrder.php?oid='. $data['id'] .'&confirmed=true'; ?>" class="btn btn-outline-success w-100">Konfirmasi</a>
                            <?php
                            } else {
                            ?>
                                <a href="<?php echo $siteURL. '/admin/handleOrder.php?oid='. $data['id']. '&cancle=true'; ?>" class="btn btn-outline-info w-100">Pesanan telah di terima</a>
                            <?php } ?>
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