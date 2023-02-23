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
    $sql = "SELECT * FROM products";
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
    return $out;
    #print_r($result);
}

function getAll() //test

{
    global $servername;
    global $username;
    global $password;
    global $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $i) {
                echo "<td>" .
                    $i . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    print_r($result);

    $conn->close();
}
?>