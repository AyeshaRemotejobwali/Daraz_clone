<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Daraz Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f57224, #ff8c00);
        }
        .signup-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .signup-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #f57224;
        }
        .signup-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .signup-container button {
            width: 100%;
            padding: 10px;
            background: #f57224;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .signup-container button:hover {
            background: #ff8c00;
        }
        .signup-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #f57224;
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .signup-container {
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Signup</h2>
        <input type="text" id="username" placeholder="Username" required>
        <input type="email" id="email" placeholder="Email" required>
        <input type="password" id="password" placeholder="Password" required>
        <button onclick="signup()">Signup</button>
        <a href="login.php">Already have an account? Login</a>
    </div>
    <script>
        function signup() {
            let username = document.getElementById('username').value;
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            fetch('signup.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `username=${username}&email=${email}&password=${password}`
            }).then(response => response.text()).then(data => {
                alert(data);
                if (data.includes('success')) {
                    window.location.href = 'login.php';
                }
            });
        }
    </script>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'db.php';
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql)) {
            echo "Signup successful!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
</body>
</html>
