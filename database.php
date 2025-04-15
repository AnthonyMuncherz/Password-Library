<?php
session_start();

$db_file = __DIR__ . '/passwords.db';
$pdo = new PDO('sqlite:' . $db_file);

// Set errormode to exceptions
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create users table if it doesn't exist
$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL 
)");

// Create passwords table if it doesn't exist
$pdo->exec("CREATE TABLE IF NOT EXISTS passwords (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    site_name TEXT NOT NULL,
    site_username TEXT NOT NULL,
    site_password TEXT NOT NULL, 
    FOREIGN KEY (user_id) REFERENCES users(id)
)");

?> 