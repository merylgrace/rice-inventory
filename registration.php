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