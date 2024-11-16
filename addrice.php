<?php
include 'dbconnect.php';
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION["UserID"])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION["UserID"];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $rice_name = $_POST['rice_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Insert rice into the inventory
    $query = "INSERT INTO inventory (RiceName, Quantity, Price, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $rice_name, $quantity, $price);

    if ($stmt->execute()) {
        // Rice added successfully, now log the activity
        $activity_type = "Add Rice";
        $activity_description = "Added $rice_name with quantity $quantity and price $price.";
        $activity_time = date("Y-m-d H:i:s");

        // Insert activity log into the activitylogs table
        $log_query = "INSERT INTO activitylogs (UserID, ActivityType, ActivityDescription, ActivityTime) VALUES (?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("isss", $userID, $activity_type, $activity_description, $activity_time);
        $log_stmt->execute();

        // Redirect with a success message
        echo "<script>alert('Rice added successfully and activity logged!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error adding rice. Please try again.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Rice - Inventory</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Modal Styles for Add Rice */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black with opacity */
            display: flex;
            justify-content: center;
            align-items: center;
            /* Center modal vertically and horizontally */
        }

        .modal-content {
            background-color: #fff;
            padding: 30px;
            /* Match padding in other containers */
            border-radius: 8px;
            width: 90%;
            /* Consistent width */
            max-width: 1200px;
            /* Same max-width as other containers */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        /* Modal Form */
        .modal-content h3 {
            text-align: center;
            color: #4c51bf;
            margin-bottom: 20px;
            font-size: 1.8em;
            font-family: Arial, sans-serif;
        }

        /* Form Labels */
        .modal-content label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
            color: #333;
        }

        /* Input Fields */
        .modal-content input[type="text"],
        .modal-content input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 1em;
            color: #333;
        }

        /* Button Styling */
        .modal-content button {
            background-color: #5a67d8;
            color: #ffffff;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 5px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .modal-content button:hover {
            background-color: #4c51bf;
        }
    </style>
</head>

<body>
    <!-- Modal Structure -->
    <div id="addRiceModal" class="modal">
        <div class="modal-content">
            <h3>Add Rice to Inventory</h3>
            <form action="addrice.php" method="POST">
                <label for="rice_name">Rice Name:</label>
                <input type="text" id="rice_name" name="rice_name" required>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" required>

                <button type="submit">Add Rice</button>
            </form>
        </div>
    </div>

    <!-- Add JavaScript for Modal -->
    <script>
        // Get modal elements
        var modal = document.getElementById("addRiceModal");
        var openModalBtn = document.getElementById("openModalBtn");
        var closeModalBtn = document.getElementById("closeModalBtn");

        // Open the modal when the "Add Rice" button is clicked
        openModalBtn.onclick = function() {
            modal.style.display = "block";
        }

        // Close the modal when the "X" (close) button is clicked
        closeModalBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal if the user clicks outside of the modal content
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>

</html>