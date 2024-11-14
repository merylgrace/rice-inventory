<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UserName = $_POST["UserName"];
    $Password = $_POST["Password"];
    $RoleID = $_POST["RoleID"];

    // Hash the password before saving it to the database
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Use a prepared statement to insert data safely
    $query = "INSERT INTO users (UserName, Password, RoleID, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $UserName, $hashedPassword, $RoleID);

    // Execute the query and handle errors
    if ($stmt->execute()) {
        echo "Registration successful.";
        header("Location: login.php");
        exit();
    } else {
        // Display error if insertion fails
        echo "Error: " . $stmt->error;
    }
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