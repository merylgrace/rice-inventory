<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UserName = $_POST["UserName"];
    $Password = $_POST["Password"];
    $RoleID = $_POST["RoleID"];

    // hash ang password ayha save sa database
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (UserName, Password, RoleID, created_at, updated_at) 
              VALUES ('$UserName', '$hashedPassword', '$RoleID', NOW(), NOW())";
    
    if ($conn->query($query) === TRUE) {
        echo "Registration successful.";
        header("Location: login.php");
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Register</title>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label for="UserName">Username</label>
            <input type="text" name="UserName" required>

            <label for="Password">Password</label>
            <input type="password" name="Password" required>

            <!-- Role selection dropdown -->
            <label for="RoleID">Role</label>
            <select name="RoleID" required>
                <option value="1">Admin</option>
                <option value="2">User</option>
            </select>

            <button type="submit">Sign Up</button>
        </form>
        
        <!-- basin naa nay account -->
        <p>Already have an account? <a href="login.php">Log in here</a></p>
    </div>
</body>
</html>