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

// Retrieve all orders from the database
$sql = "SELECT * FROM orders";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Check if there are any orders
    if (mysqli_num_rows($result) > 0) {
        // Display the orders in a table
        echo "<h1>All Orders</h1>";
        echo "<table>";
        echo "<tr><th>Order ID</th><th>Customer ID</th><th>Order Date</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["OrderID"] . "</td>";
            echo "<td>" . $row["CustomerID"] . "</td>";
            echo "<td>" . $row["OrderDate"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No orders found.";
    }
} else {
    echo "Error retrieving orders: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
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

// Initialize the customer ID variable
$customer_id = "";

// Check if a customer ID has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["customer_id"])) {
    // Get the customer ID from the submitted form data
    $customer_id = $_POST["customer_id"];

    // Retrieve order history for the specified customer
    $sql = "SELECT orders.OrderID, orders.OrderDate, orderdetails.ProductID, orderdetails.Qty, orderdetails.Price, orderdetails.TotalPrice
            FROM orders
            INNER JOIN orderdetails ON orders.OrderID = orderdetails.OrderID
            WHERE orders.CustomerID = '$customer_id'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        // Check if there are any orders for the customer
        if (mysqli_num_rows($result) > 0) {
            // Display the order history in a table
            echo "<h1>Order History for Customer #$customer_id</h1>";
            echo "<table>";
            echo "<tr><th>Order ID</th><th>Order Date</th><th>Product ID</th><th>Quantity</th><th>Price</th><th>Total Price</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["OrderID"] . "</td>";
                echo "<td>" . $row["OrderDate"] . "</td>";
                echo "<td>" . $row["ProductID"] . "</td>";
                echo "<td>" . $row["Qty"] . "</td>";
                echo "<td>" . $row["Price"] . "</td>";
                echo "<td>" . $row["TotalPrice"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No orders found for customer #$customer_id.";
        }
    } else {
        echo "Error retrieving order history: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">  
</head>
<body>
    <h1>Order History Lookup</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="customer_id">Customer ID:</label>
        <input type="text" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
        <input type="submit" value="Search">
    </form>
</body>
</html>
