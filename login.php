<?php
require 'database.php'; // Includes session_start()

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $message = 'Please fill in all fields.';
    } else {
        try {
            // --- SECURITY FLAW 2: SQL Injection Vulnerability ---
            // Directly inserting user input into the query without sanitization or prepared statements.
            // An attacker can input something like: ' OR '1'='1 -- 
            // Or use tools like sqlmap.
            $sql = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'"; // Plaintext password check
            
            // Using query() which is susceptible if the query string is built with raw user input
            $stmt = $pdo->query($sql);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: dashboard.php');
                exit;
            } else {
                // Login failed
                $message = 'Invalid username or password.';
            }
        } catch (PDOException $e) {
            $message = 'Database error: ' . $e->getMessage(); // Show detailed errors (potential info disclosure)
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Password Keeper</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login to Password Keeper</h1>
        
        <?php if (!empty($message)): ?>
            <p class="message error"><?= $message ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html> 