<?php 
require_once './ssLib.php';
require_once './classes/connection.php';
include './resource/header.php';
?>

<?php
$productID = cDeserialize();

$unitPrice = [];
$totalPrice = 0;

$conn = connection::conn();

$lenght = count($productID);

for($i = 0; $i <= $lenght -1; $i++)
{
    $stmt = $conn->prepare("CALL SP_");

    $stmt->bind_param("i", $ID);

    // set parameters and execute
    $ID = $productID[$i][0];
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0)
    {
            
        while ($row = $result->fetch_assoc()) 
        {
        echo "<tr>
        <td>" . $row['Name'] . "</td>
        <td>" . $row['Size'] . "</td>
        <td>" . $row['Colour'] . "</td>
        <td>" . $row['Price'] . "</td>
        <td>" . $productID[$i][1] . "</td>
        <td>" . ($row['Price'] * $productID[$i][1]). "</td>
        </tr>";
        $unitPrice[] = ($row['Price'] * $productID[$i][1]);
        }
    
    }
}

foreach($unitPrice as $fields => $values)
{
    $totalPrice += $values;
}



//setCookie("cart", serialize($arr), time()-3600);
            ?>
            <tr>
                <td class="total">Total <?= ' ' . $totalPrice?></td>
            </tr>
            </table>
<?php
    include 'resource/footer.php';
?>