<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - Daraz Clone</title>
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
        .seller-container {
            padding: 20px;
            background: white;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .seller-container input, .seller-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .seller-container button {
            padding: 10px;
            background: #f57224;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .seller-container button:hover {
            background: #ff8c00;
        }
        .product-list div {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        @media (max-width: 768px) {
            .seller-container {
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
    <div class="seller-container">
        <h2>Seller Dashboard</h2>
        <h3>Add Product</h3>
        <input type="text" id="name" placeholder="Product Name" required>
        <textarea id="description" placeholder="Description" required></textarea>
        <input type="number" id="price" placeholder="Price" required>
        <input type="text" id="image" placeholder="Image URL" required>
        <select id="category">
            <option value="Electronics">Electronics</option>
            <option value="Fashion">Fashion</option>
            <option value="Home & Kitchen">Home & Kitchen</option>
        </select>
        <button onclick="addProduct()">Add Product</button>
        <h3>Your Products</h3>
        <div class="product-list">
            <?php
            session_start();
            include 'db.php';
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM products WHERE seller_id = $user_id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<h4>" . $row['name'] . "</h4>";
                    echo "<p>Rs. " . $row['price'] . "</p>";
                    echo "<button onclick=\"deleteProduct(" . $row['id'] . ")\">Delete</button>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
    <script>
        function addProduct() {
            let name = document.getElementById('name').value;
            let description = document.getElementById('description').value;
            let price = document.getElementById('price').value;
            let image = document.getElementById('image').value;
            let category = document.getElementById('category').value;
            fetch('seller.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `name=${name}&description=${description}&price=${price}&image=${image}&category=${category}`
            }).then(response => response.text()).then(data => {
                alert(data);
                window.location.reload();
            });
        }
        function deleteProduct(productId) {
            fetch('seller.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'delete_product_id=' + productId
            }).then(response => response.text()).then(data => {
                alert('Product deleted!');
                window.location.reload();
            });
        }
    </script>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'db.php';
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = $_POST['image'];
            $category = $_POST['category'];
            $seller_id = $_SESSION['user_id'];
            $sql = "INSERT INTO products (name, description, price, image, category, seller_id) VALUES ('$name', '$description', $price, '$image', '$category', $seller_id)";
            $conn->query($sql);
            echo "Product added!";
        }
        if (isset($_POST['delete_product_id'])) {
            $product_id = $_POST['delete_product_id'];
            $sql = "DELETE FROM products WHERE id = $product_id";
            $conn->query($sql);
        }
    }
    ?>
</body>
</html>
