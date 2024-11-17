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

// Set default join type (LEFT JOIN)
$joinType = 'LEFT JOIN';

// Check if form is submitted with a different join type
if (isset($_POST['join_type'])) {
    $joinType = $_POST['join_type'];
}

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
    $joinType 
        inventoryupdates ON inventory.RiceID = inventoryupdates.RiceID
    $joinType 
        activitylogs ON activitylogs.UserID = inventoryupdates.UserID
    $joinType 
        users ON activitylogs.UserID = users.UserID
    $joinType 
        roles ON users.RoleID = roles.RoleID
    ORDER BY 
        inventory.created_at DESC";

// Execute the query
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
        
        <div class="tabs">
            <a href="logout.php" class="tab-link">Logout</a>
            <a href="addrice.php" class="tab-link">Add Rice</a>
        </div>

        <form method="POST" action="">
            <label for="join_type">Select Join Type:</label>
            <select name="join_type" id="join_type" onchange="this.form.submit()">
                <option value="LEFT JOIN" <?php if ($joinType == 'LEFT JOIN') echo 'selected'; ?>>LEFT JOIN</option>
                <option value="INNER JOIN" <?php if ($joinType == 'INNER JOIN') echo 'selected'; ?>>INNER JOIN</option>
            </select>
        </form>
        
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
                    <td><?php echo $row["ActivityType"] ? $row["ActivityType"] : 'No activity'; ?></td>
                    <td><?php echo $row["ActivityDescription"] ? $row["ActivityDescription"] : 'No description'; ?></td>
                    <td><?php echo $row["ActivityTime"] ? $row["ActivityTime"] : 'No time recorded'; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>