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
</head>
<body>

<!-- Add Rice Button -->
<button id="openModalBtn">Add Rice</button>

<!-- Modal Structure -->
<div id="addRiceModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeModalBtn">&times;</span>
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