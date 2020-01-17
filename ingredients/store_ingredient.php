<?php

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    die("Method Not Allowed");
}
session_start();
require_once "../database.php";
require_once "./ingredient_repository.php";
require_once "./ingredientValidator.php";
require_once "./changeIngredientService.php";
$ingredientRep = new IngredientRepository($dbConnection);
$validator = new IngredientValidator($ingredientRep);
$service = new ChangeIngredientService($ingredientRep, $validator);
$feedback = $service->storeIngredient($_POST, $_FILES);
if($feedback['somethingWrong']){
    http_response_code(422);
    echo json_encode($feedback);
    exit;
}

http_response_code(201);