
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
//echo  '<pre>';
 $json=json_decode($json,true);
 // print_r($json);
//echo  '</pre>';
    //json_decode($json);

    
}//$_GET[] loop

?>
<h1><?php 
echo $json['Address']['StreetAddress'];
echo '<br/>';
echo $json['Address']['City'].',';
echo $json['Address']['Province'].'    ';
echo $json['Address']['PostalCode'];
?>

</h1>
<a href="#"> 
<img src="<?php
    $cover=$json['Photo']['PropertyPhoto'][0]['LargePhotoURL'];
    echo $cover;
?>" />
</a>
<ul>
<?php
foreach($json['Photo']['PropertyPhoto'] as $photo){
echo '<li><a href="#"><img src="'.$photo['PhotoURL'].'"/></a></li>';
}

?>
</ul>
<div>
<?php 
//print_r($json['Building']);
foreach($json['Building'] as $key => $item){
   //print_r('Key:'.$key.'Value:'.$item);
       switch($key){
        case 'BedroomsTotal':
            echo '<span style="font-size:40px;margin-right:30px;">'.$item.'Bedroom</span>';
    break;
        case 'BathroomTotal':
            echo '<span style="font-size:40px;margin-right:30px;">'.$item.'Bathroom</span>';
    break;
        case 'SizeInterior':
            echo '<span style="font-size:40px;margin-right:30px;">'.$item.'</span>';
    break;
        case 'ArchitecturalStyle':
            echo '<span style="font-size:30px;margin-right:30px;">'.$item.'</span>';
    break;
        case 'FireplacePresent':
            if ($item=='True'){
                echo '<span style="font-size:30px;margin-right:30px;">Fire Place</span>';
            }else{

            }
            
    break;
        case 'HeatingType':
            echo '<span style="font-size:30px;margin-right:30px;">'.$item.'</span>';
    break;
        case 'CoolingType':
            if(strpos($item, ",") !== false){
                $temp=explode(",",$item);
                //print_r($temp);
                echo '<span style="font-size:30px;margin-right:30px;">'.$temp[1].'</span>';
            } else{
                echo '<span style="font-size:30px;margin-right:30px;">'.$item.'</span>';
            }
            
    break;
    
        default:
    }//switch ends

}//for each ends


?>
</div>
</body>
</html>
