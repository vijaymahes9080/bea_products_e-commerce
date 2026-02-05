<?php
// Initialize variables
$wishlist = [];
$total_price = 0;

// Check if wishlist parameter is provided
if (isset($_GET['wishlist'])) {
    $wishlist = json_decode(urldecode($_GET['wishlist']), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $wishlist = [];
    }
    // Calculate total price
    foreach ($wishlist as $item) {
        $total_price += floatval($item['price']);
    }
} else {
    // Fallback to single item
    $product_name = isset($_GET['product_name']) ? htmlspecialchars($_GET['product_name']) : 'Unknown Product';
    $price = isset($_GET['price']) ? floatval(htmlspecialchars($_GET['price'])) : 0;
    $image = isset($_GET['image']) ? htmlspecialchars($_GET['image']) : 'default_image.jpg';
    if ($price > 0) {
        $wishlist[] = [
            'name' => $product_name,
            'price' => $price,
            'image' => $image
        ];
        $total_price = $price;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <style>
        .payment-details {
            text-align: center;
            margin-top: 50px;
        }
        .payment-details img {
            max-width: 150px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .product-box {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 10px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #e91e63;
            margin-top: 20px;
        }
        .btn-success {
            background-color: #4acfcb;
            border: none;
            padding: 15px 32px;
            font-size: 16px;
            border-radius: 8px;
        }
        .btn-success:hover {
            background-color: #3bb3b3;
        }
    </style>
</head>
<body>
    <div class="container payment-details">
        <h1>Payment Details</h1>
        <?php if (empty($wishlist)): ?>
            <p>No items selected for payment.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($wishlist as $item): ?>
                    <div class="col-lg-3 col-sm-6">
                        <div class="product-box">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            <h2><?php echo htmlspecialchars($item['name']); ?></h2>
                            <h3>Price: Rs.<?php echo number_format(floatval($item['price']), 2); ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <h3 class="total-price">Total Price: Rs.<?php echo number_format($total_price, 2); ?></h3>
        <?php endif; ?>
        <form action="process_payment.php" method="POST">
            <?php foreach ($wishlist as $index => $item): ?>
                <input type="hidden" name="products[<?php echo $index; ?>][name]" value="<?php echo htmlspecialchars($item['name']); ?>">
                <input type="hidden" name="products[<?php echo $index; ?>][price]" value="<?php echo floatval($item['price']); ?>">
                <input type="hidden" name="products[<?php echo $index; ?>][image]" value="<?php echo htmlspecialchars($item['image']); ?>">
            <?php endforeach; ?>
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <div class="form-group">
                <label for="customer_name">Customer Name:</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="form-group">
                <label for="customer_email">Customer Email:</label>
                <input type="email" class="form-control" id="customer_email" name="customer_email" required>
            </div>
            <div class="form-group">
                <label for="customer_phone">Customer Phone:</label>
                <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
            </div>
            <div class="form-group">
                <label for="billing_address">Billing Address:</label>
                <input type="text" class="form-control" id="billing_address" name="billing_address" required>
            </div>
            <div class="form-group">
                <label for="billing_city">City:</label>
                <input type="text" class="form-control" id="billing_city" name="billing_city" required>
            </div>
            <div class="form-group">
                <label for="billing_state">State:</label>
                <input type="text" class="form-control" id="billing_state" name="billing_state" required>
            </div>
            <div class="form-group">
                <label for="billing_zip">Zip Code:</label>
                <input type="text" class="form-control" id="billing_zip" name="billing_zip" required>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>
            <div class="form-group">
                <label for="card_number">Card Number:</label>
                <input type="text" class="form-control" id="card_number" name="card_number" required>
            </div>
            <div class="form-group">
                <label for="card_expiration">Expiration Date (MM/YY):</label>
                <input type="text" class="form-control" id="card_expiration" name="card_expiration" required>
            </div>
            <div class="form-group">
                <label for="card_cvv">CVV:</label>
                <input type="text" class="form-control" id="card_cvv" name="card_cvv" required>
            </div>
            <button type="submit" class="btn btn-success">Pay Now</button>
        </form>
    </div>
</body>
</html>