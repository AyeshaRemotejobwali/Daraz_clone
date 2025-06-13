<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Daraz Clone</title>
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
        .search-bar {
            width: 50%;
            padding: 10px;
            border-radius: 5px;
            border: none;
        }
        .filters {
            padding: 20px;
            background: white;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .filters select, .filters input {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
            .filters {
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
        <input type="text" class="search-bar" placeholder="Search products..." onkeyup="searchProducts()">
        <div>
            <a href="signup.php">Signup</a>
            <a href="login.php">Login</a>
        </div>
    </div>
    <div class="filters">
        <select onchange="filterProducts()">
            <option value="">All Categories</option>
            <option value="Electronics">Electronics</option>
            <option value="Fashion">Fashion</option>
            <option value="Home & Kitchen">Home & Kitchen</option>
        </select>
        <input type="number" placeholder="Max Price" onkeyup="filterProducts()">
    </div>
    <div class="products" id="product-list">
        <?php
        include 'db.php';
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
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
        function filterProducts() {
            let category = document.querySelector('select').value;
            let maxPrice = document.querySelector('input[type=number]').value;
            window.location.href = `products.php?category=${category}&max_price=${maxPrice}`;
        }
    </script>
</body>
</html>
