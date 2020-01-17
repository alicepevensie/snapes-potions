<?php

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: add_potion.php');
    die("Method Not Allowed");
}
session_start();
require_once "../database.php";
require_once "./potion_repository.php";
require_once "./potionValidator.php";
require_once "./potionStorageService.php";
$potionRep = new PotionRepository($dbConnection);
$validator = new PotionValidator($potionRep);
$service = new PotionStorageService($potionRep, $validator);
$feedback = $service->storePotion($_POST, $_FILES);
if($feedback['somethingWrong']){
    $_SESSION['errors'] = $feedback;
    $_SESSION['prevData'] = $service->prevValues($_POST);
    header('Location: add_potion.php');
    die();
}

header('Location: potions.php');
die();