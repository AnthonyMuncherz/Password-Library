<?php
require 'database.php'; // Includes session_start()

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$message = '';
$error_message = '';

// Handle adding new password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_password'])) {
    $site_name = $_POST['site_name'];
    $site_username = $_POST['site_username'];
    $site_password = $_POST['site_password']; // Plaintext storage

    if (empty($site_name) || empty($site_username) || empty($site_password)) {
        $error_message = 'Please fill in all fields for the new password entry.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO passwords (user_id, site_name, site_username, site_password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $site_name, $site_username, $site_password]);
            $message = 'Password added successfully!';
        } catch (PDOException $e) {
            $error_message = 'Error adding password: ' . $e->getMessage();
        }
    }
}

// Fetch user's saved passwords
$passwords = [];
try {
    $stmt = $pdo->prepare("SELECT id, site_name, site_username, site_password FROM passwords WHERE user_id = ? ORDER BY site_name");
    $stmt->execute([$user_id]);
    $passwords = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = 'Error fetching passwords: ' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Password Keeper</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
            <a href="logout.php">Logout</a>
        </div>

        <h2>Your Password Library</h2>

        <?php if (!empty($message)): ?>
            <p class="message success"><?= $message ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p class="message error"><?= $error_message ?></p>
        <?php endif; ?>

        <div class="password-list">
            <h3>Saved Passwords</h3>
            <?php if (empty($passwords)): ?>
                <p>You haven't saved any passwords yet.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Site Name</th>
                            <th>Username</th>
                            <th>Password</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($passwords as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['site_name']) ?></td>
                                <td><?= htmlspecialchars($p['site_username']) ?></td>
                                <td><?= htmlspecialchars($p['site_password']) ?></td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="add-password-form">
            <h3>Add New Password Entry</h3>
            <form action="dashboard.php" method="post">
                <div class="form-group">
                    <label for="site_name">Site Name:</label>
                    <input type="text" id="site_name" name="site_name" required>
                </div>
                <div class="form-group">
                    <label for="site_username">Site Username:</label>
                    <input type="text" id="site_username" name="site_username" required>
                </div>
                <div class="form-group">
                    <label for="site_password">Site Password:</label>
                    <input type="text" id="site_password" name="site_password" required> 
                </div>
                <button type="submit" name="add_password">Add Password</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html> 