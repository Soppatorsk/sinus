<html>
    <head>
        <Title>Sinus Skateshop</Title>
        
        <link rel="stylesheet" href="css/cart_chekout.css">
    </head>
    <body>
        <header Class="cartHeader">
            <img src="resource/logo/header-logo.png" alt="Sinus Logo">

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
session_start();
require_once './ssLib.php';

$productID = cDeserialize();

$unitPrice = [];
$totalPrice = 0;

$conn = ssDbConnect();
if(array_key_exists('button1', $_POST)) {
    $id = (int)$_POST['productID'];
    delete($id);
}

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
        <td><form method='post'>
        <input type='hidden' name='productID' value='$i'></input>
        <input type='submit' name='button1'
        class='button' value='Remove product'></input>  
        </form>    
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
        <div class="buttons">
            <button class="shop"><a href="index.php">Back to the store</a></button>
            <button class="checkOut"><a href="memberorder.php">Checkout member</a></button>
            <button class="checkOut"><a href="newcustomerorder.php">Check out new customer</a></button>
        </div>
        </main>
        <?php include 'resource/footer.php'; ?>
</body>

<?php


?>
