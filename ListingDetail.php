<?php 
if (isset($_GET['ID'])&& $_GET['ID']!="" ) {
    echo "<mark>ID=".$_GET['ID']."</mark><br/>";


    $url = "http://localhost:1000/wordpress/wp-content/plugins/crea/listing.php?id=".$_GET['ID'];
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 4);
$json = curl_exec($ch);
if(!$json) {
    echo curl_error($ch);
}
curl_close($ch);
print_r(json_decode($json));
}
echo "<h1>hello world</h1>";
?>