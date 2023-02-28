<?php

class connection
{
    public static function conn()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sinus_skate";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }  
}
?>