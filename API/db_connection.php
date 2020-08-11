<?php 


 
 //$dbhost = "35.208.78.213";
//  $dbuser = "uach8q5vydzdw";
//  $dbpass = "wordpress123";
//  $db = "db8h564zb5cd4y";
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "creaddf";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
 
 
?>