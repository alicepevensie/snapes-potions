<?php
session_start();
require_once "../database.php";
require_once "loginService.php";
require_once "../users/user_repository.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}
$userRep = new UserRepository($dbConnection);

$service = new LoginService($userRep);

$result = $service->logIn($_POST);

if ($result === false) {
    $_SESSION['logError'] = "Incorrect username or password";
    header("Location: login.php");
    die();
}
$_SESSION['loggedIn'] = $result;
header('Location: ../index.php');
exit();
