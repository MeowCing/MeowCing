<?php
session_start();
include './../inc/connection.php';
include './../inc/config.php';
include './../inc/auth.admin.php';

if (isset($_GET['oid']) && isset($_GET['confirmed'])) {
    $oid = $_GET['oid'];
    $query = "UPDATE orders SET is_confirmed='1' WHERE id = '$oid'";
    $sql = mysqli_query($conn, $query);
    if ($sql) {
        $_SESSION['successMSG'] = 'Konfirmasi Order!';
        header('Location: '. $siteURL .'/admin/order.php?status=confirmed');
        exit();
    }
    $_SESSION['errorMSG'] = 'Konfirmasi Order Gagal!';
}

if (isset($_GET['oid']) && isset($_GET['cancle'])) {
    $oid = $_GET['oid'];
    $query = "UPDATE orders SET is_confirmed='0' WHERE id = '$oid'";
    $sql = mysqli_query($conn, $query);
    if ($sql) {
        $_SESSION['successMSG'] = 'Sabar ya Gan!';
        header('Location: '. $siteURL .'/admin/order.php?status=pendding');
        exit();
    }
    $_SESSION['errorMSG'] = 'Coba Di ulang deh!';
}
