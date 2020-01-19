<?php
session_start();

if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['hasntLogged'] = "Please log in or register to continue.";
    header('Location: login_register/login.php');
    die();
}
require_once "../database.php";
require_once "./recipe_repository.php";
require_once "../potions/potion_repository.php";
require_once "./recipeIngredient.php";
require_once "./recipeInstruction.php";
require_once "../users/user_repository.php";
require_once "../users/user.php";
$userRep = new UserRepository($dbConnection);
$user = $userRep->selectUser($_SESSION['loggedIn']);
$recipeRep = new RecipeRepository($dbConnection);
$potionRep = new PotionRepository($dbConnection);

if (!isset($_GET['recipeFor'])) {
    header('Location: ../potions/potions.php');
    die();
}
if ($potionRep->potionExists($_GET['recipeFor']) === false) {
    if ($_SESSION['loggedIn'] === 2) {
        $_SESSION['noPotionHere'] = "You tried to access a non-existent potion. Add new potion, please.";
        header('Location: ../potions/add_potion.php');
        die();
    }
    $_SESSION['noPotionThere'] = "That potion doesn't exist!";
    header('Location: ../index.php');
    die();
}
$potionName = $_GET['recipeFor'];
$showRecipe = false;
if ($recipeRep->recipeExists($potionName) && $recipeRep->instructionsExists($potionName)) {
    $recipeIngredients = $recipeRep->getIngredientsForPotion($potionName);
    $instructions = $recipeRep->getInstructionsForPotion($potionName);
    $showRecipe = true;
}

if (isset($_SESSION['feedback'])) {
    $storeFeedback = $_SESSION['feedback'];
    unset($_SESSION['feedback']);
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title><?= $potionName ?></title>
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
                            <?php if ($user->getId() === 2) : ?>
                                <li class="nav-item">
                                    <a class="nav-link active" href="../potions/potions.php">Potions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../ingredients/ingredients.php">Ingredients</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../users/users.php?page=1">Users</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../logout.php">Log Out</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <?php if ($showRecipe === false) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info mt-3" role="alert"> The recipe for this potion doesn't exist!</div>
                </div>
            </div>
            <?php if ($user->getId() === 2) : ?>
                <div class="row">
                    <div class="col-12 text-center"><button class="btn btn-info mt-2" id="addRecipeBtn">Add recipe</button></div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <form id="recipeForm" action="storeRecipe.php" method="POST">
                            <?php if (isset($storeFeedback['recipeExists'])) : ?>
                                <div class="alert alert-danger mt-2"><?= $storeFeedback ?></div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="potionName">Potion name</label>
                                <input type="text" readonly class="form-control-plaintext" id="potionName" name="potionName" value="<?= $potionName ?>">
                            </div>
                            <div id="bigWrapper">
                                <div id="wrapper">
                                    <?php if (isset($storeFeedback['addOne'])) { ?>
                                        <div class="alert alert-danger" role="alert"><?= $storeFeedback['addOne'] ?></div>
                                    <?php } else { ?>
                                        <?php if (isset($storeFeedback['missmatch'])) : ?>
                                            <div class="alert alert-danger"><?= $storeFeedback['missmatch'] ?></div>
                                        <?php endif; ?>
                                        <?php if (isset($storeFeedback['nonExistentIngredient'])) : ?>
                                            <div class="alert alert-danger"><?= $storeFeedback['nonExistentIngredient'] ?></div>
                                        <?php endif; ?>
                                        <?php if (isset($storeFeedback['amountError'])) : ?>
                                            <div class="alert alert-danger"><?= $storeFeedback['amountError'] ?></div>
                                        <?php endif; ?>

                                    <?php } ?>
                                </div>
                                <div class="control-btns">
                                    <button type="button" class="btn btn-info btn-sm" id="addIngredientBtn">Add ingredient</button>
                                    <button type="button" class="btn btn-danger btn-sm" id="removeIngredientBtn">Remove last ingredient</button>
                                </div>
                            </div>
                            <hr>
                            <div id="togglers" class="mt-2">
                                <button type="button" class="btn btn-sm btn-info" id="toggleInstructionsBtn">Show/hide instructions</button>
                                <button type="button" class="btn btn-sm btn-info" id="toggleIngredientsBtn">Show/hide ingredients</button>
                            </div>
                            <hr>
                            <div id="instructionsSection">
                                <div id="instructionsWrapper">
                                <?php if (isset($storeFeedback['addOnePls'])) { ?>
                                        <div class="alert alert-danger" role="alert"><?= $storeFeedback['addOnePls'] ?></div>
                                    <?php } else { ?>
                                        <?php if (isset($storeFeedback['instructionLength'])) : ?>
                                            <div class="alert alert-danger"><?= $storeFeedback['instructionLength'] ?></div>
                                        <?php endif; ?>
                                    <?php } ?>

                                </div>
                                <div id="instructions-control-btns" class="mt-2">
                                    <button type="button" class="btn btn-info btn-sm" id="addInstructionBtn">Add instruction</button>
                                    <button type="button" class="btn btn-danger btn-sm" id="removeInstructionBtn">Remove last instruction</button>
                                </div>
                                <hr>

                            </div>
                            <div>
                                <button type="submit" class="btn btn-success btn-sm mt-2">Save recipe</button>
                            </div>
                        </form>

                    </div>
                </div>

            <?php endif; ?>
        <?php } else { ?>
            <div class="row">
                <div class="col-12 mt-4 mb-3">
                    <h4><?= $potionName ?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-hover" id="ingredientTable">
                            <?php if (isset($storeFeedback['success'])) : ?>
                                <div class="alert alert-success"><?= $storeFeedback['success'] ?></div>
                            <?php endif; ?>
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <div class="form-inline"> <span>How many bottles of this potion would you like to make?</span>
                                            <div class="form-group mx-sm-3"><input class="form-control form-control-sm" id="potionAmount" type="number" min="1" step="1" value="1"></div>
                                            <input type="hidden" id="potionName2" value="<?= $potionName ?>">
                                            <?php if ($user->getId() === 2) : ?>
                                                <button class="btn btn-sm btn-success" id="addPotionsBtn">Store created potions</button>
                                            <?php endif; ?>
                                        </div>
                                    </th>
                                    <th>
                                        <button class="btn btn-sm btn-secondary" id="calculateIngredients">Calculate needed amount</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Ingredient name</th>
                                    <th>Ingredient amount</th>
                                    <th>Needed amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recipeIngredients as $ingredient) : ?>
                                    <tr>
                                        <td><?= $ingredient->getIngredient_name() ?></td>
                                        <td><?= $ingredient->getIngredient_amount() ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">Please keep in mind that given instructions contain measures for making 1 bottle of potion.
                        If you intend on making more than 1 bottle, please use measures provided in 'Needed amount' column.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="list-group-flush">
                        <?php foreach ($instructions as $instruction) : ?>
                            <li class="list-group-item"><?= $instruction->getStep() ?>. <?= $instruction->getStep_description() ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>


        <?php } ?>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="potionRecipe.js" type='text/javascript'></script>
</body>

</html>