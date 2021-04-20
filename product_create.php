<?php

use App\Entity\Product;

require_once '../src/setup.php';

if (!empty($_POST['title']) && !empty($_POST['artist'])) {
    if ($_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $imageName = time() . '_' . $_FILES['image_path']['name'];

        move_uploaded_file($_FILES['image_path']['tmp_name'], 'uploads/' . $imageName);

        $formData = [
            'title' => strip_tags($_POST['title']),
            'artist' => strip_tags($_POST['artist']),
            'genre' => strip_tags($_POST['genre']),
            'image_path' => $imageName,
        ];

        $formProduct = new Product();
        $formProduct->title = $formData['title'];
        $formProduct->artist = $formData['artist'];
        $formProduct->genre = $formData['genre'];
        $formProduct->imagePath =$formData['image_path'];

        //Create Product
        $product = $dbProvider->createProduct($formProduct);
        $logger->info('Product created: ' . $product->title);
        header('Location: product.php?productId=' . $product->id);
        exit;
    }
    $error = $_FILES['image_path']['error'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'template_parts/header_includes.php'; ?>
    <title>Your Album to Review</title>
</head>
<body>
<div class="container">
    <?php include 'template_parts/navbar.php'; ?>

        <h1>Your Album</h1>
        <?php
        if (!empty($error)) {
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    echo 'The image was too large, please keep it less than ' . ini_get('upload_max_filesize');
                    break;
            }
        }
        ?>
        <form method="post" enctype="multipart/form-data">
            <div class="col-md-6 col-sm-12 text-center">
                <label for="image">Image</label>
                <input type="file" accept="image/png, image/jpeg" name="image_path" id="image" class="form-control-file" aria-describedby="fileUpload">
                <small id="fileUpload" class="form-text text-muted">Image types should be PNG or JPEG</small>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for="artistName">Artist</label>
                <input class="form-control" name="artistName" id="artistName" placeholder="Artist Name">
                <label for="title">Title</label>
                <input class="form-control" name="title" id="title" placeholder="Title">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="Description" rows="10"></textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Create</button>

        </form>
    </div>

<style>

    h4{
        position: absolute;
        left: 630px;
        top: 120px;
    }

    body{
        background-color: lightgray;
    }

</style>
</body>
</html>
