<?php
include 'dbconnect.php';
session_start();

// Check if user is already logged in
if (isset($_SESSION['UserID'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UserName = $_POST["UserName"];
    $Password = $_POST["Password"];

    // Prepare the query to prevent SQL injection
    $query = "SELECT UserID, Password, RoleID FROM users WHERE UserName = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $UserName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify the password with hash
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
        
        <p>Not yet registered? <a href="register.php">Sign up here</a></p>
    </div>
</body>
</html>
