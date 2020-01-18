<?php

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    die("Method Not Allowed");
}
require_once "../database.php";
require_once "./potion_repository.php";
require_once "../ingredients/ingredient_repository.php";
require_once "../ingredients/ingredientValidator.php";
require_once "../ingredients/changeIngredientService.php";

$array = $_POST;

if(!isset($array['name']) || !isset($array['amount'])){
    http_response_code(422);
    die();
}
$potionRep = new PotionRepository($dbConnection);
$ingredientRep = new IngredientRepository($dbConnection);
$validator = new IngredientValidator($ingredientRep);
$service = new ChangeIngredientService($ingredientRep, $validator);

$canBeDone = $service->removeFromStock($array['name'], $array['amount']);
if($canBeDone === false){
    http_response_code(422);
    die();
}

$potion = $potionRep->getPotion($array['name']);
$potionRep->updateAmount($potion, $array['amount']);
$amount = $array['amount'];
header("Content-Type: application/json");
echo json_encode(['amount'=> $amount]);