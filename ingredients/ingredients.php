<?php
require_once "../loggedIn.php";
require_once "../database.php";
require_once "./ingredient.php";
require_once "./ingredient_repository.php";

if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
} else {
    $page = 1;
}
$ingredientRep = new IngredientRepository($dbConnection);
$ingredientsPerPage = 5;
$offset = ($page - 1) * $ingredientsPerPage;
$numberOfingredients = $ingredientRep->numberOfIngredients();
$numberOfPages = intval(ceil($numberOfingredients / $ingredientsPerPage));
$ingredients = $ingredientRep->ingredientsForPage($offset, $ingredientsPerPage);
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

    <title>Ingredients</title>
    <style>
        .table th {
            text-align: center;
        }

        .table td {
            text-align: center;
        }
    </style>
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
                                <a class="nav-link" href="../potions/potions.php">Potions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="./ingredients.php">Ingredients</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../users/users.php">Users</a>
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
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mt-4">
                        <thead>
                            <tr>
                                <th><button type="button" class="btn btn-info" data-toggle="modal" data-target="#createIngredientForm">New Ingredient</button></th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Update amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ingredients as $ingredient) : ?>
                                <tr>
                                    <td><img class="img-fluid" src="../photos/ingredients/<?= $ingredient->getImage(); ?>" alt=""></td>
                                    <td><?= $ingredient->getName(); ?></td>
                                    <td><?= $ingredient->getDescription(); ?></td>
                                    <td><?= $ingredient->getAmount() ?> <?= $ingredient->getUnit() ?></td>
                                    <td>
                                        <div class="update-amount">
                                            <input type="number" id="updateAmountInput" />
                                            <button type="submit" class="btn btn-info btn-sm mt-1" id="updateAmountBtn">Save</button>
                                            <button type="button" class="btn btn-secondary btn-sm mt-1" id="cancelBtn">Cancel</button>
                                        </div>
                                        <button class="btn btn-info btn-sm updateBtn" id="updateBtn">Update</button>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Paginating -->
        <div class="row">
            <div class="col-12">
                <nav aria-label="page-navigation">
                    <ul class="pagination pagination-sm justify-content-end mt-3" id="pagination">
                        <li class="page-item prev">
                            <a class="page-link" href="ingredients.php?page=<?= $prevPg ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $numberOfPages; $i++) : ?>
                            <li class="page-item <?php if ($page === $i) echo "active" ?>"><a class="page-link" href="ingredients.php?page=<?= $i ?>"><?= $i ?></a> </li>
                        <?php endfor; ?>
                        <li class="page-item next">
                            <a class="page-link" href="ingredients.php?page=<?= $nextPg ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="createIngredientForm" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createIngredientFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createIngredientFormLabel">New ingredient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form id="ingredient-form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="nameInput">Name</label>
                                        <input type="text" class="form-control" id="nameInput" name="name">
                                        <div id="nameErrorPlaceholder"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="descriptionInput">Description</label>
                                        <textarea rows="6" class="form-control" id="descriptionInput" name="description"></textarea>
                                        <div id="descriptionErrorPlaceholder"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="unitInput">Which measure unit would you like to use for this ingredient?</label>
                                        <input type="text" class="form-control" id="unitInput" name="unit" placeholder="i.e. gram, plant, hair, liter...">
                                        <div id="unitErrorPlaceholder"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="amountInput">How much/many do you currently have?</label>
                                        <input type="number" class="form-control" id="amountInput" name="amount" min="0" step="1">
                                        <div id="amountErrorPlaceholder"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="imageInput">Add image: </label>
                                        <input type="file" class="form-control-file" id="imageInput" name="image">
                                        <div id="imageErrorPlaceholder"></div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveIngredientBtn">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="updateAmount.js"></script>
    <script src="addIngredient.js"></script>

</body>

</html>