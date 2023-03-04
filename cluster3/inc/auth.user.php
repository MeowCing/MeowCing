<?php
if (isset($_SESSION['auth'])) {
    if ($_SESSION['auth'] == true && $_SESSION['role'] != 'user') {
        header('Location: '. $siteURL .'/admin/');
        exit();
    } else {}
} else {
    header('Location: '. $siteURL .'/signin.php');
}
?>