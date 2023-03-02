<?php

// Define MySQL database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sinus_skate";

// Create MySQL connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if a form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted form data
    $product_id = $_POST["ProductID"];
    $product_colour = $_POST["Colour"];
    $product_size = $_POST["Size"];
    $product_price = $_POST["Price"];
    $product_category = $_POST["CategoryID"];

    // Update the product information in the database
    $sql = "UPDATE products SET Colour='$product_colour', Size='$product_size', Price='$product_price', CategoryID='$product_category' WHERE ProductID='$product_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Product information updated successfully.";
    } else {
        echo "Error updating product information: " . mysqli_error($conn);
    }
}

// Retrieve information about products
$sql = "SELECT * FROM products";
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
    <title>Product Administration</title>
</head>
<body>
    <h1>Product Administration</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Colour</th>
            <th>Size</th>
            <th>Price</th>
            <th>CategoryID</th>
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
                <input type="hidden" name="ProductID" value="<?php echo $product["ProductID"]; ?>">
                <td><input type="submit" value="Update"></td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
