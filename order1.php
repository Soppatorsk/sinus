
<!DOCTYPE HTML>  
<html>
<head>
<Title>Sinus Skateshop</Title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>  
<?php
include 'resource/header.php';
?>
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
            </main>
<?php

session_start();
// define variables and set to empty values
$firstNameErr = $lastNameErr = $cityErr = $emailErr = $countryErr = $zipCodeErr = $streetErr = "";
$firstName = $lastName = $city = $email = $country = $zipCode = $street = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

    if (empty($_POST["fname"])) 
    {
        $firstNameErr = "First name is required";
    } 
    else 
    {
        $firstName = test_input($_POST["fname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$firstName)) {
        $firstNameErr = "Only letters and white space allowed";
        }
    }
    
    if (empty($_POST["lname"])) 
    {
        $lastNameErr = "Last name is required";
    } 
    else 
    {
        $lastName = test_input($_POST["lname"]);
    }

    if (empty($_POST["city"])) {
        $cityErr = "City is required";
    }
    else 
    {
        $city = test_input($_POST["city"]);
    }
    
    if (empty($_POST["street"])) 
    {
        $streetErr = "Street is required";
    }
    else 
    {
        $street = test_input($_POST["street"]);
    }

    if (empty($_POST["zipcode"]))
    {
        $zipCodeErr = "Zipcode is required";
    } 
    else 
    {
        $zipCode = test_input($_POST["zipcode"]);
    }
        
    if (empty($_POST["country"])) 
    {
        $countryErr = "Country is required";
    } 
    else 
    {
        $country = test_input($_POST["country"]);
    }
        
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

<h2>Type in your information and click order to complet your purchase.</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  First Name: <input type="text" name="fname" value="<?php echo $firstName;?>">
  <span class="error">* <?php echo $firstNameErr;?></span>
  <br><br>
  Last Name: <input type="text" name="lname" value="<?php echo $lastName;?>">
  <span class="error">*<?php echo $lastNameErr;?></span>
  <br><br>
  City: <input type="text" name="city" value="<?php echo $city;?>">
  <span class="error">*<?php echo $cityErr;?></span>
  <br><br>
  Street: <input type="text" name="street" value="<?php echo $street;?>">
  <span class="error">*<?php echo $streetErr;?></span>
  <br><br>
  Zipcode: <input type="text" name="zipcode" value="<?php echo $zipCode;?>">
  <span class="error">*<?php echo $zipCodeErr;?></span>
  <br><br>
  Country: <input type="text" name="country" value="<?php echo $country;?>">
  <span class="error">*<?php echo $countryErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>

  <input type="submit" name="submit" value="Order">  
</form>

<?php
$_SESSION['fname'] = $firstName;
$_SESSION['lname'] = $lastName;
$_SESSION['city'] = $city;
$_SESSION['street'] = $street;
$_SESSION['zipcode'] = $zipCode;
$_SESSION['country'] = $country;
$_SESSION['email'] = $email;


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    if(checkEmail($_SESSION['email']) > 0 )
    {   
        echo 'Email already exist.';    
    }
    else
    {
        require_once 'classes/connection.php';
        
        $conn = connection::conn();
        
        $stmt = $conn->prepare("INSERT INTO `customers`(`FirstName`, `LastName`, `City`, `Street`, `Country`, `ZipCode`, `Email`) VALUES (?,?,?,?,?,?,?);");
        
        $stmt->bind_param("sssssis", $firstName, $lastName, $city, $street, $country, $zipCode, $eMail);
        
        //set parameters and execute
        $firstName = $_SESSION['fname'];
        $lastName = $_SESSION['lname'];
        $city = $_SESSION['city'];
        $street =$_SESSION['street'];
        $country = $_SESSION['country'];
        $zipCode = $_SESSION['zipcode'];
        $eMail = $_SESSION['email'];
        
        $stmt->execute();


        $stmt = $conn->prepare("CALL SP_MakeOrder(?, @OrderID);");
        $stmt->bind_param("s", $ordereMail);

        $ordereMail = $eMail;

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

        $productID = cDeserialize();
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
    }
    header('location: ./orderSent.php');

}
include 'resource/footer.php';
?>
</body>
</html>

