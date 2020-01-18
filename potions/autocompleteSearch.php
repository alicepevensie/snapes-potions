<?php
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    die("Method Not Allowed");
}
require_once "../database.php";
require_once "./potion_repository.php";
if (isset($_POST['keyword'])) {
    $searchTerm = $_POST['keyword'];

    $potionRep = new PotionRepository($dbConnection);
    header("Content-Type: application/json");
    echo json_encode($potionRep->potionsForAutocomplete($searchTerm));
}
exit;
