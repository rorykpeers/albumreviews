<?php

require_once '../src/setup.php';

if (!$loggedInUser || $loggedInUser->isAdmin) {
    header('Location: ../product-list.php');
    die;
}
