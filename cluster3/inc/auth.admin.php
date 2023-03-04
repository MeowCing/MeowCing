<?php
if (isset($_SESSION['auth'])) {
    if ($_SESSION['auth'] == true && $_SESSION['role'] != 'admin') {
        header('Location: '. $siteURL .'/user/');
        exit();
    } else {}
} else {
    header('Location: '. $siteURL .'/signin.php');
}
?>