<?php
session_start();

if (!isset($_SESSION['favorite_products'])) {
    $_SESSION['favorite_products'] = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    if (in_array($productId, $_SESSION['favorite_products'])) {
        // Remove from favorites
        $index = array_search($productId, $_SESSION['favorite_products']);
        unset($_SESSION['favorite_products'][$index]);
        echo 'removed';
    } else {
        // Add to favorites
        $_SESSION['favorite_products'][] = $productId;
        echo 'added';
    }
}
