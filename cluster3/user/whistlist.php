<?php
session_start();
include './../inc/connection.php';
include './../inc/config.php';
include './../inc/auth.user.php';

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    $uid = $_SESSION['uid'];
    
    $query = "SELECT * FROM whistlist WHERE user_id = '$uid' AND product_id = '$id'";
    $sql = mysqli_query($conn, $query);
    if ($sql->num_rows > 0) {
        $_SESSION['errorMSG'] = 'Produk Ini Sudah Ada Dalam Keranjang!';
        header('Location: '. $siteURL .'/user/');
        exit();
    } else {
        $query = "INSERT INTO whistlist (user_id, product_id) VALUES ('$uid', '$id')";
        $sql = mysqli_query($conn, $query);
        if ($sql) {
            $_SESSION['successMSG'] = 'Success Add Product To Keranjang!';
            header('Location: '. $siteURL .'/user/');
            exit();
        }
    }
}
