<?php 
include 'ssLib.php';
?>
<html>
    <head>
        <Title>Sinus Skateshop</Title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <?php include 'resource/header.php'; ?>
        <main>
            <?php 
            #getall();
            print_r(queryToProducts()[2]);
            ?>
</main>
        <?php include 'resource/footer.php'; ?>
</body>

