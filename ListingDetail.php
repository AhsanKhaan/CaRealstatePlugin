
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
       <!--Template based on URL below-->
       <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/starter-template/">
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <!-- Place your stylesheet here-->
        <link href="css/slider.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/wordpress/wordpress'.'/wp-load.php');
get_header();

if (isset($_GET['ID'])&& $_GET['ID']!="" ) {
   // echo "<mark>ID=".$_GET['ID']."</mark><br/>";


    $url = "http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/listing.php?id=".$_GET['ID'];
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

if(empty($json['Photo'])){
  echo '<h2>Images unavailable</h2>';
}else{
  foreach($json['Photo']['PropertyPhoto'] as $photo){
    echo '<li><a href="#"><img src="'.$photo['PhotoURL'].'"/></a></li>';
    }
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

    
  <?php 
  if($json['AmmenitiesNearBy']=="{}"){

  }else{
    echo '<tr>
    <td>
    <strong>Amenities NearBy</strong>
    </td>
    <td class="text-right">
    '.$json['AmmenitiesNearBy'].'
    </td>
    </tr>';
  }

  ?>
    


  <?php
   
  if($json['EquipmentType']=="{}"){

  }else{
    echo '<tr>
    <td>
    <strong>Equipment Type</strong>
    </td>
    <td class="text-right">
    '.$json['EquipmentType'].'
    </td>
    </tr>';
  }
    
  ?>

  <?php 
var_dump($json['Features']);
if(((is_string($json['Features']))&&($json['Features']==NULL))||((is_array($json['Features']))&&(count($json['Features'])==0))){

}else{
    echo '<tr>
    <td>
    <strong>Features</strong>
    </td>';
  if(is_array($json['Features'])){
    echo '<td class="text-right">
    '.implode(" ",$json['Features']).'
    </td>';
   }else{
    echo '<td class="text-right">
    '.$json['Features'].'
    </td>';
   }
   echo "</tr>";
}
  

  ?>
    


  <?php
  
    if($json['ParkingSpaceTotal']=="{}"){

    }else{ 
      echo '<tr>
      <td>
      <strong>Parking Spaces Total</strong>
      </td><td class="text-right">
      '.$json['ParkingSpaceTotal'].'
      </td>
      </tr>';
      }
  ?>
    


  <?php 
    if($json['RentalEquipmentType']==""){

    }else{
      echo '<tr>
      <td>
      <strong>Rental Equipment Type</strong>
      </td>
      <td class="text-right">
      '.$json['RentalEquipmentType'].'
      </td>
      </tr>';
    }

  ?>
    

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
                  echo '<td>Unknown</td>';
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
    get_footer();
    ?>
    

<div class="bootstrap-realtypress">
<div class="rps-single-listing">
   <div class="container-fluid">
    <div>
  	<!-- Schema Product Name -->
				<meta content="4 Lisa Rd, Toronto Ontario, M1G 2H9">
		    	<meta content="21799295">
		    	<meta content="2020-04-25 23:20:59">
		    	<meta content="Single Family">
	<div>
	    <div class="row">
      <!-- Back Button -->
    <div class="col-md-12">
      <ul class="breadcrumb">
        <li><a href="javascript:history.go(-1)" title="Return to the previous page">« Go back</a></li>
      </ul>
    </div><!-- /.col-md-12 --> 
      <div class="col-md-8 col-sm-7 col-xs-12">
    <!-- Address -->
    <h1 class="rps-text-center-sm" style="margin-top:0;">
      <span style="display:block;margin-bottom:0;">
        <?php echo $json['Address']['StreetAddress'];?>      </span>
      <small>
        <?php echo $json['Address']['City'];?>,
        <?php 
         echo $json['Address']['Province'];
         echo $json['Address']['PostalCode'];
        ?>
      </small>
    </h1>

  </div>
  <!-- /.col-md-8 .col-sm-7 -->
  <div class="col-md-4 col-sm-5 col-xs-12 text-right">
    <div class="rps-single-listing-favorites-wrap rps-text-center-sm">
              <button class="btn btn-lightgrey rps-add-favorite" style="background-color: lightgray;">
              <i class="fa fa-heart text-danger"></i> 
              <strong class="text-danger">Add to Favourites</strong>
              </button>
            <!-- <button class="btn btn-danger btn-sm rps-remove-favorite"><i class="fa fa-heart"></i> <strong>Remove from Favourites</strong></button>   -->
      <!-- Add Favorite Output -->
      <div class="rps-add-favorite-output" style="display:none;">
        <p class="text-danger" style="margin-bottom:-4px;">
          <i class="fa fa-heart text-danger"></i>
           <strong class="rps-add-favorite-output-text"></strong>
        </p>
        <small>
        <a href="https://princecowdry.com/property-favourites/" class="text-muted"><strong>view favourites</strong></a></small>
      </div>
    </div><!-- /.rps-single-listing-favorites-wrap -->

    <!-- Listing Social -->
    
<div class="rps-single-listing-social rps-text-center-sm">
	<div class="btn-group" role="group" style="background-color: lightgray;">
		<!-- Facebook -->
					<a href="http://www.facebook.com/sharer.php?u=https://princecowdry.com/listing/4-lisa-rd-toronto-ontario-m1g-2h9-21799295/&amp;t=4+LISA+RD%2C+toronto%2C+Ontario+%40+%24649%2C000" class="btn btn-sm btn-lightgrey">
					<span class="fa fa-facebook text-info"></span>
					</a>
		<!-- Twitter -->
					<a href="https://twitter.com/intent/tweet?text=What a House! 4+LISA+RD%2C+toronto%2C+Ontario+%40+%24649%2C000 https://princecowdry.com/listing/4-lisa-rd-toronto-ontario-m1g-2h9-21799295/" target="_blank" class="btn btn-sm btn-lightgrey">
					<span class="fa fa-twitter text-info"></span>
					</a>
		<!-- Google Plus -->	
					<a href="http://plusone.google.com/_/+1/confirm?hl=en&amp;url=https://princecowdry.com/listing/4-lisa-rd-toronto-ontario-m1g-2h9-21799295/" target="_blank" class="btn btn-sm btn-lightgrey">
					<span class="fa fa-google-plus text-warning"></span>
					</a>
		<!-- Pinterest -->
					<a href="http://pinterest.com/pin/create/button/?url=https://princecowdry.com/listing/4-lisa-rd-toronto-ontario-m1g-2h9-21799295/&amp;media=https://princecowdry.com/wp-includes/images/media/default.png&amp;description=4+LISA+RD%2C+toronto%2C+Ontario+%40+%24649%2C000" target="_blank" class="btn btn-sm btn-lightgrey">
					<span class="fa fa-pinterest text-danger"></span>
					</a>
		<!-- LinkedIn -->	
					<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=https://princecowdry.com/listing/4-lisa-rd-toronto-ontario-m1g-2h9-21799295/&amp;title=4+LISA+RD%2C+toronto%2C+Ontario+%40+%24649%2C000" target="_blank" class="btn btn-sm btn-lightgrey">
					<span class="fa fa-linkedin text-info"></span>
					</a>
	</div>
	    <button class="btn btn-sm btn-lightgrey btn-print" style="background-color: lightgray;">
	    <span class="fa fa-print"></span> 
	    <strong>Print!</strong>
	    </button>
    </div>
      </div><!-- /.col-md-3 -->
    </div>
	</div>	    	
<div class="row rps-property-photo-row">
   <div class="col-md-9 col-xs-12">
      
                   <ul class="slides new_slide" style="width: 100%; overflow: hidden; position: relative; height: 650px;">
                       <input type="radio" name="radio-btn" id="img-1" checked />
                       <li class="slide-container my_slide_container">
                           <div class="slide my_slide">
                               <img src="http://farm9.staticflickr.com/8072/8346734966_f9cd7d0941_z.jpg" />
                           </div>
                           <div class="nav">
                               <label for="img-6" class="prev">&#x2039;</label>
                               <label for="img-2" class="next">&#x203a;</label>
                           </div>
                       </li>
                   </ul>
              
       </div>
    <div class="col-md-3 col-xs-12">
        <div class="bx-pager-wrap">
           <ul class="bx-pager" >
                  <li class="slide">
                  <a data-slide-index="0" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-1.jpg) no-repeat center;background-size:contain;" class="active">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="1" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-2.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="2" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-3.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="3" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-4.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="4" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-5.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="5" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-6.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="6" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-7.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="7" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-8.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="8" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-9.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="9" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-10.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="10" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-11.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="11" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-12.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="12" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-13.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="13" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-14.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="14" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-15.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="15" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-16.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="16" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-17.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
                  <li class="slide">
                  <a data-slide-index="17" href="" rel="nofollow" style="display:block;width:100%;background:url(https://princecowdry.com/wp-content/uploads/realtypress/images/listing/21799295/Property-21799295-LargePhoto-18.jpg) no-repeat center;background-size:contain;">
                  <img src="https://princecowdry.com/wp-content/plugins/realtypress-premium/public/img/trans-256x200.png"></a>
                  </li>
           </ul>
            
        </div>
    </div>
</div> 
   <div class="row">
       <div class="col-md-9 col-sm-8 col-xs-12">
  <!-- Intro Specs -->
  <div class="rps-single-features rps-text-center-sm clearfix">
          <?php 
            foreach($json['Building'] as $key => $item){
              //print_r('Key:'.$key.'Value:'.$item);
                  switch($key){
                   case 'BedroomsTotal':
                       echo '<span class="rps-single-feature-label" >'.$item.'Bedroom</span>';
               break;
                   case 'BathroomTotal':
                       echo '<span class="rps-single-feature-label" >'.$item.'Bathroom</span>';
               break;
                   case 'SizeInterior':
                       echo '<span class="rps-single-feature-label" >'.$item.'</span>';
               break;
                   default:
               }//switch ends
           
           }//for each ends
           
          ?>
      </div>
  <div class="rps-single-features rps-text-center-sm clearfix">
          <span class="rps-single-feature-label-sm">Bungalow</span>
          <span class="rps-single-feature-label-sm">Central Air Conditioning</span>
          <span class="rps-single-feature-label-sm">Forced Air</span>
          </div>
    <!-- Meta -->  
    <meta content="CAD">
    <meta content="649000.00">
    <!-- Price -->
    <h2 class="rps-pricing rps-text-center-sm">$649,000</h2>  
  <!-- Description -->
  <p class="rps-text-center-sm">Attention Home Buyers! Do Not Miss Out On This Rare Opportunity To Own A Premium Size Lot In The Heart Of Woburn With  Huge Backyard, Beautiful 4 Bedroom Detached Bungalow With Large Lot Perfect For Starters, Down Sizing Or Investor In A Quiet Residential Area. Close To All Amenities, Like Library, Parks, Schools, Shopping, Transit And Much More! Large Eat-In Kitchen With Huge Pantry. Roof Done In 2018**** EXTRAS **** All Appliance (Gas Stove, Fridge,Freezer Washer, Dryer, All Electrical Fixtures ) (id:35982)
  </p>
<div class="row alternate-urls">
      <div class="col-md-4 col-sm-6 col-xs-12">
        <a href="https://www.dropbox.com/s/pb68xfputyf8ced/4%20Lisa%20Road%20-%20MLS.mp4?dl=0" target="_blank" class="rps-altenate-url">
          <i class="fa fa-video-camera"></i> 
          <strong>Virtual Tour</strong>
        </a>
      </div><!-- /.col-sm-4 --> 
</div><!-- /.row -->

<!-- Business -->
<!-- Property Details -->
<h3>Property Details</h3>
<table class="table table-hover table-bordered">
	<tbody>
	    <tr>
	        <td>
	            <strong>MLS® Number</strong>
	        </td>
	        <td class="text-right">
	            E4748229
	        </td>
	    </tr>
	    <tr>
	        <td>
	            <strong>Property Type</strong>
	        </td>
	        <td class="text-right">
	            Single Family </td>
	    </tr>
	    <tr>
	        <td>
	            <strong>Community Name</strong>
	        </td>
	        <td class="text-right">
	            Woburn </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Amenities Near By</strong>
	        </td>
	        <td class="text-right">
	            Hospital, Park, Public Transit, Schools </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Parking Space Total</strong>
	        </td>
	        <td class="text-right">
	            4 </td>
	    </tr>
	</tbody>
	</table>

<!-- Building -->
<h3>Building</h3>
<table class="table table-hover table-bordered">
	<tbody>
	    <tr>
	        <td>
	            <strong> Bathroom Total</strong>
	        </td>
	        <td class="text-right">
	            2 </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Bedrooms Above Ground</strong>
	        </td>
	        <td class="text-right">
	            4 </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Bedrooms Total</strong>
	        </td>
	        <td class="text-right">
	            4 </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Architectural Style</strong>
	        </td>
	        <td class="text-right">
	            Bungalow </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Construction Style Attachment</strong>
	        </td>
	        <td class="text-right">
	            Detached </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Cooling Type</strong>
	        </td>
	        <td class="text-right">
	            Central Air Conditioning </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Exterior Finish</strong>
	        </td>
	        <td class="text-right">
	            Brick, Wood </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Fireplace Present</strong>
	        </td>
	        <td class="text-right">
	            No </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Heating Fuel</strong>
	        </td>
	        <td class="text-right">
	            Natural Gas </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Heating Type</strong>
	        </td>
	        <td class="text-right">
	            Forced Air </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Stories Total</strong>
	        </td>
	        <td class="text-right">
	            1 </td>
	    </tr>
	    <tr>
	        <td>
	            <strong> Type</strong>
	        </td>
	        <td class="text-right">
	            House </td>
	    </tr>
	</tbody>
</table>
<!-- Parking -->

<!-- Land -->
	<h3>Land</h3>
	<table class="table table-hover table-bordered">
		<tbody>
		    <tr>
		        <td>
		            <strong> Acreage</strong>
		        </td>
		        <td class="text-right">
		            No </td>
		    </tr>
		    <tr>
		        <td>
		            <strong> Land Amenities</strong>
		        </td>
		        <td class="text-right">
		            Hospital, Park, Public Transit, Schools </td>
		    </tr>
		    <tr>
		        <td>
		            <strong> Size Irregular</strong>
		        </td>
		        <td class="text-right">
		            42 X 136 Ft </td>
		    </tr>
		    <tr>
		        <td>
		            <strong> Size Total Text</strong>
		        </td>
		        <td class="text-right">
		            42 X 136 Ft </td>
		    </tr>
		</tbody>
	</table>

<!-- Rooms -->

	<h3>Rooms</h3>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Level</th>
				<th>Type</th>
				<th class="hidden-xs">Length</th>
				<th class="hidden-xs">Width</th>
				<th>Dimensions</th>
			</tr>
		</thead>
		<tbody>

		    <tr>
		        <td>
		            Ground Level </td>
		        <td>
		            Living Room </td>
		        <td class="hidden-xs">
		            5.45 m </td>
		        <td class="hidden-xs">
		            6.1 m </td>
		        <td>
		            5.45 m x 6.1 m </td>
		    </tr>
		    <tr>
		        <td>
		            Ground Level </td>
		        <td>
		            Dining Room </td>
		        <td class="hidden-xs">
		            5.45 m </td>
		        <td class="hidden-xs">
		            6.1 m </td>
		        <td>
		            5.45 m x 6.1 m </td>
		    </tr>
		    <tr>
		        <td>
		            Ground Level </td>
		        <td>
		            Kitchen </td>
		        <td class="hidden-xs">
		            4.42 m </td>
		        <td class="hidden-xs">
		            5.18 m </td>
		        <td>
		            4.42 m x 5.18 m </td>
		    </tr>
		    <tr>
		        <td>
		            Ground Level </td>
		        <td>
		            Master Bedroom </td>
		        <td class="hidden-xs">
		            3.04 m </td>
		        <td class="hidden-xs">
		            3.35 m </td>
		        <td>
		            3.04 m x 3.35 m </td>
		    </tr>
		    <tr>
		        <td>
		            Ground Level </td>
		        <td>
		            Bedroom 2 </td>
		        <td class="hidden-xs">
		            3.9 m </td>
		        <td class="hidden-xs">
		            3.35 m </td>
		        <td>
		            3.9 m x 3.35 m </td>
		    </tr>
		    <tr>
		        <td>
		            Ground Level </td>
		        <td>
		            Bedroom 3 </td>
		        <td class="hidden-xs">
		            3.35 m </td>
		        <td class="hidden-xs">
		            3.35 m </td>
		        <td>
		            3.35 m x 3.35 m </td>
		    </tr>
		    <tr>
		        <td>
		            Ground Level </td>
		        <td>
		            Bedroom 4 </td>
		        <td class="hidden-xs">
		            3.04 m </td>
		        <td class="hidden-xs">
		            3.04 m </td>
		        <td>
		            3.04 m x 3.04 m </td>
		    </tr>
		</tbody>
	</table>
   </div>
   <div class="col-md-3 col-sm-4 col-xs-12">
  <div class="rps-contact-form-wrap-v">

  <h2>Interested?</h2>
  <p class="text-muted">Contact us for more information</p>

  <hr>

  <form action="" method="post" class="listing-contact-form">

    <div class="form-group">
      <!-- <label for="cf-name">Name <small class="text-danger">(required)</small></label> -->
      <input type="text" name="cf-name" value="" size="40" class="form-control" placeholder=" Name">
    </div>

    <div class="form-group">
      <!-- <label for="cf-name">Email <small class="text-danger">(required)</small></label> -->
      <input type="email" name="cf-email" value="" size="40" class="form-control" placeholder=" Email">
    </div>
    <div class="form-group">
      <!-- <label for="cf-name">Message <small class="text-danger">(required)</small></label> -->
      <textarea rows="10" cols="35" name="cf-message" class="form-control" placeholder=" Message"></textarea>
    </div>
    <input type="hidden" name="cf-subject" value="[Listing Inquiry] 4 Lisa Rd, Toronto, Ontario M1G 2H9">
    <input type="hidden" name="cf-permalink" value="https://princecowdry.com/listing/4-lisa-rd-toronto-ontario-m1g-2h9-21799295/">
    <div class="progress" style="display:none;">
      <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0">
        <span class="text-center rps-text-white"><strong>Sending</strong>
        </span>
      </div>
    </div>
    <div class="form-group">
              <div class="rps-contact-captcha-output" style="display: block;">
              <div id="math-quiz">
              <label>What is 25 + 7 ?</label>
              <input type="text" name="math-quiz" class="form-control" placeholder="Answer">
              <input type="hidden" name="unique_id" value="eikqsurchzq0xylo7nh5qzj7c9c7y8bi">
              <input type="hidden" name="session_id" value="eu1sf7e8m1f7ongdhkghs807u5"> 
              <small>
              <a href="#" class="refresh-math-captcha">Change Question <i class="fa fa-refresh"></i></a>
              </small>
              </div>
              </div>  
            <div class="rps-contact-alerts"></div>
    </div>  
    <p>
    <button type="submit" name="cf-submitted" value="Send" class="btn btn-primary btn-block">Send <i class="fa fa-paper-plane-o"></i></button>
    </p>
  </form>
    </div>
     <div class="rps-sidebar-favorites">
      <div class="panel panel-default">
        <div class="panel-heading">
      <strong>Your Favourites</strong>
    </div>
    <div class="panel-body">
        <p>&nbsp;</p>
        <p class="text-center" style="font-size:32px;">
        <i class="fa fa-heart text-danger"></i>
        </p>
        <p class="text-muted text-center">No Favourites Found</p>
        <p>&nbsp;</p>   
</div><!-- /.panel-body -->
</div><!-- /.panel .panel-default -->
</div>
<div class="rps-agent-details" style="text-align: center !important;"> 
<img style=" width: 100%;" src="https://princecowdry.com/wp-content/uploads/2019/11/prince.png"><br>
<p><span itemprop="name legalName"><strong>Contact me regarding this property</strong></span><br><br> <span itemprop="name legalName"><strong>Prince Cowdry</strong></span><br> <em>Real Estate Agent</em></p>
<div style="clear:both"></div> 
<span itemprop="telephone"> 416 858 4888</span><br>
<span itemprop="telephone">princecowdry@hotmail.com</span><hr> 
<div itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
<span><strong>Location</strong></span> <br> 
<span itemprop="streetAddress">7 Eastvale Dr, </span><br> 
<span itemprop="addressLocality"> unit 205,</span> 
<span itemprop="addressRegion"> Markham,</span> 
<span itemprop="postalCode">ON L3S 4N8</span> <br>Canada</div><br>
</div><!-- /.rps-favorites -->
</div>
</div>
</div>
</div>









    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
