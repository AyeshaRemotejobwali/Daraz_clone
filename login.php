<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Daraz Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f57224, #ff8c00);
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #f57224;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background: #f57224;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container button:hover {
            background: #ff8c00;
        }
        .login-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #f57224;
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .login-container {
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <input type="email" id="email" placeholder="Email" required>
        <input type="password" id="password" placeholder="Password" required>
        <button onclick="login()">Login</button>
        <a href="signup.php">Don't have an account? Signup</a>
    </div>
    <script>
        function login() {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            fetch('login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${email}&password=${password}`
            }).then(response => response.text()).then(data => {
                alert(data);
                if (data.includes('success')) {
                    window.location.href = 'index.php';
                }
            });
        }
    </script>
    <?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'db.php';
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                echo "Login successful!";
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "User not found!";
        }
    }
    ?>
</body>
</html>
