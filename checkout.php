<?php 

require_once 'ssLib.php';


;
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

            $products = cDeserialize();

            echo '<pre>';
            var_dump($products);
            echo '</pre>';
            
            ?>
            </table>
            <button class="prder"><a href="order.php">Check out</button>
</main>
        <?php include 'resource/footer.php'; ?>
</body>

