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
    if ($sql->num_rows <= 0) {
        $_SESSION['errorMSG'] = 'Produk Ini Tidak Ada Dalam Whistlist!';
        header('Location: '. $siteURL .'/user/prodWishlist.php');
        exit();
    } else {
        $query = "DELETE FROM whistlist WHERE user_id = '$uid' AND product_id = '$id'";
        $sql = mysqli_query($conn, $query);
        if ($sql) {
            $_SESSION['successMSG'] = 'Success Remove Product From Whistlist!';
            header('Location: '. $siteURL .'/user/');
            exit();
        }

        $_SESSION['errorMSG'] = 'Delete Data Failed!';
    }
}
