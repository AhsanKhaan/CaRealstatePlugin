
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

echo '<h2>'.$json['Price'].'</h2>';

?>
</div>
<?php 
echo '<p>'.$json['PublicRemarks'].'</p>';
?>
<h3>Property Details</h3>
<table>
<tbody>
<tr>
    <td>
    <strong>MLS® Number</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['ListingID'].'
    </td>';
  ?>
    
</tr>
<tr>
    <td>
    <strong>Property Type</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['PropertyType'].'
    </td>';
  ?>
    
</tr>
<tr>
    <td>
    <strong>Amenities NearBy</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['AmmenitiesNearBy'].'
    </td>';
  ?>
    
</tr>
<tr>
    <td>
    <strong>Equipment Type</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['EquipmentType'].'
    </td>';
  ?>
    
</tr>
<tr>
    <td>
    <strong>Features</strong>
    </td>
  <?php 
  if(is_array($json['Features'])){
    echo '<td class="text-right">
    '.implode(" ",$json['Features']).'
    </td>';
  }else{
    echo '<td class="text-right">
    '.$json['Features'].'
    </td>';
  }

  ?>
    
</tr>
<tr>
    <td>
    <strong>Parking Spaces Total</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['ParkingSpaceTotal'].'
    </td>';
  ?>
    
</tr>
<tr>
    <td>
    <strong>Rental Equipment Type</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['RentalEquipmentType'].'
    </td>';
  ?>
    
</tr>
	</tbody>
</table>

<!-- Building Output -->
<h3>Building</h3>
<table>
<tbody>
<tr>
    <td>
    <strong>Bathroom Total</strong>
    </td>
  <?php 
  if(array_key_exists('BathroomTotal',$json['Building'])){
    if($json['Building']['BathroomTotal']!='None'){
      echo '<td class="text-right">
      '.$json['Building']['BathroomTotal'].'
      </td>';
    }

  }

  ?>
    
</tr>
<tr>
    <td>
    <strong>Bedroom Above Ground</strong>
    </td>
  <?php 
  if(array_key_exists('BedroomsAboveGround',$json['Building'])){
    if($json['Building']['BedroomsAboveGround']!='None'){
      echo '<td class="text-right">
      '.$json['Building']['BedroomsAboveGround'].'
      </td>';
    }

  }

  ?>
    
</tr>
<tr>
    <td>
    <strong>Bedrooms Total</strong>
    </td>
  <?php 
  if(array_key_exists('BedroomsTotal',$json['Building'])){
    if($json['Building']['BedroomsTotal']!='None'){
      echo '<td class="text-right">
      '.$json['Building']['BedroomsTotal'].'
      </td>';
    }

  }

  ?>
    
</tr>
<tr>
    <td>
    <strong>Appliances</strong>
    </td>
  <?php 
  if(array_key_exists('Appliances',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['Appliances'].'
      </td>';
  }
  ?>
    
</tr>
<tr>
    <td>
    <strong>Constructed Date</strong>
    </td>
  <?php 
  if(array_key_exists('ConstructedDate',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['ConstructedDate'].'
      </td>';
  }
  ?>
    
</tr>
<tr>
    <td>
    <strong>Basement Type</strong>
    </td>
  <?php 
  if(array_key_exists('BasementType',$json['Building'])){
    if($json['Building']['BasementType']!='None'){
      echo '<td class="text-right">
      '.$json['Building']['BasementType'].'
      </td>';
    }

  }

  ?>
    
</tr>
<tr>
    <td>
    <strong>Cooling Type</strong>
    </td>
  <?php 
  if(array_key_exists('CoolingType',$json['Building'])){
    if($json['Building']['CoolingType']!='None'){
      echo '<td class="text-right">
      '.$json['Building']['CoolingType'].'
      </td>';
    }

  }

  ?>
    
</tr>
<tr>
    <td>
    <strong>Exterior Finish</strong>
    </td>
  <?php 
  if(array_key_exists('ExteriorFinish',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['ExteriorFinish'].'
      </td>';
  }
  ?>
    
</tr>
<tr>
    <td>
    <strong>FirePlace Present</strong>
    </td>
  <?php 
  if(array_key_exists('FireplacePresent',$json['Building'])){
    if($json['Building']['FireplacePresent']=='True'){
      echo '<td class="text-right">
      Yes
      </td>';
    }else{
      echo '<td class="text-right">
      No
      </td>';
    }
  }
  ?>
    
</tr>
<tr>
    <td>
    <strong>Amenities NearBy</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['AmmenitiesNearBy'].'
    </td>';
  ?>
    
</tr>
<tr>
    <td>
    <strong>Equipment Type</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['EquipmentType'].'
    </td>';
  ?>
    
</tr>
<tr>
    <td>
    <strong>Features</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.'
    </td>';
  ?>
    
</tr>
<tr>
    <td>
    <strong>Parking Spaces Total</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['ParkingSpaceTotal'].'
    </td>';
  ?>
    
</tr>
<tr>
    <td>
    <strong>Heating Type</strong>
    </td>
  <?php 
  if(array_key_exists('HeatingType',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['HeatingType'].'
      </td>';
  }
  ?>
    
</tr>
<tr>
    <td>
    <strong>Heating Fuel</strong>
    </td>
  <?php 
  if(array_key_exists('HeatingFuel',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['HeatingFuel'].'
      </td>';
  }
  ?>
    
</tr>
<tr>
    <td>
    <strong>Rental Equipment Type</strong>
    </td>
  <?php 
    echo '<td class="text-right">
    '.$json['RentalEquipmentType'].'
    </td>';
  ?>
    
</tr>
	</tbody>
</table>
</body>
</html>
