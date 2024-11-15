<?php
include 'dbconnect.php';
session_start();

// Check if user is already logged in
if (isset($_SESSION['UserID'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UserName = trim($_POST["UserName"]);
    $Password = trim($_POST["Password"]);

    // Prepare the query to prevent SQL injection
    $query = "SELECT UserID, Password, RoleID FROM users WHERE UserName = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $UserName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Verify the password
            if (password_verify($Password, $row["Password"])) {
                $_SESSION["UserID"] = $row["UserID"];
                $_SESSION["RoleID"] = $row["RoleID"];
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<p style='color:red;'>Incorrect password.</p>";
            }
        } else {
            echo "<p style='color:red;'>Username not found.</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color:red;'>Error in query preparation.</p>";
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
            <input type="text" name="UserName" id="UserName" required>
            
            <label for="Password">Password</label>
            <input type="password" name="Password" id="Password" required>
            
            <button type="submit">Login</button>
        </form>
        
        <!-- Ensure this link navigates correctly -->
        <p>Not yet registered? <a href="registration.php">Sign up here</a></p>
    </div>
</body>
</html>
