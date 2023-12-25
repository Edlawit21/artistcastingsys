<?php
session_start();

if (empty($_SESSION['id_admin'])) {
  header("Location: index.php");
  exit();
}

require_once("../db.php");

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Validate and process the form data
  $category = $_POST["category"];

  // Perform any necessary validation on the category input

  // Insert the category into the database
  $sql = "INSERT INTO tbl_categories (category) VALUES ('$category')";
  if ($conn->query($sql) === TRUE) {
    // Category added successfully
    header("Location: categories.php");
    exit();
  } else {
    // Error occurred while adding category
    $error = "An error occurred while adding the category.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Include necessary head elements -->
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <!-- Include necessary header elements -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px;">
    <section id="add-category" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 bg-white padding-2">
            <h3>Add Category</h3>
            <!-- Add category form -->
            <form method="post" action="">
              <div class="form-group">
                <label for="category">Category Name</label>
                <input type="text" class="form-control" id="category" name="category" placeholder="Enter category name" required>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <!-- Display error message if applicable -->
            <?php if (isset($error)) { ?>
              <p class="text-danger"><?php echo $error; ?></p>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- Include necessary footer elements -->
</div>
<!-- ./wrapper -->
</body>
</html>
