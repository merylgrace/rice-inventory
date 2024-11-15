<?php
include 'dbconnect.php';
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION["UserID"])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION["UserID"];
$roleID = $_SESSION["RoleID"];

// Revised SQL Query to fix the JOIN for activity logs and display rice inventory with activity logs
$inventory_query = "
    SELECT 
        inventory.RiceID,
        inventory.RiceName,
        inventory.Quantity,
        inventory.Price,
        inventory.created_at,
        users.UserName,
        roles.RoleName,
        activitylogs.ActivityType,
        activitylogs.ActivityDescription,
        activitylogs.ActivityTime
    FROM 
        inventory
    LEFT JOIN 
        inventoryupdates ON inventory.RiceID = inventoryupdates.RiceID
    LEFT JOIN 
        activitylogs ON activitylogs.UserID = inventoryupdates.UserID
    LEFT JOIN 
        users ON activitylogs.UserID = users.UserID
    LEFT JOIN 
        roles ON users.RoleID = roles.RoleID
    ORDER BY 
        inventory.created_at DESC";

$inventory_result = $conn->query($inventory_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Rice Inventory Dashboard</title>
</head>
<body>
    <div class="container">
        <h2>Rice Inventory Dashboard</h2>
        
        <!-- Tab-style navigation for Logout and Add Rice -->
        <div class="tabs">
            <a href="logout.php" class="tab-link">Logout</a>
            <a href="addrice.php" class="tab-link">Add Rice</a>
        </div>
        
        <!-- Dashboard Table to display rice inventory with activity logs -->
        <table class="dashboard-table">
            <tr>
                <th>Rice ID</th>
                <th>Rice Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Date Created</th>
                <th>Username</th>
                <th>Role</th>
                <th>Activity Type</th>
                <th>Activity Description</th>
                <th>Activity Time</th>
            </tr>
            <?php while ($row = $inventory_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["RiceID"]; ?></td>
                    <td><?php echo $row["RiceName"]; ?></td>
                    <td><?php echo $row["Quantity"]; ?></td>
                    <td><?php echo $row["Price"]; ?></td>
                    <td><?php echo $row["created_at"]; ?></td>
                    <td><?php echo $row["UserName"]; ?></td>
                    <td><?php echo $row["RoleName"]; ?></td>
                    <td><?php echo $row["ActivityType"]; ?></td>
                    <td><?php echo $row["ActivityDescription"]; ?></td>
                    <td><?php echo $row["ActivityTime"]; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>