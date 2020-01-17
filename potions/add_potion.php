<?php
require_once "../loggedIn.php";
require_once "../database.php";

$categories = [
    "potion", "draught", "antidote", "elixir", "paste", "pomade",
    "secretion", "balm", "solution", "essence", "mixture", "gas",
    "concoction", "unclassified"
];
$errors = [];
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
$old = [];
if (isset($_SESSION['prevData'])) {
    $old = $_SESSION['prevData'];
    unset($_SESSION['prevData']);
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

    <title>Add Potion</title>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card bg-light mb-3 mt-4">
                    <div class="card-header">
                        <h5>Add new potion!</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['noPotionHere'])) : ?>
                            <div class="alert alert-warning" role="alert"><?= $_SESSION['noPotionHere'] ?></div>
                        <?php endif; unset($_SESSION['noPotionHere']); ?>
                        <form action="store_potion.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nameInput">Name:</label>
                                <input class="form-control" type="text" id="nameInput" name="name" value="<?= isset($old["name"]) ? $old["name"] : '' ?>">
                                <?php if (isset($errors['nameExists']) && !isset($errors['name'])) : ?>
                                    <div style="color:#c71312;"><?= $errors['nameExists'] ?> </div>
                                <?php endif; ?>
                                <?php if (isset($errors['name']) && !isset($errors['nameExists'])) : ?>
                                    <div style="color:#c71312;"><?= $errors['name'] ?> </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="nameInput">Description:</label>
                                <textarea class="form-control" id="descriptionInput" name="description" rows="3"><?= isset($old["description"]) ? $old["description"] : '' ?></textarea>
                                <?php if (isset($errors['description'])) : ?>
                                    <div style="color:#c71312;"><?= $errors['description'] ?> </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="nameInput">Effect:</label>
                                <textarea class="form-control" id="effectInput" name="effect" rows="3"><?= isset($old["effect"]) ? $old["effect"] : '' ?></textarea>
                                <?php if (isset($errors['effect'])) : ?>
                                    <div style="color:#c71312;"><?= $errors['effect'] ?> </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="categoryInput">Select a category:</label>
                                <select class="form-control" name="category" id="categoryInput">
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category ?>" <?php if ((isset($old['category'])) && ($old['category'] === $category)) echo 'selected' ?>><?= ucfirst($category) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['category'])) : ?>
                                    <div style="color:#c71312;"><?= $errors['category'] ?> </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="amountInput">How many bottles/boxes do you currently have?</label>
                                <input type="number" class="form-control" id="amountInput" name="amount" min="0" step="1" value="<?= isset($old["amount"]) ? $old["amount"] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="imageInput">Add image: </label>
                                <input type="file" class="form-control-file" id="imageInput" name="image">
                                <?php if (isset($errors['imageExists']) && !isset($errors['image'])) : ?>
                                    <div style="color:#c71312;"><?= $errors['imageExists'] ?> </div>
                                <?php endif; ?>
                                <?php if (isset($errors['image']) && !isset($errors['imageExists'])) : ?>
                                    <div style="color:#c71312;"><?= $errors['image'] ?> </div>
                                <?php endif; ?>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        </form>
                        <a href="potions.php"><button class="btn btn-secondary">Cancel</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>