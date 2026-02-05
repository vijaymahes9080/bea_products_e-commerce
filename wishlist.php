<?php
header('Content-Type: application/json');

// Get POST data
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

$response = [];

if ($user_id <= 0 || $product_id <= 0 || $action !== 'add') {
    $response = [
        'success' => false,
        'message' => 'Invalid input parameters'
    ];
} else {
    // Simulate adding to wishlist (replace with actual database logic if needed)
    $response = [
        'success' => true,
        'message' => 'Product added to wishlist successfully'
    ];
}

echo json_encode($response);
?>