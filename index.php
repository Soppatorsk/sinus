
<?php
 
if (!isset($_COOKIE['CUR'])) setcookie('CUR', 'SEK', time()+9999);
header('Location: shop.php');
?>

