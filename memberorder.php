
<!DOCTYPE HTML>  
<html>
<head>
<Title>Sinus Skateshop</Title>
    <link rel="stylesheet" href="css/cart_chekout.css">
</head>
<body>  
<?php
include 'resource/header.php';
?>
<main class="cart">
    <h2>Your order</h2>
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

        $productID = cDeserialize(); // gets the array for product and qty

        $unitPrice = [];
        $totalPrice = 0;
        $cur = $_COOKIE['CUR'];

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
                ($_COOKIE['CUR'] == 'EUR' ? $price = toEUR($row['Price']) :  $price = $row['Price']);   
                echo "<tr>
                <td>" . $row['Name'] . "</td>
                <td>" . $row['Size'] . "</td>
                <td>" . $row['Colour'] . "</td>
                <td>" . $price . $cur . "</td>
                <td>" . $productID[$i][1] . "</td>
                <td>" . ($price * $productID[$i][1]). "</td>
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
                <td class="total">Total <?= ' ' . $totalPrice . $cur?></td>
            </tr>
            </table>
            </main>
<?php


$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

    if (empty($_POST["email"])) 
    {
        $emailErr = "Email is required";
    } 
    else 
    {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

}
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
<?php // form for inputing an email of an existing customer?>
    <h2>Type in your E-Mail and click order to complet your purchase.</h2>
    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    
    E-mail: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span>
    <br><br>

    <input type="submit" name="submit" value="order">  
    </form>

<?php

$_SESSION['email'] = $email;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (checkEmail($_SESSION['email']) == 0)
    {
        echo 'Wrong Email input';
    }
    else
    {
    require_once 'classes/connection.php';
        
    $conn = connection::conn();

    $stmt = $conn->prepare("CALL SP_MakeOrder(?, @OrderID);");
    $stmt->bind_param("s", $ordereMail);
    
    $ordereMail = $_SESSION['email'];

        echo '<pre>';
        print_r($_SESSION['email']);
        echo '</pre>';


        $stmt->execute();

        $sql = "SELECT @OrderID";

        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {

                $_SESSION['orderID'] = $row['@OrderID'];
            }
        } 
        else 
        {
            echo "0 results";
        }

        $productID = cDeserialize(); // gets the array for product and qty
        $lenght = count($productID);

        for($i = 0; $i < $lenght ; $i++)
        {
            $stmt = $conn->prepare("CALL SP_PlaceOrder(?, ?, ?);");
            $stmt->bind_param("iii", $orderID, $_productID, $qty);

            $orderID = $_SESSION['orderID'];
            $_productID = $productID[$i][0];
            $qty = $productID[$i][1];

            $stmt->execute();
        }

    $conn->close();

    // kills the cookie after order is confirmed
    killCookie($arr);
    header('location: ./orderSent.php');
}
}


include 'resource/footer.php';
?>
</body>
</html>

