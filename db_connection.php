<?php 


 
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "plugin";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
 
 
?>