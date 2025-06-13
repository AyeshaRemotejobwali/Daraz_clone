<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Daraz Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .navbar {
            background: linear-gradient(90deg, #f57224, #ff8c00);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        .navbar a:hover {
            color: #ffe4b5;
        }
        .orders-container {
            padding: 20px;
            background: white;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .order-item {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .order-item h3 {
            color: #f57224;
        }
        .order-item p {
            margin: 5px 0;
        }
        @media (max-width: 768px) {
            .orders-container {
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart</a>
            <a href="orders.php">Orders</a>
            <a href="seller.php">Seller Dashboard</a>
        </div>
        <div>
            <a href="signup.php">Signup</a>
            <a href="login.php">Login</a>
        </div>
    </div>
    <div class="orders-container">
        <h2>Your Orders</h2>
        <?php
        session_start();
        include 'db.php';
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT o.id, o.status, o.created_at, p.name, p.price, oi.quantity FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id WHERE o.user_id = $user_id";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<div class='order-item'>";
                echo "<h3>Order #" . $row['id'] . "</h3>";
                echo "<p>Product: " . $row['name'] . "</p>";
                echo "<p>Price: Rs. " . $row['price'] . " x " . $row['quantity'] . "</p>";
                echo "<p>Status: " . $row['status'] . "</p>";
                echo "<p>Date: " . $row['created_at'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Please login to view your orders.</p>";
        }
        ?>
    </div>
</body>
</html>
