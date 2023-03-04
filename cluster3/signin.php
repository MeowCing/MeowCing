<?php
include './inc/connection.php';
include './inc/config.php';
include './inc/layouts/navbar.php';

$errorMSG = '';
$successMSG = '';
if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $sql = mysqli_query($conn, $query);
    if ($sql->num_rows == 0) {
        $errorMSG = 'Username <b>'. $username . '</b> is not registered!';
    } else {
        $md5pw = md5($password);
        $signin = "SELECT * FROM users WHERE username = '$username' AND password = '$md5pw'";
        $exec = mysqli_query($conn, $signin);
        $data = mysqli_fetch_assoc($exec);
        if ($exec) {
            $successMSG = 'Sign In Successfully!';
            $_SESSION['auth'] = true;
            $_SESSION['uid'] = $data['id'];
            $_SESSION['user'] = $data['username'];
            $_SESSION['role'] = $data['role'];
        } else {
            $errorMSG = 'Invalid Username or Password!';
        }
    }
}

if (isset($_SESSION['auth'])) {
    if ($_SESSION['auth'] == true && $_SESSION['role'] != 'admin') {
        header('Location: '. $siteURL .'/user/');
        exit();
    }

    if ($_SESSION['auth'] == true && $_SESSION['role'] != 'user') {
        header('Location: '. $siteURL .'/admin/');
        exit();
    }
}

?>

<main class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <form class="col-sm-3 rounded-3 shadow-sm pt-3 pb-3" method="POST" action="<?php echo $siteURL; ?>/signin.php">
            <h2 class="text-primary">Sign In | <?php echo $siteNAME; ?></h2>
            <?php include './inc/layouts/notification.php'; ?>
            <div class="mt-4 mb-3">
                <label for="username" class="mb-2 text-secondary">Username</label>
                <input type="text" name="username" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="password" class="mb-2 text-secondary">Password</label>
                <input type="password" name="password" class="form-control"/>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <a href="<?php echo $siteURL;?>" class="btn btn-light w-100 pt-2 pb-2">Back</a>
                </div>
                <div class="col-sm-9">
                    <button type="submit" name="signin" class="btn btn-primary w-100 pt-2 pb-2">Sign In</button>
                </div>
            </div>
        </form>
    </div>
</main>

<?php include './inc/layouts/footer.php'; ?>