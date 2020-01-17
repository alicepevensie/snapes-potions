<?php
require_once "../loggedIn.php";
require_once "../database.php";
require_once "./user.php";
require_once "./user_repository.php";

if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
} else {
    $page = 1;
}
$userRep = new userRepository($dbConnection);
$usersPerPage = 7;
$offset = ($page - 1) * $usersPerPage;
$numberOfusers = $userRep->numberOfUsers();
$numberOfPages = intval(ceil($numberOfusers / $usersPerPage));
$users = $userRep->usersForPage($offset, $usersPerPage);
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

    <title>Users</title>
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
                                <a class="nav-link" href="../ingredients/ingredients.php">Ingredients</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="users.php?page=1">Users</a>
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
                    <table class="table table-sm table-striped table-hover mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Birth Date</th>
                                <th>Created At</th>
                                <th>House</th>
                                <th>Status</th>
                                <th>Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $user->getName() . " " . $user->getSurname(); ?></td>
                                    <td><?= $user->getUsername(); ?></td>
                                    <td><?= $user->getBirth_date(); ?></td>
                                    <td><?= $user->getCreated_at(); ?></td>
                                    <td><?= $user->getHouse(); ?></td>
                                    <td><?= $user->getStatus(); ?></td>
                                    <td>
                                        <?php if ($user->getAccess() != 0 && $user->getId() != 2) : ?>
                                            <form action="revokeAccess.php?page=<?= $page ?>" method="POST">
                                                <input type="hidden" id="userId" name="userId" value="<?= $user->getId() ?>">
                                                <button type="submit" class="btn btn-secondary" id="revokeAccessButton">Revoke access</button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if ($user->getAccess() != 1) : ?>
                                            <form action="grantAccess.php?page=<?= $page ?>" method="POST">
                                                <input type="hidden" id="userId" name="userId" value="<?= $user->getId() ?>">
                                                <button type="submit" class="btn btn-success" id="grantAccessButton">Grant access</button>
                                            </form>
                                        <?php endif; ?></td>
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
                    <ul class="pagination pagination-sm justify-content-end mt-3">
                        <li class="page-item prev">
                            <a class="page-link" href="users.php?page=<?= $prevPg ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $numberOfPages; $i++) : ?>
                            <li class="page-item <?php if ($page === $i) echo "active" ?>"><a class="page-link" href="users.php?page=<?= $i ?>"> <?= $i ?></a> </li>
                        <?php endfor; ?>
                        <li class="page-item next">
                            <a class="page-link" href="users.php?page=<?= $nextPg ?>" aria-label="Next">
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>