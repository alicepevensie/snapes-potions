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

$done = $service->changeAmount($_POST);
if ($done === false) {
    http_response_code(422);
    exit;
}
http_response_code(201);
header("Content-Type: application/json");
$page = $_POST['page'];
echo json_encode(["page" => $page]);
