<?php

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    die("Method Not Allowed");
}
require_once "../database.php";
require_once "./potion_repository.php";

if(!isset($_POST['name']) || !isset($_POST['amount'])){
    http_response_code(422);
    die();
}
$potionRep = new PotionRepository($dbConnection);

if(!$potionRep->potionExists($_POST['name'])){
    http_response_code(422);
    die();
}
if($_POST['amount']<=0){
    http_response_code(422);
    die();
}

$potionRep->updateAmount($_POST['name'], $_POST['amount']);
echo json_encode(['amount'=> $_POST['amount']]);