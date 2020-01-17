<?php

session_start();
if (isset($_SESSION['loggedIn'])) {
    header('Location: ../index.php');
    exit();
}
$errors = [];
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
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

    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card bg-light mb-3 mt-4">
                    <div class="card-header">
                        <h3>Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <form action="registerUser.php" method="POST">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="nameInput">Name</label>
                                        <input type="text" class="form-control" id="nameInput" name="name" />
                                        <?php if (isset($errors['name'])) : ?>
                                            <div style="color:#c71312;"><?= $errors['name'] ?> </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="surnameInput">Surname</label>
                                        <input type="text" class="form-control" id="surnameInput" name="surname" />
                                        <?php if (isset($errors['surname'])) : ?>
                                            <div style="color:#c71312;"><?= $errors['surname'] ?> </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="usernameInput">Username</label>
                                        <input type="text" class="form-control" id="usernameInput" name="username" />
                                        <?php if (isset($errors['usernameExists']) && !isset($errors['username'])) : ?>
                                            <div style="color:#c71312;"><?= $errors['usernameExists'] ?> </div>
                                        <?php endif; ?>
                                        <?php if (isset($errors['username']) && !isset($errors['usernameExists'])) : ?>
                                            <div style="color:#c71312;"><?= $errors['username'] ?> </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="birthDateInput">Birth Date</label>
                                        <input type="date" class="form-control" id="birthDateInput" name="birthdate" max="2009-01-01" min="1800-01-01" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="passwordInput">Password</label>
                                        <input type="password" class="form-control" id="passwordInput" name="password" />
                                        <?php if (isset($errors['password'])) : ?>
                                            <div style="color:#c71312;"><?= $errors['password'] ?> </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="repeatPasswordInput">Repeat password</label>
                                        <input type="password" class="form-control" id="repeatPasswordInput" name="passwordConfirm" />
                                        <?php if (isset($errors['passwordMatch'])) : ?>
                                            <div style="color:#c71312;"><?= $errors['passwordMatch'] ?> </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="hogwartsHouseInput">Please select your house:</label>
                                <select class="form-control" id="hogwartsHouseInput" name="house">
                                    <option value="Slytherin">Slytherin</option>
                                    <option value="Hufflepuff">Hufflepuff</option>
                                    <option value="Ravenclaw">Ravenclaw</option>
                                    <option value="Gryffindor">Gryffindor</option>
                                </select>
                                <?php if (isset($errors['house'])) : ?>
                                    <div style="color:#c71312;"><?= $errors['house'] ?> </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="statusInput">Please select your position at Hogwarts:</label>
                                <select class="form-control" id="statusInput" name="status">
                                    <option value="Professor">Professor</option>
                                    <option value="Student">Student</option>
                                    <option value="Other">Other</option>
                                </select>
                                <?php if (isset($errors['status'])) : ?>
                                    <div style="color:#c71312;"><?= $errors['status'] ?> </div>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </form>
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