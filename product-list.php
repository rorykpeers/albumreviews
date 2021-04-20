<?php

require_once '../src/setup.php';

// Search Term
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
}

$products = $dbProvider->getProducts($searchTerm);

$logger->info('Retrieved ' . count($products) . ' products for search: ' . $searchTerm);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'template_parts/header_includes.php' ?>
    <title>Album List</title>
</head>
<body>
<style>
    h1{
        text-align: center;
    }

    body{
        background-color: lightgray;
    }

    .searchBar{
        position: relative;
        left: 220px;
        top: 2px;
    }

    .searchTitle{
        position: relative;
        left: 150px;
        top: 40px;
    }

    .searchButton{
        position: relative;
        left: 430px;
    }
</style>
<div class="container">
    <?php include 'template_parts/navbar.php' ?>
    <h1>Albums</h1>
    <form method="post">
        <div class="form-group" style="width: 500px">
            <div class="searchTitle">
            <label for="search">Search:</label>
            </div>
            <div class="searchBar">
            <input type="text" id="search" name="search" value="<?= $searchTerm ?>" class="form-control">
            </div>
            <br>
            <div class="searchButton">
            <input type="submit">
            </div>

    </form>
    </div>
    <?php
    if (count($products)) {
        echo count($products) . ' result' . (count($products) === 1 ? '' : 's') . ' found';
    }
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Artist</th>
            <th>Genre</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($products as $product): ?>
        <tr>
            <td><a href="product.php?productId=<?= $product->id; ?>"><?= $product->id; ?></a></td>
            <td><?= $product->title ?></td>
            <td><?= $product->artist ?></td>
            <td><?= $product->genre ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php include 'template_parts/footer_includes.php'; ?>
</body>
</html>
