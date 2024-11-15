<?php
include 'dbconnect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $UserName = $_POST["UserName"];
    $Password = $_POST["Password"];
    $RoleID = $_POST["RoleID"];

    // Hash the password before saving it to the database
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Prepare the SQL query to prevent SQL injection
    $query = "INSERT INTO users (UserName, Password, RoleID, created_at, updated_at) 
              VALUES (?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $UserName, $hashedPassword, $RoleID);

    try {
        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        } else {
            // Handle potential database errors
            throw new Exception("Unable to register user. Please check your RoleID and database setup.");
        }
    } catch (Exception $e) {
        // Display the error message for debugging
        echo "Error: " . $e->getMessage();
    }

    // Close the prepared statement
    $stmt->close();
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
        <form action="registration.php" method="POST">
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

        <p>Already have an account? <a href="login.php">Log in here</a></p>
    </div>
</body>
</html>
