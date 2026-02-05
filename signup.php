<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email already registered!";
    } else {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "Sign up successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
          body {
             font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background:rgb(21, 19, 19);
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

/* Style for links inside the nav */
.topnav a {
  float: left;
  display: block;
  color:rgb(255, 255, 255);
  text-align: center;
  padding: 14px 20px;
  text-decoration: none;
  font-size: 17px;
  transition: background-color 0.3s, color 0.3s;
}

/* Highlighted/active link */
.topnav a.active {
  background-color: #32a415;
  color: white;
  border-radius: 4px;
}

/* Hover effect on links */
.topnav a:hover {
  background-color: #555;
  color: white;
}
.container {
    max-width: 400px;
    margin: 120px auto 80px auto; /* Increased top margin to clear the fixed nav */
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.91);
}
      </style>

       <!-- header section start -->
     <div class="topnav">
     <a class="active" href="index.html">Home</a>
        <a href="products.html">Products</a>
        <a href="contact.html">Contact</a>
        <a href="about.html">About</a>
        <a href="signin.php">Signin</a>
        <a href="SignUp.php">SignUp</a>
        <a href="wishlist.html">Wishlist</a>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Makeup Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
       
    </div>
</body>
</html>
