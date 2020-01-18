<?php

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    die("Method Not Allowed");
}
require_once "../database.php";
require_once "./ingredient_repository.php";
require_once "./ingredient.php";
require_once "./ingredientValidator.php";
$array = $_POST;
if (!isset($array['ingName']) || !isset($array['ingAmountCalc'])) {
    http_response_code(422);
    die();
}
$ingredientRep = new IngredientRepository($dbConnection);
$validator = new IngredientValidator($ingredientRep);

if (($validator->validateName($array['ingName']) === false) || ($ingredientRep->ingredientExists($array['ingName']) === false) || ($validator->validateUpdateAmount($array['ingAmountCalc']) === false)) {
    http_response_code(423);
    die();
}


$ingredient = $ingredientRep->selectIngredient($array['ingName']);

if ($ingredient->getAmount() < $array['ingAmountCalc']) {
    $thingie = "You don't have enough of this ingredient for selected amount of potion.";
    header("Content-Type: application/json");

    echo json_encode(["newAmount" => $thingie]);
    die();
} else {
    $thingie = $array['ingAmountCalc'];
    header("Content-Type: application/json");

    echo json_encode(["newAmount" => $thingie]);
    die();
}
