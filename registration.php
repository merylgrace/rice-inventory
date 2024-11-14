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