
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

echo '<h2>Price: $'.$json['Price'].'</h2>';

?>
</div>
<?php 
echo '<p>'.$json['PublicRemarks'].'</p>';
?>
<h3>Property Details</h3>
<table border=1>
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
<table border=1>
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
    <strong>Age</strong>
    </td>
  <?php 
  if(array_key_exists('Age',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['Age'].'
      </td>';
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
    <strong>ArchitecturalStyle</strong>
    </td>
  <?php 
  if(array_key_exists('ArchitecturalStyle',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['ArchitecturalStyle'].'
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
    <strong>Construction Style Attachment</strong>
    </td>
  <?php 
  if(array_key_exists('ConstructionStyleAttachment',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['ConstructionStyleAttachment'].'
      </td>';
  }
  ?>
    
</tr>
<tr>
    <td>
    <strong>Stories Total</strong>
    </td>
  <?php 
  if(array_key_exists('StoriesTotal',$json['Building'])){
    if($json['Building']['StoriesTotal']!='None'){
      echo '<td class="text-right">
      '.$json['Building']['StoriesTotal'].'
      </td>';
    }

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
<tr>
    <td>
    <strong>Size Interior</strong>
    </td>
  <?php 
  if(array_key_exists('SizeInterior',$json['Building'])){
      if(is_array($json['Building']['SizeInterior'])){
        echo '<td class="text-right">
        '.implode(" ",$json['Building']['SizeInterior']).'
        </td>';
      }else{
        echo '<td class="text-right">
        '.$json['Building']['SizeInterior'].'
        </td>';
        
      }

  }
  ?>
    
</tr>
<tr>
    <td>
    <strong>Utility Water</strong>
    </td>
  <?php 
  if(array_key_exists('UtilityWater',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['UtilityWater'].'
      </td>';
  }
  ?>
    
</tr>
<tr>
    <td>
    <strong>Type</strong>
    </td>
  <?php 
  if(array_key_exists('Type',$json['Building'])){
    echo '<td class="text-right">
      '.$json['Building']['Type'].'
      </td>';
  }
  ?>
    
</tr>
	</tbody>
</table>
   <!-- For Rooms PHP coding -->
    <?php 
    if(array_key_exists('Rooms',$json['Building'])){
       echo '<h3>Rooms</h3>
       <table border=1>
         <thead>
           <tr>
             <th>Level</th>
             <th>Type</th>
             <th>Length</th>
             <th>Width</th>
             <th>Dimension</th>
           </tr>
         </thead>
         <tbody>';
      foreach($json['Building']['Rooms']['Room'] as $item){
        echo '<tr>';
        //for level
        echo '<td colspan=1>'.$item['Level'].'</td>';
        //for type
        echo '<td colspan=1>'.$item['Type'].'</td>';
        //for length
        if(is_array($item['Length'])){
          echo '<td colspan=1>'.implode(" ",$item['Length']).'</td>';
        }else{
          echo '<td colspan=1>'.$item['Length'].'</td>';
        }
        
        //for width
        if(is_array($item['Width'])){
          echo '<td colspan=1>'.implode(" ",$item['Width']).'</td>';
        }else{
          echo '<td colspan=1>'.$item['Width'].'</td>';
        }
        
        //for dimension
        if(is_array($item['Dimension'])){
          echo '<td colspan=1>'.implode($item['Dimension']).'</td>';
        }else{
          echo '<td colspan=1>'.$item['Dimension'].'</td>';
        }
        
        //ending row
        echo '</tr>';

  
      }//for each ends
      echo '</tbody>
          </table>';
  
    }
  ?>
  <!-- For Parking table -->
  <?php 
    if(array_key_exists('ParkingSpaces',$json)){
        if(array_key_exists('Parking',$json['ParkingSpaces'])){
            echo '<h3>Parking</h3>';
            echo '<table border=1>';
              
            foreach($json['ParkingSpaces']['Parking'] as $item){
              echo '<tr>';
              // var_dump($item);
              if(is_array($item)){
                echo '<td>'.implode($item).'</td>';
              }else{
                echo '<td>'.$item.'</td>';
              }
              //echo '<td>'.$item.'</td>';  
              echo '</tr>';
            }//for each ends
            echo '</table>';
        }//Parking ends
    }
  ?>
<!-- For Land Details table -->
    <?php 
    if(array_key_exists('Land',$json)){
        
        if(count($json['Land'])>0){
          echo '<h3>Land</h3>';
          echo '<table border=1 >';
          
          if(array_key_exists('Acreage',$json['Land'])){
            if($json['Land']['Acreage']==true){
              echo '<tr>';
              echo '<td>Acreage</td><td>Yes</td>';
              echo '</tr>';
            }else{
              echo '<tr>';
              echo '<td>Acreage</td><td>No</td>';
              echo '</tr>';
            }
          }

          foreach($json['Land'] as $key=>$value){
            echo '<tr>';
            if($key=='Acreage'){
              continue;
              
            }else{
              $label = preg_replace('/(?<!\ )[A-Z]/', ' $0', $key);
              echo '<td>'.$label.'</td>';
              if(is_array($value)){
                if(empty($value)){
                  echo '<td>Not Define</td>';
                }else{
                  echo '<td>'.implode(" ",$value).'</td>';
                }//check for empty ends
                
              }else{
                echo '<td>'.$value.'</td>';
              }
              
            }
            echo '</tr>';
          }//for each end
          echo '</table>';
        }//array length check end
    }//check for existance of array end
    ?>
</body>
</html>
