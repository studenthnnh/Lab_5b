<?php
session_start();
if (!isset($_SESSION['user'])) { //session for every page, user must login to access
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'Lab_5b'); //connection to database Lab_5a
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user details
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "<p class='error'>User not found!</p>";
        exit();
    }
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name='$name', role='$role' WHERE matric='$matric'";
    if ($conn->query($sql) === TRUE) {
        header("Location: display.php");
        exit();
    } else {
        echo "<p class='error'>Error updating record: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Update User</title>
</head>
<body>
    <div class="container">
        <h1>Update User</h1>
        <form method="POST" action="">
            <input type="hidden" name="matric" value="<?= $user['matric'] ?>">
            
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= $user['name'] ?>" required>
            
            <label for="role">Access Level:</label>
            <select name="role" id="role" required>
                <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                <option value="lecturer" <?= $user['role'] === 'lecturer' ? 'selected' : '' ?>>Lecturer</option>
            </select>
            
            
            <div class="button-group">
                <button class="button cancel" type="button" onclick="window.location.href='display.php';">Cancel</button>
                <button class="button" type="submit">Update</button>
            </div>
        </form>
    </div>
</body>
</html>