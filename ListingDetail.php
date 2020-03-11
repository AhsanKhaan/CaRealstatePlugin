
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
if (isset($_GET['ID'])&& $_GET['ID']!="" ) {
   // echo "<mark>ID=".$_GET['ID']."</mark><br/>";


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
//$response=stripcslashes($json);
//$response=json_decode($json,true);
//$response=json_decode(stripcslashes($json));
//print_r($response);
echo  '<pre>';
echo  print_r(json_decode($json,true));
echo  '</pre>';
    //json_decode($json);

    
}//$_GET[] loop

?>

</body>
</html>