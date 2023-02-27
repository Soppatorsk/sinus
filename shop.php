<?php
include 'ssLib.php';
$p = $_GET['product'];
?>
<html>

<head>
    <Title>Sinus Skateshop</Title>
    <link rel="stylesheet" href="css/main.css">
    <script src="main.js"></script>
</head>

<body>
    <?php include 'resource/header.php'; ?>
    <main>
        <?php
        print_r(getProductImage($p));
        presentHighlight($p);
        ?>
        <div class="boxes">
        <?php
        #getall();
        present(queryToProducts());
        ?>
        </div>
    </main>
    <?php include 'resource/footer.php'; ?>
</body>