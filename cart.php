<html>
    <head>
        <Title>Sinus Skateshop</Title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <header Class="cartHeader">
            <img src="resource/logo/header-logo.png" alt="Sinus Logo">
            <button ><a href="index.php">Home</a></button>
        </header>
        <main class="cart">
            <h2>Shoppingcart</h2>

            <table>
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Colour</th>
                <th>á price</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
<?php 
require_once './ssLib.php';
require_once './classes/connection.php';

$productID = cDeserialize();

$unitPrice = [];
$totalPrice = 0;

$conn = connection::conn();

$lenght = count($productID);

for($i = 0; $i <= $lenght -1; $i++)
{
    $stmt = $conn->prepare("SELECT P.ProductID, C.Name, P.Price, P.Size, P.Colour FROM products AS P
    INNER JOIN category AS C
    ON P.CategoryID = C.CategoryID
    WHERE P.ProductID = (?);");

    $stmt->bind_param("i", $ID);

    // set parameters and execute
    $ID = $productID[$i][0];
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0)
    {
            
        while ($row = $result->fetch_assoc()) 
        {
        echo "<tr>
        <td>" . $row['Name'] . "</td>
        <td>" . $row['Size'] . "</td>
        <td>" . $row['Colour'] . "</td>
        <td>" . $row['Price'] . "</td>
        <td>" . $productID[$i][1] . "</td>
        <td>" . ($row['Price'] * $productID[$i][1]). "</td>
        </tr>";
        $unitPrice[] = ($row['Price'] * $productID[$i][1]);
        }
    
    }
}

foreach($unitPrice as $fields => $values)
{
    $totalPrice += $values;
}
            ?>
            <tr>
                <td class="total">Total <?= ' ' . $totalPrice?></td>
            </tr>
            </table>
            <button ><a href="memberorder.php">Checkout member</a></button>;
            <button class="checkOut"><a href="order1.php">Check out new customer</button>
        </main>
        <?php include 'resource/footer.php'; ?>
</body>

