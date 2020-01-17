<?php

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    die("Method Not Allowed");
}

require_once "../database.php";
require_once "./user_repository.php";

$userId = $_POST["userId"];

$userRep = new UserRepository($dbConnection);
if (!$userRep->userExists($userId)) {
    $error = "Something went wrong!";
    exit;
}
$user = $userRep->selectUser($userId);
if (!$user->getAccess()) {
    $error = "Something went wrong!";
    exit;
}
$page = $_GET['page'];
$userRep->revokeAccess($user);
header("Location: users.php?page=$page");
die();
