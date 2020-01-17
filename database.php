<?php

$host = "127.0.0.1";
$username = "root";
$password = "";
$databaseName = "snapes_potions";

$dbConnection = new mysqli($host, $username, $password, $databaseName);

if($dbConnection->connect_error) {
    die("Failed to connect to database: {$dbConnection->connect_error}");
}