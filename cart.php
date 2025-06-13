<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Daraz Clone</title>
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
        .cart-container {
            padding: 20px;
            background: white;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .cart-item {
            display: flex;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
        }
        .cart-item h3 {
            flex: 1;
            font-size: 1.2em;
        }
        .cart-item p {
            color: #f57224;
            font-weight: bold;
        }
        .cart-item button {
            padding: 5px 10px;
            background: #f57224;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cart-item button:hover {
            background: #ff8c00;
        }
        .checkout-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background: #f57224;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-weight: bold;
        }
        .checkout-btn:hover {
            background: #ff8c00;
        }
        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                align-items: center;
            }
            .cart-item img {
                margin-bottom: 10px;
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
    <div class="cart-container">
        <h2>Your Cart</h2>
        <?php
        session_start();
        include 'db.php';
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $product_id = $_POST['product_id'];
                $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
                $conn->query($sql);
            }
            $sql = "SELECT p.id, p.name, p.price, p.image, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $user_id";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<div class='cart-item'>";
                echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>Rs. " . $row['price'] . " x " . $row['quantity'] . "</p>";
                echo "<button onclick=\"removeFromCart(" . $row['id'] . ")\">Remove</button>";
                echo "</div>";
            }
        } else {
            echo "<p>Please login to view your cart.</p>";
        }
        ?>
        <button class="checkout-btn" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
    </div>
    <script>
        function removeFromCart(productId) {
            fetch('cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'remove_product_id=' + productId
            }).then(response => response.text()).then(data => {
                alert('Product removed from cart!');
                window.location.reload();
            });
        }
        <?php
        if (isset($_POST['remove_product_id'])) {
            $product_id = $_POST['remove_product_id'];
            $sql = "DELETE FROM cart WHERE product_id = $product_id AND user_id = $user_id";
            $conn->query($sql);
        }
        ?>
    </script>
</body>
</html>
