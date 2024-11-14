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
    <div class="container">
        <h2>Register</h2>
        <form method="POST" action="register.php">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Role:</label>
            <select name="roleID">
                <?php
                $roles_query = "SELECT RoleID, RoleName FROM roles";
                $roles_result = $conn->query($roles_query);
                while ($role = $roles_result->fetch_assoc()) {
                    echo "<option value='{$role['RoleID']}'>{$role['RoleName']}</option>";
                }
                ?>
            </select>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>