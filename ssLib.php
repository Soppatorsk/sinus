<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sinus_skate";


class Product
{
    public $id;
    public $category;
    public $colour;
    public $size;
    public $price;

    public function __construct($id, $category, $colour, $size, $price)
    {
        $this->id = $id;
        $this->category = $category;
        $this->colour = $colour;
        $this->size = $size;
        $this->price = $price;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function getColour()
    {
        return $this->colour;
    }
    public function getSize()
    {
        return $this->size;
    }

    public function getPrice()
    {
        return $this->price;
    }
}


function ssDbConnect()
{
    global $servername;
    global $username;
    global $password;
    global $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else
        return $conn;
}

function queryToProducts() //TODO arguments to pass to query
{
    $out = array();

    $conn = ssDbConnect();
    $sql = "SELECT * FROM products WHERE CategoryID='1' AND Size='Large'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            #print_r($row['ProductID']);
            $p = new Product($row['ProductID'], $row['CategoryID'], $row['Colour'], $row['Size'], $row['Price']);
            array_push($out, $p);
        }
    } else {
        return false;
    }
    #print_r($out);
    $conn->close();
    return $out; //returns an array of Product objects
}

function getProduct($id) {
    $conn = ssDbConnect();
    $sql = "SELECT * From products WHERE ProductID='$id'";

    $result = $conn->query($sql);
    $result = $result->fetch_array();
    return $result;
}

function present($array) { //show variants
    
    foreach ($array as $p) {
        $id = $p->getId();
        $col = $p->getColour();
        $price = $p->getPrice();
        
        $imgPath = "resource/products/hoodie-ash.png"; //TODO NOT SET   

        $cat = getCategoryVerbose($p->getCategory()); //TODO ass array bad EOT
        $desc = $cat['Description'];
        $title = $col." ".$cat['Name'];


        echo <<<EOT
        <a href="?product=$id">
                <div class=box>
                <h2>$title</h2>
                <br>
                <img src="$imgPath">
                <br>
                <p>$desc</p>
                <p>$price</p>
                </div>
        </a>
        EOT;
    }
}

function presentHighlight($id) { //show selected item
$p = getProduct($id);
$cat = getCategoryVerbose($p[1])['Name'];
$desc = getCategoryVerbose($p[1])['Description'];
$imgPath = "resource/products/hoodie-fire.png";
 echo <<<EOT
        <div id="highlight">
            <div class="left">
                <h1>$p[2] $cat</h1>
                <img src="$imgPath" alt="">
                <p>$desc</p>
            </div>
            <div class="right">
                <p>$p[4]</p>
                <p>QUANTITY</p>
                <form action="">
                    <input type="number" name="" id="" value="1" min="1" max="99">
                    <select name="" id="">
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                    </select>
                    <input type="button" value="Add to cart">
                </form>
            </div>
        </div>
        EOT;
}

function getCategoryVerbose($category) {
    $conn = ssDbConnect();
    $sql = "SELECT * FROM Category where CategoryID='$category'";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result;
}
?>