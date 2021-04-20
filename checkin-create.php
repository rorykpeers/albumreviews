<?php

require_once '../src/setup.php';

$checkInData = [
    'product_id' => filter_var($_POST['product_id'], FILTER_VALIDATE_INT),
    'name' => strip_tags($_POST['name']),
    'rating' => filter_var($_POST['rating'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 5]]),
    'review' => strip_tags($_POST['review']),
    ];

if (empty($checkInData['product_id'])) {
    header('Location: product-list.php');
    exit;
}

if (empty($checkInData['name']) || empty($checkInData['rating']) || empty($checkInData['review'])) {
    header('Location product.php?productId=' . $checkInData['product_id'] . '&message=error');
}

$hydrator = new \App\Hydrator\EntityHydrator();
$postedCheckIn = $hydrator->hydrateCheckIn($checkInData);

$checkin = $dbProvider->createCheckin($postedCheckIn);
header('Location: product.php?productId=' . $checkin->product_id . '&message=success');
