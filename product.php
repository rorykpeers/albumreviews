<?php

require_once '../src/setup.php';

if (!isset($_GET['productId'])) {
    die('Missing productId in the URL');
}

$productId = $_GET['productId'];

$product = $dbProvider->getProduct($productId);

if (!$product) {
    $logger->warning('Product not found: ' . $productId);
    header('Location: 404.php');
    die;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'template_parts/header_includes.php' ?>
    <?php include 'template_parts/navbar.php' ?>
    <title>Album Detail</title>
</head>
<body>
<div class="carousel-size">
<div class="carousel-border">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
<div class="carousel-inner">
<div class="carousel-item active">
            <img src="<?= $product->imagePath ? 'uploads/' . $product->imagePath : '../images/Radiohead-Kid-A.jpg' ?>" height="375" class="d-block w-100" alt="radiohead">
</div>
<div class="carousel-item">
            <img src="../images/CureDisintegration.jpg" height="375" class="d-block w-100" alt="cure">
</div>
<div class="carousel-item">
            <img src="../images/topimpabutterfly.jpg" height="375" class="d-block w-100" alt="kendrick">
</div>
</div>
<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
</a>
</div>
</div>
</div>
<style>

    body{
        background-color: lightgray;
    }

    .carousel-border {
        width: 500px;
        position: absolute;
        left: 20px;
        border-style: solid;
        border-color: darkslategray;
        border-width: 10px;
        margin-top: 60px;
    }

    .carousel-size {
        width: 480px;
        position: absolute;
        left: 330px;
    }

    .container {
        position: absolute;
        top: 450px;
        left: 170px;
        width: 700px;
        height: 200px;
        padding: 20px;
        margin: 100px 80px auto;
        border-width: 5px;
        border-color: darkslategray;
        border-style: solid;
    }

    .btn-primary {
        position: absolute;
        top: 1000px;
        left: 530px;
    }

    .container1 {
        position: relative;
        width: 500px;
        height: 370px;
        top: 400px;
        left: 80px;
        padding: 20px;
        border-width: 5px;
        border-color: darkslategray;
        border-style: solid;
    }

    .additional {
        position: relative;
        top: 360px;
        left: 230px;
        font-size: 20px;
    }
    .average-rating {
        position: absolute;
        top: 27px;
        left: 20px;
    }

    .recent {
        position: relative;
        top: 450px;
        left: 250px;
        font-size: 20px;
    }

    .container2 {
        position: relative;
        width: 800px;
        height: 200px;
        top: 470px;
        right: 80px;
        padding: 20px;
        border-width: 5px;
        border-color: darkslategray;
        border-style: solid;
    }

    .container3{
        position: absolute;
        top: 50px;
        right: 70px;

    }
</style>

<style>
    .star-rating {
        background-color: grey;
        width: 200px;
        height: 20px;
        display: inline-block;
    }

    .star-rating div {
        position: relative;
        height: 100%;
        background-color: yellow;
        display: inline-block;
    }

    .modal-dialog{
        overflow-y: initial !important
    }
    .modal-body{
        height: 450px;
        overflow-y: auto;
    }

    .name {
        font-size: 20px;
        text-align: center;
        position: absolute;
        left: 165px;
    }

    .form-control-lg-name {
        width: 300px;
        position: absolute;
        top: 70px;
    }

    .rating {
        font-size: 20px;
        text-align: center;
        position: absolute;
        top:440px;
        left: 170px;
    }

    .checkinRating{
        text-align: center;
        position: absolute;
        top: 70px;
        left: 50px;
    }


    .review{
        font-size: 20px;
        text-align: center;
        position: absolute;
        top: 220px;
        left: 210px;
    }

    .checkin{
        position: absolute;
        right: 70px;
        bottom: 500px;
        text-align: center;
    }

    .container5{
        position: absolute;
        width: 50px;
        left: 50px;
        top: 300px;
    }

    .submitBtn{
        position: absolute;
        top: 580px;
        left: 210px;
    }

    .container3{
        position: relative;
        top: 550px;
        left: 30px;
    }

    .reviewBox{
        position: absolute;
        top: 270px;
        right: 50px;
    }

    .moreButton{
        position: relative;
        left: 300px;
        top: 100px;
        padding-bottom: 20px;
        margin-bottom: 100px;
    }

    .container6{
        text-align: center;
    }

</style>

<div class="container">
    <div class="container6">
    <h2><?= $product->title ?></h2>
    <p>
        <?= $product->artist ?>
    </p>
    <p>
        <?= $product->genre ?>
    </p>
    </div>
</div>

<div>
<div class="container5">
<div class="checkin">
    <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id="checkin">Check In</a>
</div>
</div>
</div>

<div class="container">
    <div class="form-row">
    <div class="col-12">

<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
<form method="post" action="checkin-create.php">
<div class="modal-header mt-3">

    <h4>Album Check In</h4>

</div>
    <div class="modal-body mx-5">
        <input type="hidden" name="product_id" value="<?= $_GET['productId'] ?>">
    <div class="md-form d-flex justify-content-center mb-5">
    <div class="name">
        <label><b>Name</b></label>
</div>
        <input type="text" name="name" class="form-control-lg-name" placeholder="Name" aria-describedby="yourName" value="<?= $loggedInUser->name ?? '' ?>">

</div>
</div>

    <div class="md-form d-flex justify-content-center mb-5">
    <div class="form-group">
    <div class="rating">
        <label><b>Rating</b></label>
        <div class="checkinRating">
        <input type="number" class="form-control" name="rating" id="checkinRating" aria-describedby="yourRating" min="1" max="5">
        </div>
        <div class="yourRating">
        <small id="yourRating" class="form-text-muted" >Rate the album 1 to 5</small>
        </div>

</div>
</div>
</div>
<br>

<div class="review">
    <label><b>Review</b></label>
</div>
    <div class="reviewBox">
    <textarea class="form-control" name="review" id="reviewBox" placeholder="Write Review here...." rows="5" style="width: 400px"></textarea>
    </div>
<br>

<div class="modal-footer d-flex justify-content-center mb-3">
    <button type="submit" class="btn btn-primary submitBtn" value="Submit">Submit</button>
    <input class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
</form>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="additional"><p><b>Additional Information</b></p></div>
<div class="container1">
    <br>
    <hr class="one">
    <div class="average-rating"><p><b>Average Rating</b>
        </p><?= $product->average_rating ?></div>
    <br>
    <hr class="two">
    <p><b>Another Statistic</b></p>
    <hr>
    <div class="numbers">78/100</div>
    <hr>
    <p><b>Yet Another Statistic</b></p>
    <hr>
    <div class="something">Something</div>
</div>

<div class="recent"><p><b>Recent Check Ins</b></p></div>

<div class="container3">
    <?php
    if (!count($product->getCheckins())) : ?>
    No checkins found, please checkin!
    <?php
    endif;
    foreach($product->getCheckins() as $checkIn): ?>
</div>

<div class="container2">
    <div class="star-rating"><div style="width:<?= $checkIn->rating * 20; ?>%;"</div>
</div>
</div>
    <h3><?= $checkIn->name ?><?= $checkIn->id ?></h3>
        <p><?= $checkIn->review ?></p>
    <?php endforeach; ?>

<div class="moreButton">
<button type="submit" class="btn-primary1 btn-sm" id="get">Check for more reviews</button>
</div>

</body>
<?php include 'template_parts/footer_includes.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</html>