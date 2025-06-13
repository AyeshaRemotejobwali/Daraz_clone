<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daraz Clone - Homepage</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
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
        .search-bar {
            width: 50%;
            padding: 10px;
            border-radius: 5px;
            border: none;
        }
        .hero {
            background: url('https://via.placeholder.com/1200x300') center/cover;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .hero h1 {
            font-size: 3em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .product-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-card h3 {
            padding: 10px;
            font-size: 1.2em;
        }
        .product-card p {
            padding: 0 10px 10px;
            color: #f57224;
            font-weight: bold;
        }
        .product-card button {
            width: 100%;
            padding: 10px;
            background: #f57224;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        .product-card button:hover {
            background: #ff8c00;
        }
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
            }
            .search-bar {
                width: 100%;
                margin-top: 10px;
            }
            .hero h1 {
                font-size: 2em;
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
        <input type="text" class="search-bar" placeholder="Search products..." onkeyup="searchProducts()">
        <div>
            <a href="signup.php">Signup</a>
            <a href="login.php">Login</a>
        </div>
    </div>
    <div class="hero">
        <h1>Discover Amazing Deals!</h1>
    </div>
    <div class="products" id="product-list">
        <?php
        include 'db.php';
        $sql = "SELECT * FROM products LIMIT 8";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product-card'>";
            echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<p>Rs. " . $row['price'] . "</p>";
            echo "<button onclick=\"addToCart(" . $row['id'] . ")\">Add to Cart</button>";
            echo "</div>";
        }
        ?>
    </div>
    <script>
        function addToCart(productId) {
            fetch('cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + productId
            }).then(response => response.text()).then(data => {
                alert('Product added to cart!');
            });
        }
        function searchProducts() {
            let query = document.querySelector('.search-bar').value;
            window.location.href = `products.php?search=${query}`;
        }
    </script>
</body>
</html>
