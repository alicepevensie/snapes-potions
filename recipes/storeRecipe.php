<?php

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    die("Method Not Allowed");
}
session_start();
require_once "../database.php";
require_once "./recipeValidator.php";
require_once "./recipe_repository.php";
require_once "./recipeService.php";

$recipeRep = new RecipeRepository($dbConnection);
$validator = new RecipeValidator();
$service = new RecipeStorage($recipeRep, $validator);

$feedback = $service->storeRecipe($_POST);
if ($feedback['allGood'] === false) {
    $_SESSION['feedback'] = $feedback;
    $name = $_POST['potionName'];
    header("Location: potionRecipe.php?recipeFor=$name");
    die();
}
$_SESSION['feedback'] = $feedback;
$name = $_POST['potionName'];
header("Location: potionRecipe.php?recipeFor=$name");
die();
