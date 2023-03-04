<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteNAME; ?></title>
    <link rel="stylesheet" href="<?php echo $siteURL; ?>/src/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-warning shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?php echo $siteURL; ?>"><?php echo $siteNAME; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (isset($_SESSION['role'])) { 
                if ($_SESSION['role'] == 'admin'){ 
        ?>
          <!-- Admin -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $siteURL; ?>/admin/" aria-current="page">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $siteURL; ?>/admin/order.php?status=pendding" aria-current="page">Order Pendding</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $siteURL; ?>/admin/order.php?status=confirmed" aria-current="page">Order Confirmed</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $siteURL; ?>/admin/wishlist.php">keranjang</a>
          </li>

        <?php
              } else {
        ?>
          <!-- User -->
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $siteURL; ?>/user/" aria-current="page">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $siteURL; ?>/user/prodWishlist.php" aria-current="page">keranjang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $siteURL; ?>/user/prodOrder.php" aria-current="page">Order</a>
            </li>
        <?php
              }
        } else {
        ?>
          <!-- User -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $siteURL; ?>/">Beranda</a>
          </li>
        <?php } ?>
      </ul>
      
      <div class="d-flex">
        <?php
        if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth']) {
        ?>
            <a href="<?php echo $siteURL; ?>/signout.php" class="btn btn-outline-dark">Logout</a>
        <?php
            }
        } else {
        ?>
            <a href="<?php echo $siteURL; ?>/signup.php" class="btn btn-outline-dark me-2">Daftar</a>
            <a href="<?php echo $siteURL; ?>/signin.php" class="btn btn-outline-dark">Masuk</a>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</nav>
