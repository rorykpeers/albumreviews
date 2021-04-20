<?php

require_once '../src/setup.php';

if (isset($_POST['email'], $_POST['password'])) {
    $user = $dbProvider->getUserByEmail($_POST['email']);

    if ($user && password_verify($_POST['password'], $user->password)) {
        //logged in
        $_SESSION['loginId'] = $user->id;
        header('Location: product-list.php');
        exit;

    } else {
        $errorMessage = 'Incorrect details, please try again';
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'template_parts/header_includes.php'; ?>
    <title>Login in</title>
</head>
<style>
    h1{
        text-align: center;
        margin-top: 10px;
    }

    body{
        background-color: lightgray;
    }

    .containerForm{
        position: relative;
        top: 20px;
        left: 170px;
    }

    .loginButton{
        position: relative;
        top: 20px;
        right: 160px;
    }
</style>
<body class="p-4">
<div class="container">
    <?php include 'template_parts/navbar.php'; ?>
    <h1>Log In</h1>
    <?php if (isset($errorMessage)): ?>
    <div class="alert alert-warning"><?= $errorMessage ?></div>
    <?php endif; ?>
    <form method="post" autocomplete="off">
            <div class="containerForm">
            <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="email-input">Email Address</label>
                    <input name="email" type="email" class="form-control" id="email-input" value="<?= $_POST['email'] ?? '' ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="password-input">Password</label>
                    <input name="password" type="password" class="form-control" id="password-input">
                </div>
            </div>
            </div>
                <div class="loginButton">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Log In</button>
            </div>
            </div>
        </div>
    </form>

</div>
    <?php include 'template_parts/footer_includes.php'; ?>
</body>
</html>
