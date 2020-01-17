<?php

session_start();
if (isset($_SESSION['loggedIn'])) {
    header('Location: ../index.php');
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Welcome!</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card bg-light mb-3 mt-4">
                    <div class="card-header">
                        <h5>Log In</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['hasntLogged'])) : ?>
                            <div class="alert alert-info" role="alert"><?= $_SESSION['hasntLogged'] ?></div>
                        <?php endif;
                        unset($_SESSION['hasntLogged']); ?>
                        <?php if (isset($_SESSION['success'])) : ?>
                            <div class="alert alert-success" role="alert"><?= $_SESSION['success'] ?></div>
                        <?php endif;
                        unset($_SESSION['success']); ?>
                        <form action="verify.php" method="POST">
                            <div class="form-group">
                                <label for="usernameInput">Username</label>
                                <input type="text" class="form-control" id="usernameInput" name="username" />
                                <div id="usernameErrorPlaceholder"></div>
                            </div>
                            <div class="form-group">
                                <label for="passwordInput">Password</label>
                                <input type="password" class="form-control" id="passwordInput" name="password" />
                                <div id="passwordErrorPlaceholder"></div>
                            </div>
                            <?php if (isset($_SESSION['logError'])) : ?>
                                <div class="alert alert-danger" role="alert"><?= $_SESSION['logError'] ?></div>
                            <?php endif;
                            unset($_SESSION['logError']); ?>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Log In</button>
                        </form>
                        <a href="register.php"><button type="button" class="btn btn-primary">Register</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>