<?php
require_once "../loggedIn.php";
require_once "../database.php";
require_once "./potion_repository.php";
require_once "./potion.php";
require_once "./potionValidator.php";
require_once "./potionsForPageService.php";
if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}
$categories = [
  "all potions", "potion", "draught", "antidote", "elixir", "paste", "pomade",
  "secretion", "balm", "solution", "essence", "mixture", "gas",
  "concoction", "unclassified"
];
$potionRep = new PotionRepository($dbConnection);
$potionsPerPage = 6;
$offset = ($page - 1) * $potionsPerPage;
$numberOfPotions = $potionRep->numberOfPotions();
$numberOfPages = ceil($numberOfPotions / $potionsPerPage);
$validator = new PotionValidator($potionRep);
$service = new PotionsForPageService($potionRep, $validator);
if (!isset($_GET['selectedCategory']) || ($_GET['selectedCategory'] === "all potions")) {
  $potions = $potionRep->potionsForPage($offset, $potionsPerPage);
} else {
  $potions = $service->potionsForPage($offset, $potionsPerPage, $_GET['selectedCategory']);
}
if ($page === 1)
  $prevPg = $page;
else
  $prevPg =  $page - 1;

if ($page === $numberOfPages)
  $nextPg = $numberOfPages;
else
  $nextPg = $page + 1;

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>Potions</title>

</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            Menu <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="../index.php">Homepage</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="potions.php">Potions</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../ingredients/ingredients.php">Ingredients</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../users/users.php?page=1">Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../logout.php">Log Out</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-3 mt-3">
        <a href="add_potion.php"><button type="button" class="btn btn-primary">Add Potion</button></a>
      </div>
      <div class="col-12 col-md-4 mt-3">
        <div class="form-group">
          <select class="form-control" id="sortCategory" onchange="location = this.value;">
            <option selected disabled>Select category</option>
            <?php foreach ($categories as $category) : ?>
              <option value="potions.php?selectedCategory=<?= $category ?>"><?= ucfirst($category) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="card-deck">
        <?php foreach ($potions as $potion) : ?>
          <div class="col-12 col-md-6 col-lg-4 col-xl-4 d-flex">
            <div class="card mb-2">
              <div class="card-header">
                <h5 class="card-title text-center"><?= $potion->getName() ?></h5>
              </div>
              <img src="../photos/potions/<?= $potion->getImage(); ?>" class="card-img-top img-fluid">
              <div class="card-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><?= $potion->getDescription() ?></li>
                  <li class="list-group-item"><?= $potion->getEffect() ?></li>
                  <li class="list-group-item"><?= ucfirst($potion->getCategory()) ?></li>
                </ul>
              </div>
              <div class="card-footer">
                <a href="../recipes/potionRecipe.php?recipeFor=<?= $potion->getName() ?>" class="btn btn-primary">See recipe</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Paginating -->
    <div class="row">
      <div class="col-12">
        <nav aria-label="page-navigation">
          <ul class="pagination pagination-sm justify-content-end mt-3">
            <li class="page-item prev">
              <a class="page-link" href="potions.php?page=<?= $prevPg ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for ($i = 1; $i <= $numberOfPages; $i++) : ?>
              <li class="page-item <?php if ($page === $i) echo "active" ?>"><a class="page-link" href="potions.php?page=<?= $i ?>"> <?= $i ?></a> </li>
            <?php endfor; ?>
            <li class="page-item next">
              <a class="page-link" href="potions.php?page=<?= $nextPg ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>