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