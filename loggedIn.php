<?php
session_start();

if (!isset($_SESSION['loggedIn'])) {
  $_SESSION['hasntLogged'] = "Please log in or register to continue.";
  header('Location: login_register/login.php');
  die();
}
if ($_SESSION['loggedIn'] != 2) {
  $_SESSION['breachAttempt'] = "You do not have access to that part of website!";
  header('Location: ../index.php');
  die();
}