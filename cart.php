<html>
    <head>
        <Title>Sinus Skateshop</Title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <header Class="cartHeader">
            <img src="resource/logo/header-logo.png" alt="Sinus Logo">
<<<<<<< Updated upstream
            <button ><a href="index.php">Home</a></button>
=======
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
require_once './ssLib.php';
require_once './classes/connection.php';

$productID = cDeserialize();

=======
require_once 'classes/connection.php';

$productID = [7, 5, 20];
$qty = [1, 1, 2];
>>>>>>> Stashed changes
$uniPprice = [];
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
<<<<<<< Updated upstream
    $ID = $productID[$i][0];
=======
    $ID = $productID[$i];
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
        <td>" . $productID[$i][1] . "</td>
        <td>" . ($row['Price'] * $productID[$i][1]). "</td>
        </tr>";
        $unitPrice[] = ($row['Price'] * $productID[$i][1]);
=======
        <td>" . $qty[$i] . "</td>
        <td>" . ($row['Price'] * $qty[$i]). "</td>
        </tr>";
        $unitPrice[] = $row['Price'];
>>>>>>> Stashed changes
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

            <button class="checkOut"><a href="checkout.php">Check out</button>
        </main>
        <?php include 'resource/footer.php'; ?>
</body>

