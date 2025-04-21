<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'crud_app';

// Koneksi
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Buat DB jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS $db_name");
$conn->select_db($db_name);

// Buat tabel users jika belum ada
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)");

// Tambahkan user admin jika belum ada
$check = $conn->query("SELECT * FROM users WHERE username='admin'");
if ($check->num_rows === 0) {
    $hashed = password_hash('123', PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (username, password) VALUES ('admin', '$hashed')");
}

// Buat tabel produk jika belum ada
$conn->query("CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    harga DOUBLE
)");
?>
