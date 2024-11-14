<?php
include 'dbconnect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UserName = $_POST["UserName"];
    $Password = $_POST["Password"];

    // ifetch ang hashed password ni user
    $query = "SELECT UserID, Password, RoleID FROM users WHERE UserName = '$UserName'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Iverify ang password sa hash
        if (password_verify($Password, $row["Password"])) {
            $_SESSION["UserID"] = $row["UserID"];
            $_SESSION["RoleID"] = $row["RoleID"];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="UserName">Username</label>
            <input type="text" name="UserName" required>
            
            <label for="Password">Password</label>
            <input type="password" name="Password" required>
            
            <button type="submit">Login</button>
        </form>
        
        <!-- kung wala pa nakaregister -->
        <p>Not yet registered? <a href="http://localhost/rice-inventory-sys/register.php">Sign up here</a>

    </div>
</body>
</html>