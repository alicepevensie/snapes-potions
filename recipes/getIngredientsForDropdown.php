<?php

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    die("Method Not Allowed");
}
require_once "../database.php";
require_once "../ingredients/ingredient_repository.php";
if (isset($_POST['ingredients'])) {
    $ingredientRep = new IngredientRepository($dbConnection);
    http_response_code(201);
    header("Content-Type: application/json");
    $ingredientRep->getAllNames();
}
