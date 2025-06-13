<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Daraz Clone</title>
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
        .checkout-container {
            padding: 20px;
            background: white;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .checkout-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .checkout-container button {
            width: 100%;
            padding: 10px;
            background: #f57224;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .checkout-container button:hover {
            background: #ff8c00;
        }
        @media (max-width: 768px) {
            .checkout-container {
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
    <div class="checkout-container">
        <h2>Checkout</h2>
        <input type="text" placeholder="Full Name" required>
        <input type="text" placeholder="Address" required>
        <input type="text" placeholder="Card Number" required>
        <input type="text" placeholder="CVV" required>
        <button onclick="placeOrder()">Place Order</button>
    </div>
    <script>
        function placeOrder() {
            alert('Order placed successfully! (Dummy Payment Gateway)');
            fetch('checkout.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'place_order=true'
            }).then(response => response.text()).then(data => {
                window.location.href = 'orders.php';
            });
        }
    </script>
    <?php
    session_start();
    include 'db.php';
    if (isset($_POST['place_order']) && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO orders (user_id, status) VALUES ($user_id, 'Pending')";
        $conn->query($sql);
        $order_id = $conn->insert_id;
        $sql = "INSERT INTO order_items (order_id, product_id, quantity) SELECT $order_id, product_id, quantity FROM cart WHERE user_id = $user_id";
        $conn->query($sql);
        $sql = "DELETE FROM cart WHERE user_id = $user_id";
        $conn->query($sql);
    }
    ?>
</body>
</html>
