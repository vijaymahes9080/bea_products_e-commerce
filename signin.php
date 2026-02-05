<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No user found with that email!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Makeup Store</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background:rgb(1, 0, 0);
        }

        .topnav {
    background-color: #333;
    overflow: hidden;
    padding: 10px 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 999;
}

        

        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
            transition: background-color 0.3s, color 0.3s;
        }

        .topnav a.active {
            background-color: #32a415;
            color: white;
            border-radius: 4px;
        }

        .topnav a:hover {
            background-color: #555;
            color: white;
        }

        .container {
    max-width: 350px;
    margin: 120px auto 80px auto; /* Increased top margin to clear the fixed nav */
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}


        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .container input[type="email"],
        .container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        .container button {
            width: 100%;
            padding: 10px;
            background:rgb(242, 28, 160);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .container p {
            text-align: center;
            margin-top: 10px;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="topnav">
        <a class="active" href="index.html">Home</a>
        <a href="products.html">Products</a>
        <a href="contact.html">Contact</a>
        <a href="about.html">About</a>
        <a href="signin.php">Signin</a>
        <a href="signup.php">SignUp</a>
        <a href="wishlist.html">Wishlist</a>
    </div>

    <div class="container">
        <h2>Sign In</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="signin.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>

</body>
</html>
