<?php
require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $rice_name = $_POST['rice_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Insert rice into the database
    $query = "INSERT INTO inventory (RiceName, Quantity, Price, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $rice_name, $quantity, $price);

    if ($stmt->execute()) {
        echo "<script>alert('Rice added successfully!'); window.location.href='dashboard.php';</script>";
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
        /* Add Rice Button */
        .add-rice-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .add-rice-btn:hover {
            background-color: #45a049;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Add Rice Form Inputs */
        #addRiceModal form input {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #addRiceModal form label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
            color: #333;
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
