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
    public $description;


    public function __construct($id, $category, $colour, $size, $price, $description)
    {
        $this->id = $id;
        $this->category = $category;
        $this->colour = $colour;
        $this->size = $size;
        $this->price = $price;
        $this->description = $description;
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

    public function getDescription()
    {
        return $this->description;
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

function queryToProducts($searchTerm, $category, $size, $color)

{
    $out = array();
    $conn = ssDbConnect();
    $sql = "SELECT * FROM products WHERE 1 ";
    if ($searchTerm != "") {
        $sql .= "AND Description LIKE '%$searchTerm%' ";
    }
    if ($category != "") {
        $sql .= "AND CategoryID='$category' ";
    }
    if ($size != "") {
        $sql .= "AND Size='$size' ";
    }
    if ($color != "") {
        $sql .= "AND Colour='$color' ";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            #print_r($row['ProductID']);
            $p = new Product($row['ProductID'], $row['CategoryID'], $row['Colour'], $row['Size'], $row['Price'], $row['Description']);
            array_push($out, $p);
        }
    } else {
        return false;
    }
    #print_r($out);
    $conn->close();
    return $out; //returns an array of Product objects
}

function getProduct($id) //TODO unify database calls, multiple calls for same product? stupid

{
    $conn = ssDbConnect();
    $sql = "SELECT * From products WHERE ProductID='$id'";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    #var_dump(($result));
    $p = new Product($result['ProductID'], $result['CategoryID'], $result['Colour'], $result['Size'], $result['Price'], $result['Description']);
    return $p;
}

function getProductImage($id)
{
    $conn = ssDbConnect();
    $sql = "SELECT * From productimages WHERE id='$id'";
    $out = array();

    $result = $conn->query($sql);
    while ($row = $result->fetch_array()) {
        array_push($out, $row[1]);
    }

    return $out;
}

function present($array)
{ //show variants

    foreach ($array as $p) {
        $id = $p->getId();
        $col = $p->getColour();
        if ($p->getCategory() < 4) $size = "(".$p->getSize().")"; else $size = "";
        $price = $p->getPrice();

        $imgPath = "resource/products/" . getProductImage($id)[0];
        $cat = getCategoryVerbose($p->getCategory());
        $desc = $cat['Description'];
        $title = $col . " " . $cat['Name'];

        if ($_COOKIE['CUR'] == 'EUR') $price = toEUR($price)." EUR"; 
        else $price = $price." SEK";

        echo <<<EOT
        <a href="?product=$id">
                <div class=box>
                <h2></h2>
                <br>
                <img src="$imgPath">
                <br>
                <p></p>
                <p>$price</p>
                </div>
        </a>
        EOT;
    }
}

function presentHighlight($id) 
{ //show selected item
    $p = getProduct($id);
    $c = $p->getCategory();
    $cat = getCategoryVerbose($p->getCategory());
    $catName = $cat['Name'];
    $title = $p->getColour()." ".$catName;
    #$desc = $cat['Description']." (".$p->getSize().")";
    $desc = $p->getDescription();
    $price = $p->getPrice();
    $msg = isset($_GET['msg']) ? $_GET['msg'] : ""; 
    $imgs = getProductImage($id);
    if (count($imgs) > 1) {
            $imgView = "<div><img id=\"image1\"></div>";
    } else {
        $imgView = "<img src=\"resource/products/".$imgs[0]."\">";
    }
        if ($_COOKIE['CUR'] == 'EUR') $price = toEUR($price)." EUR"; 
        else $price = $price." SEK";



    echo <<<EOT
        <div id="highlight">
            <div class="left">
                <h1>$title</h1>
                $imgView
                <p>$desc</p>
            </div>
            <div class="right">
                <p>$price</p>
                <p>Add to cart:</p>
                <form action="addToCart.php">
                <input type="hidden" name="product" value="$id">
                <input type="number" name="quantity" id="" value="1" min="1" max="99">
                    <input type="submit" value="Place in cart">
                </form>
                $msg
            </div>
        </div>
        EOT;
}

function getCategoryVerbose($category)
{
    $conn = ssDbConnect();
    $sql = "SELECT * FROM Category where CategoryID='$category'";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result;
}

function addToCart($id, $q)
{ 
    $arr = cDeserialize();
    $new = array($id, $q);
    $found = false;
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i][0] == $id) {
            $arr[$i][1] += $q; //productid already in array, append
            $found = true;
        }
    }
    if (!$found)
        array_push($arr, $new);
    cSerialize($arr);
}

function cSerialize($arr)
{
    setCookie("cart", serialize($arr), time() + 3600);
}

function cDeserialize()
{
    if (isset($_COOKIE['cart'])) {
        return unserialize($_COOKIE['cart']);
    }
    return array();
}

function killCookie($arr)
{
setCookie("cart", serialize($arr), time() - 3600);
}

function checkEmail($eMail)
{

    $conn = ssDbConnect();

    $stmt = $conn->prepare("SELECT count(CustomerID) FROM `customers` WHERE Email = (?);");
    $stmt->bind_param("s", $eMail);

     // set parameters and execute
     $eMail = $eMail;
     $stmt->execute();
 
     $result = $stmt->get_result();
 
     if ($result->num_rows > 0)
     {
             
         while ($row = $result->fetch_assoc())
         {
            return $row['count(CustomerID)'];
         }
    }

}
function getEURRate() {
 $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=EUR&from=SEK&amount=1",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: text/plain",
        "apikey: r2hVGYn5mbu0h55tRMTX2TfY5ZJwMdR6"
      ),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET"
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
    $js = json_decode($response, true);
    $rate = $js['info']['rate'];

    return $rate;
}
    
function toEUR($i) {
    //TODO check
   return round($i * $_COOKIE['EURORATE']);
}

function delete($id)
{
    $productID = cDeserialize();
    unset($productID[$id]); 
    $uppdated = array_values($productID); 
    cSerialize($uppdated);
    header("Refresh:0");
}

?>