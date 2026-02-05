<?php
$servername = "localhost";
$username = "root";  // your database username
$password = "";      // your database password
$dbname = "makeup_website";  // your database name

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if products array is provided
    if (!isset($_POST['products']) || !is_array($_POST['products']) || empty($_POST['products'])) {
        throw new Exception("No products provided for payment.");
    }

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO payments (product_name, price, image, customer_name, customer_email, customer_phone, billing_address, billing_city, billing_state, billing_zip, payment_method, card_number, card_expiration, card_cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Loop through each product in the products array
    foreach ($_POST['products'] as $product) {
        // Validate product data
        $product_name = isset($product['name']) && !empty($product['name']) ? $product['name'] : 'Unknown Product';
        $price = isset($product['price']) && is_numeric($product['price']) ? floatval($product['price']) : 0;
        $image = isset($product['image']) && !empty($product['image']) ? $product['image'] : 'default_image.jpg';

        // Bind parameters for this product
        $stmt->execute([
            $product_name,
            $price,
            $image,
            $_POST['customer_name'] ?? '',
            $_POST['customer_email'] ?? '',
            $_POST['customer_phone'] ?? '',
            $_POST['billing_address'] ?? '',
            $_POST['billing_city'] ?? '',
            $_POST['billing_state'] ?? '',
            $_POST['billing_zip'] ?? '',
            $_POST['payment_method'] ?? '',
            $_POST['card_number'] ?? '',
            $_POST['card_expiration'] ?? '',
            $_POST['card_cvv'] ?? ''
        ]);
    }

    // Redirect or display a success message
    echo "Payment processed successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>