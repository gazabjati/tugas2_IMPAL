<?php
session_start();
include("../includes/config.php");

// Preconditions: Validate admin session
$id_user = $_SESSION['id_user'] ?? null;
$role_user = $_SESSION['role_user'] ?? null;

if (!$id_user || $role_user != 'admin') {
    header("Location: login.php");
    die;
}

// Process: Handle form submission and insert user into database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing password for security

    // SQL insertion query
    $query = $conn->prepare("INSERT INTO user (username, nama, email, password) VALUES (:username, :nama, :email, :password)");
    $query->bindParam(':username', $username);
    $query->bindParam(':nama', $nama);
    $query->bindParam(':email', $email);
    $query->bindParam(':password', $password);
    $query->execute();

    // Postcondition: Redirect to user management page
    header("Location: manage_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <title>Tambahkan User</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="./dashboard.php">PerpusKu</a>
        </div>
    </nav>

    <div class="container">
        <h1>Tambahkan User</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-dark">Tambahkan</button>
        </form>
        <a href="manage_users.php" class="btn btn-secondary mt-3">Batal</a>
    </div>

    <script src="./js/bootstrap.min.js"></script>
</body>
</html>
