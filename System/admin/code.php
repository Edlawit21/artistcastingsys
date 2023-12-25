<?php
// code.php

// Start the session
session_start();

// Check if the admin is logged in
if (empty($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

// Include the database connection
require_once("../db.php");

// Check if the form is submitted
if(isset($_POST['registerbtn'])){
    // Get the category name from the form
    $categoryName = $_POST['categoryname'];

    // Perform necessary validation on the category name

    // Save the category name to the database
    $sql = "INSERT INTO tbl_categories (category) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $categoryName);

    // Execute the statement
    if ($stmt->execute()) {
        // Category name successfully inserted
   $stmt->close();
    $conn->close();

    header("Location: categories.php");
    exit();
  } else {
    // handle the case where the category couldn't be saved
    echo "Error: Category could not be saved.";
  }
}
?>
