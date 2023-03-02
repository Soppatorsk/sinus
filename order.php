<?php
require_once './ssLib.php';
session_start();

?>

<html>
    <head>
        <Title>Sinus Skateshop</Title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <header Class="cartHeader">
            <img src="resource/logo/header-logo.png" alt="Sinus Logo">
        </header>
        <main class="cart">

    <form class="customer" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <label for="fname">First name:</label><br>
    <input class="adress" type="text" id="fname" name="fname" required><br>
    <label for="lname">Last name:</label><br>
    <input class="adress" type="text" id="lname" name="lname" required><br><br>
    <label for="lname">City:</label><br>
    <input class="adress" type="text" id="city" name="city" required><br><br>
    <label for="lname">Street:</label><br>
    <input class="adress" type="text" id="street" name="street" required><br><br>
    <label for="lname">Zip code:</label><br>
    <input class="adress" type="text" id="zipCode" name="zipCode" required><br><br>
    <label for="lname">Country:</label><br>
    <input class="adress" type="text" id="country" name="country" required><br><br>
    <label for="lname">Email:</label><br>
    <input class="adress" type="text" id="eMail" name="eMail" required><br><br>
    <input type="submit" value="Submit">
</form> 
<?php 
if(!isset($_POST['fname']))
{
    
}
else
{
require_once 'classes/connection.php';
$conn = connection::conn();


    $stmt = $conn->prepare("INSERT INTO `customers`(`FirstName`, `LastName`, `City`, `Street`, `Country`, `ZipCode`, `Email`) VALUES (?,?,?,?,?,?,?);");
    
    $stmt->bind_param("sssssis", $firstName, $lastName, $city, $street, $country, $zipCode, $eMail);
    
    //set parameters and execute
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $country = $_POST['country'];
    $zipCode = $_POST['zipCode'];
    $eMail = $_POST['eMail'];
    
    $stmt->execute();
    
    $result = $stmt->get_result();
}


            ?>
        </main>
        <?php include 'resource/footer.php'; ?>
</body>