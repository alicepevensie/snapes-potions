<?php
session_start();
require_once "../database.php";
require_once "../users/user_repository.php";
require_once "registrationService.php";
require_once "registrationValidation.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: register.php');
    die();
} else {
    $userRep = new UserRepository($dbConnection);
    $validator = new RegistrationValidator($userRep);
    $service = new RegistrationService($userRep, $validator);
    $result = $service->register($_POST);
    if ($result['somethingWrong'] === false) {
        $_SESSION['success'] = "You have registered successfully. It may take some time for professor Snape to approve your request.";
        header('Location: login.php');
        die();
    } else {
        $_SESSION['errors'] = $result;
        header('Location: register.php');
        die();
    }
}
