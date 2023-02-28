<?php 

?>
<html>
    <head>
        <Title>Sinus Skateshop</Title>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Products: <input type="text" name="product_id">
  Product name:<input type="text" name="product_name">
  Product price:<input type="text" name="product_price">
  Product size:<input type="text" name="product_size">
  Product category:<input type="text" name="product_category">
        <input type="submit">
        </form>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <?php include 'resource/header.php'; ?>
        <main>
        <?php
// Connect to the database
include 'ssLib.php';
queryToProducts();

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
            <th>Name</th>
            <th>Price</th>
            <th>Size</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <td><?php echo $product["id"]; ?></td>
                <td><input type="text" name="product_name" value="<?php echo $product["name"]; ?>"></td>
                <td><input type="number" name="product_price" value="<?php echo $product["price"]; ?>"></td>
                <td><input type="text" name="product_size" value="<?php echo $product["size"]; ?>"></td>
                <td><input type="text" name="product_category" value="<?php echo $product["category"]; ?>"></td>
                <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                <td><input type="submit" value="Update"></td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

</main>
        <?php include 'resource/footer.php'; ?>
</body>
