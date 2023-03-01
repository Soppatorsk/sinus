<?php
// Connect to the database
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

echo "Connected successfully";
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

// Check if a form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted form data
    $product_id = $_POST["product_id"];
    $product_name = $_POST["product_name"];
    $product_price = $_POST["product_price"];
    $product_size = $_POST["product_size"];
    $product_category = $_POST["product_category"];

    // Update the product information in the database
    $sql = "UPDATE products SET name='$product_name', price='$product_price', size='$product_size', category='$product_category' WHERE id='$product_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Product information updated successfully.";
    } else {
        echo "Error updating product information: " . mysqli_error($conn);
    }
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
            <th>Name</th>
            <th>Price</th>
            <th>Size</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <tr>
            <td><?php echo $product["id"]; ?></td>
            <td><input type="text" name="product_name" value="<?php echo $product["name"]; ?>"></td>
            <td><input type="number" name="product_price" value="<?php echo $product["price"]; ?>"></td>
            <td><input type="text" name="product_size" value="<?php echo $product["size"]; ?>"></td>
            <td><input type="text" name="product_category" value="<?php echo $product["category"]; ?>"></td>
            <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
            <td><input type="submit" value="Update"></td>
            </tr>
            </form>
        <?php endforeach; ?>
        
        
    </table>
    <main>
    <?php include 'resource/footer.php'; ?>
    </main>
</body>
</html>
