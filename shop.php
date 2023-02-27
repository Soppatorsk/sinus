<?php
include 'ssLib.php';
$p = $_GET['product'];
$c = $_GET['category'];
$s = $_GET['size'];
$co = $_GET['color'];

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
        <div class=controls>
            <form action="">
                <select name="category" id=""> <!-- TODO hide on non clothing -->
                    <option value="1">Hoodies</option>
                    <option value="2">Caps</option>
                    <option value="3">T-shirts</option>
                    <option value="4">Skateboards</option>
                    <option value="5">Wheels</option>
                </select>
                <select name="size" id="">
                    <option value="">All/None</option>
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                </select>
                <select name="color" id="">
                    <option value="">All</option>
                    <option value="Black">Black</option>
                    <option value="Red">Red</option>
                    <option value="Green">Green</option>
                    <option value="Blue">Blue</option>
                    <option value="Purple">Purple</option>
                    <option value="Yellow">Yellow</option>
                </select>
                <input type="hidden" name="product" value=1>
<input type="submit" value="Refresh">
            </form>
        </div>
        <?php
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