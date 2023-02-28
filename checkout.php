<?php 

require_once 'classes/connection.php';
require_once 'classes/product.php';
require_once 'classes/order.php';
require_once 'classes/querys.php';
?>
<html>
    <head>
        <Title>Sinus Skateshop</Title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <?php include 'resource/header.php'; ?>
        <main>
                

            <table>
                <tr>
                    <th>Product</th>
                    <th>Colour</th>
                    <th>Size</th>
                    <th>Qty</th>
                    <th>á price</th>
                </tr>        
            <?php
            
            //$get = Querys::checkOut();

            $products = unserialize($_COOKIE['toOrder']);

            echo '<pre>';
            var_dump($products);
            echo '</pre>';
            
            ?>
            </table>
            <button class="prder"><a href="order.php">Check out</button>
</main>
        <?php include 'resource/footer.php'; ?>
</body>

