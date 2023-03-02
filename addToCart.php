<?php
require 'ssLib.php';
$p = $_GET['product'];
$q = $_GET['quantity'];


addToCart($_GET['product'], $_GET['quantity']);
#cSerialize(array($p, $q));
#setCookie("cart", "John Doe", time()+3600)
$t = cDeserialize();
foreach ($t as $e) echo print_r($e)."<br>";

echo $_GET['product'];
echo $_GET['quantity'];
$loc = "shop.php?product=$p&msg=Added%20to%20cart!";
header('Location: '.$loc);


?>