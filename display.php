<?php
// Start session and check if user is logged in
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'Lab_5b');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete action
if (isset($_GET['delete'])) { //to delete a user record from a MySQL database based on the matric value passed via a URL parameter
    $matric = $_GET['delete'];
    $sql = "DELETE FROM users WHERE matric='$matric'"; 
    if ($conn->query($sql) === TRUE) {
        header("Location: display.php");
        exit();
    } else {
        echo "<p class='error'>Error deleting record: " . $conn->error . "</p>";
    }
}

// Fetch data from the database
$sql = "SELECT matric, name, role FROM users";  
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Manage Users</title>
</head>
<body>
    <div class="container">
        <h1>Manage Users</h1>

                <!-- Logout Button -->
                <div style="text-align: right; margin-bottom: 20px;">
            <a href="logout.php" class="button cancel">Logout</a>
        </div>

        <table>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Level</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['matric']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['role']}</td>
                            <td>
                                <a href='update.php?matric={$row['matric']}' class='button'>Update</a>
                                <a href='display.php?delete={$row['matric']}' class='button danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                            </td>
                          </tr>";
                          
                }
            } else {
                echo "<tr><td colspan='4' class='no-data'>No data found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
