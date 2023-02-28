<?php
class Querys
{
    public static function checkOut()
        {
            $conn = connection::conn();

            $sql = "SELECT O.OrderDate, C.FirstName, C.LastName, CY.Name, P.Colour, P.Size, P.Price, OD.Qty, O.TotalPrice FROM orders AS O
                INNER JOIN orderdetails AS OD
                ON O.OrderID = OD.OrderID
                INNER JOIN customers AS C
                ON O.CustomerID = C.CustomerID
                INNER JOIN products AS P
                ON P.ProductID = OD.ProductID
                INNER JOIN category AS CY
                ON CY.CategoryID = P.CategoryID;";

            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $order = new Order($row['OrderDate'], $row['FirstName'], $row['LastName'], $row['Name'], $row['Colour'], $row['Size'], $row['Price'], $row['Qty'], $row['TotalPrice']); 

                    $checkOut[] = $order;
                }
                return $checkOut;
                $conn->close();
            }
        }
}
?>