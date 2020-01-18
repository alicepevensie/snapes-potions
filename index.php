<?php

session_start();
require_once "./users/user.php";
require_once "./users/user_repository.php";
require_once "./database.php";
if (!isset($_SESSION['loggedIn'])) {
  $_SESSION['hasntLogged'] = "Please log in or register to continue.";
  header('Location: login_register/login.php');
  die();
}

$userRep = new UserRepository($dbConnection);
$user = $userRep->selectUser($_SESSION['loggedIn']);

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  </link>
  <title>Homepage</title>
</head>

<body>

  <?php if ($user->getAccess() != 1) { ?>
    <p>Your request for registration will soon be reviewed by Professor Snape. Please wait patiently.</p>
  <?php } else { ?>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              Menu <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <?php if ($user->getId() === 2) : ?>
                  <li class="nav-item">
                    <a class="nav-link active" href="index.php">Homepage</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="potions/potions.php">Potions</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="ingredients/ingredients.php">Ingredients</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="users/users.php">Users</a>
                  </li>
                <?php endif; ?>
                <li class="nav-item">
                  <a class="nav-link" href="logout.php">Log Out</a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <?php if (isset($_SESSION['breachAttempt'])) : ?>
            <div class="alert alert-danger mt-2 text-center" role="alert"><?= $_SESSION['breachAttempt'] ?></div>
          <?php endif;
          unset($_SESSION['breachAttempt']); ?>
          <?php if (isset($_SESSION['noPotionThere']) && $_SESSION['loggedIn'] != 2) : ?>
            <div class="alert alert-danger mt-2 text-center" role="alert"><?= $_SESSION['noPotionThere'] ?></div>
          <?php endif;
          unset($_SESSION['noPotionThere']); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="ui-widget text-center mt-5" style="text-align:center">
            <input autocomplete="off" type='text' id="potionSearch" class="form-control text-center" placeholder="Enter name of a potion you're looking for"><br>
            <div id="suggesstion-box"></div>
            <button class="btn btn-success mt-1" id="searchPotion" type="button">
              <i class="fa fa-search">Search</i>
            </button>
          </div>
        </div>
      </div>
    </div>
    </div>
  <?php } ?>

  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {

      var potions;
      $("#potionSearch").keyup(function() {
        $.ajax({
          type: "POST",
          url: "potions/autocompleteSearch.php",
          data: {keyword: $(this).val() },
          success: function(response) {
            potions = response;
            $("#potionSearch").autocomplete({source: potions});
          }
        });
      }); 

      var saveBtn = $('#searchPotion');
      saveBtn.click(function() {
        inputval = $('#potionSearch').val();
        window.location = './recipes/potionRecipe.php?recipeFor=' + inputval;
      });
    });
  </script>
</body>

</html>