<?php
include 'ssLib.php';

session_start();
//TODO this is a big mess
if (isset($_POST['new'])) { //Search press
    if (isset($_POST['category'])) $ca = $_POST['category']; else $ca = "1"; //TODO ? operands
    if (isset($_POST['size'])) $s = $_POST['size']; else $s=""; 
    if (isset($_POST['color'])) $co = $_POST['color']; else $co="";

    $products = queryToProducts($ca, $s, $co);
    if (!$products) { //if No results
        header('Location: shop.php?err=No%20Results');
        $products = queryToProducts("1", "", "");
    } else {
        $highlight=$products[0]->getId();
        $_SESSION['Filter'] = array($ca, $s, $co);
    } 
} else { //Item click or enter page
    if (isset($_SESSION['Filter'])) {
        $old = $_SESSION['Filter'];
        $products = queryToProducts($old[0], $old[1], $old[2]);
        $highlight=$products[0]->getId();
    } else {
        $_SESSION['Filter'] = array("1", "", "");
        $products = queryToProducts("1", "", "");
        $highlight=$products[0]->getId();

    }
}

if (isset($_GET['product'])) $highlight = $_GET['product'];
$slider = getProductImage($highlight);

?>
<html>
<head>
    <Title>Sinus Skateshop</Title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/shop.css">
    <script src="main.js"></script>
</head>

<body>
    <?php include 'resource/header.php'; ?>
    <main>
        <div class=controls>
            <form action="shop.php" method="post">
                <input type="text" name="searchTerm">
                <select name="category" id=""> <!-- TODO hide on non clothing -->
                    <option value="">All</option>
                    <option value="1">Hoodies</option>
                    <option value="2">Caps</option>
                    <option value="3">T-shirts</option>
                    <option value="4">Wheels</option>
                    <option value="5">Skateboards</option>
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
                <input type="hidden" name="new" value="true">
<input type="submit" value="Search">
            </form>
        </div>
        <?php
        if (!isset($_GET['err'])) {
            presentHighlight($highlight);
            echo "<h2>Other search results:</h2>";
            echo "<div class=\"boxes\">";
            present($products);
        } else echo $_GET['err'];
        ?>
        </div>
    </main>
    <?php include 'resource/footer.php'; ?>
        <script>
        var imgArray = [
            <?php
            foreach ($slider as $img) {
                echo "'resource/products/".$img."',";
            } 
                ?>
        ];
        var curIndex = 0;
        var imgDuration = 3000;
    
        function slideShow() {
            document.getElementById('image1').src = imgArray[curIndex];
            curIndex++;
            if (curIndex == imgArray.length) { curIndex = 0; }
            setTimeout("slideShow()", imgDuration);
        }
        slideShow();
    </script>
</body>
</html>