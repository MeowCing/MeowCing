<?php
session_start();
include './../inc/connection.php';
include './../inc/config.php';
include './../inc/auth.admin.php';

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    $query = "DELETE FROM products WHERE id = '$id'";
    $sql = mysqli_query($conn, $query);
    if ($sql) {
        $query = "DELETE orders, whistlist FROM orders INNER JOIN whistlist ON orders.product_id=whistlist.product_id WHERE orders.product_id = $id";
        $sql = mysqli_query($conn, $query);
        if ($sql) {
            $_SESSION['successMSG'] = 'Delete Data Successfully!';
            header('Location: '. $siteURL .'/admin/');
            exit();
        }
    }

    $_SESSION['errorMSG'] = 'Delete Data Failed!';
}
