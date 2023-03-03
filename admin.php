<?php
require_once './ssLib.php';
//Log in to the database built in check incase connection fails.
$conn = ssDbConnect();

// Check if a form has been submitted for updating a product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the submitted form data
  $product_id = isset($_POST["ProductID"]) ? $_POST["ProductID"] : "";
  $product_colour = isset($_POST["Colour"]) ? $_POST["Colour"] : "";
  $product_size = isset($_POST["Size"]) ? $_POST["Size"] : "";
  $product_price = isset($_POST["Price"]) ? $_POST["Price"] : "";
  $product_category = isset($_POST["CategoryID"]) ? $_POST["CategoryID"] : "";
  $product_description = isset($_POST["description"]) ? $_POST["description"] : "";

  // Update the product information in the database
  $sql = "UPDATE products SET Colour='$product_colour', Size='$product_size', Price='$product_price', CategoryID='$product_category', Description='$product_description' WHERE ProductID='$product_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
      echo "Product information updated successfully.";
  } else {
      echo "Error updating product information: " . mysqli_error($conn);
  }
}


// Check if a form has been submitted for adding a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_product_id"]) && isset($_POST["new_colour"]) && isset($_POST["new_size"]) && isset($_POST["new_price"]) && isset($_POST["new_category_id"])) {
  // Get the submitted form data
  $product_id = $_POST["new_product_id"];
  $product_colour = $_POST["new_colour"];
  $product_size = $_POST["new_size"];
  $product_price = $_POST["new_price"];
  $product_category = $_POST["new_category_id"];
  $product_description = $_POST["new_product_description"];
  

  // Insert the new product information into the database
  $sql = "INSERT INTO products (ProductID, Colour, Size, Price, CategoryID) VALUES ('$product_id', '$product_colour', '$product_size', '$product_price', '$product_category','$product_description')";
  $result = mysqli_query($conn, $sql);

  if ($result) {
      echo "New product added successfully.";
  } else {
      echo "Error adding new product: " . mysqli_error($conn);
  }
}

// Retrieve information about products
$sql = "SELECT ProductID, Colour, Size, Price, CategoryID, Description FROM products";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Create an array to store the products
    $products = array();

    // Fill in the products array with information from the database
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
} else {
    echo "No products found.";
}


// Close the database connection
mysqli_close($conn);
?>

<html>
<head>
 
</head>
<body>
    <h1>Product Administration</h1>
    <a href="shop.php">Take me back to the shop!</a>
    <br><br>
    <a href="AdminOrderHistory.php">What are past and current orders?</a>
    <h2>Update existing product</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Colour</th>
            <th>Size</th>
            <th>Price</th>
            <th>CategoryID</th>
            <th>Product Description</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <td><?php echo $product["ProductID"]; ?></td>
                <td><input type="text" name="Colour" value="<?php echo $product["Colour"]; ?>"></td>
                <td><input type="text" name="Size" value="<?php echo $product["Size"]; ?>"></td>
                <td><input type="number" name="Price" value="<?php echo $product["Price"]; ?>"></td>
                <td><input type="text" name="CategoryID" value="<?php echo $product["CategoryID"]; ?>"></td>
                <td><input type="text" name="description" value="<?php echo $product["Description"]; ?>"></td>
                <input type="hidden" name="ProductID" value="<?php echo $product["ProductID"]; ?>">
                <td><input type="submit" value="Update"></td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Add a new product</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr>
                <td><label for="new-product-id">Product ID:</label></td>
                <td><input type="text" id="new-product-id" name="new_product_id" required></td>
            </tr>
            <tr>
                <td><label for="new-colour">Colour:</label></td>
                <td><input type="text" id="new-colour" name="new_colour" required></td>
            </tr>
            <tr>
                <td><label for="new-size">Size:</label></td>
                <td><input type="text" id="new-size" name="new_size" required></td>
            </tr>
            <tr>
                <td><label for="new-price">Price:</label></td>
                <td><input type="number" id="new-price" name="new_price" min="0" step="0.01" required></td>
            </tr>
            <tr>
                <td><label for="new-category-id">Category ID:</label></td>
                <td><input type="text" id="new-category-id" name="new_category_id" required></td>
            </tr>
            <tr>
                <td><label for="new-product-description">Product Description:</label></td>
                <td><input type="text" id="new-product-description" name="new_product_description" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Add product"></td>
            </tr>
        </table>
    </form>