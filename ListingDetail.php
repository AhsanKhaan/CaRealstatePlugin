 
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
        <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
    width: 70%;
    margin: auto;
  }
  </style>
</head>
<body>
<?php 
$SiteDir="/wordpress";
require_once($_SERVER['DOCUMENT_ROOT'].$SiteDir.'/wp-load.php');
//exit();
get_header();
?>
<div id="primary" class="content-area">
  <div id="content" class="site-content">
    
    <?php
if (isset($_GET['ID'])&& $_GET['ID']!="" ) {
   // echo "<mark>ID=".$_GET['ID']."</mark><br/>";

$baseURL="https://crea.bmsastech.com/";
    $url = $baseURL."listing.php?id=".$_GET['ID'];
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
//exit();
    //json_decode($json);
    
    // echo '<pre>';
    // print_r($json['Photo']);
    // echo '</pre>';

//    exit();
    
}//$_GET[] loop

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
  <div class="container-fluid">	    	
<div class="row rps-property-photo-row">
   <div class="col-md-9 col-xs-12">
   <div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
  <?php
  foreach($json['Photo']['PropertyPhoto'] as $key=>$value){
      if($key==0){
       echo '<li data-target="#demo" data-slide-to="'.$key.'" class="active"></li>';
      }else{
       echo '<li data-target="#demo" data-slide-to="'.$key.'"></li>';
      }
    }
  ?>
    <!-- <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li> -->
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
  <?php
    $check_if_array=is_array($json['Photo']['PropertyPhoto'][0])? true: false; 
    if($check_if_array==true){
      foreach($json['Photo']['PropertyPhoto'] as $key=>$value){
        // echo "<pre>";
        
        // var_dump($val);
        // print_r($json['Photo']['PropertyPhoto']);
        // echo "</pre>";
        // exit();
        if($key==0){
         echo '<div class="carousel-item active">
         <img class="img-responsive" src="'.$value['LargePhotoURL'].'" >
       </div>';
        }else{
         echo '<div class="carousel-item">
         <img class="img-responsive" src="'.$value['LargePhotoURL'].'">
       </div>';
        }
      }
    }else if($check_if_array==false){
      if($key==0){
        echo '<div class="carousel-item active">
        <img class="img-responsive" src="'.$json['Photo']['PropertyPhoto']['LargePhotoURL'].'" >
      </div>';
       }else{
        echo '<div class="carousel-item">
        <img class="img-responsive" src="'.$json['Photo']['PropertyPhoto']['LargePhotoURL'].'">
      </div>';
       }
    }
  
    
    ?>
    <!-- <div class="carousel-item active">
      <img class="img-responsive" src="https://i.ytimg.com/vi/7WCbIjqjHM4/maxresdefault.jpg" alt="Los Angeles">
    </div>
    <div class="carousel-item">
      <img class="img-responsive" src="https://ddfcdn.realtor.ca/listings/TS637228551264930000/reb82/medres/0/c4741370_1.jpg" alt="Chicago" width="1100" height="500">
    </div>
    <div class="carousel-item">
      <img class="img-responsive" src="https://ddfcdn.realtor.ca/listings/TS637228551264930000/reb82/medres/0/c4741370_1.jpg" alt="New York" width="1100" height="500">
    </div> -->
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
     </div>
    <div class="col-md-3 col-xs-12">
        <div class="bx-pager-wrap">
           <ul class="bx-pager" >
            <?php

              if(empty($json['Photo'])){
                echo '<h2>Images unavailable</h2>';
              }else{
                // echo "<pre>";
                // var_dump($val);
                // print_r($json['Photo']['PropertyPhoto']);
                // echo "</pre>";
                // exit();
                $check_if_array=is_array($json['Photo']['PropertyPhoto'][0])? true: false;
                if($check_if_array==true){
                  foreach($json['Photo']['PropertyPhoto'] as $key=>$photo){
                    echo '<li class="slide">
                    <a data-slide-index="'.$key.'" href="" rel="nofollow" style="display:block;width:100%;background:url('.$photo['PhotoURL'].') no-repeat center;background-size:contain;" class="active">
                    <img src="'.$photo['PhotoURL'].'"/></a>
                    </li>';
                    }
                }else if($check_if_array==false){
                  echo '<li class="slide">
                  <a data-slide-index="0" href="" rel="nofollow" style="display:block;width:100%;background:url('.$photo['PhotoURL'].') no-repeat center;background-size:contain;" class="active">
                  <img src="'.$json['Photo']['PropertyPhoto']['PhotoURL'].'"/></a>
                  </li>';
                }

              }
              ?>                
           </ul>
            
         </div>
     </div><!--col-md-3-ends-->
    </div><!--row ends-->
</div> <!--container -ends-->
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
  <?php 
   foreach($json['Building'] as $key => $item){
    //print_r('Key:'.$key.'Value:'.$item);
        switch($key){
         case 'ArchitecturalStyle':
             echo '<span class="rps-single-feature-label-sm">'.$item.'</span>';
     break;
         case 'FireplacePresent':
             if ($item=='True'){
                 echo '<span class="rps-single-feature-label-sm">Fire Place</span>';
             }else{
 
             }
             
     break;
         case 'HeatingType':
             echo '<span class="rps-single-feature-label-sm">'.$item.'</span>';
     break;
         case 'CoolingType':
             if(strpos($item, ",") !== false){
                 $temp=explode(",",$item);
                 //print_r($temp);
                 echo '<span class="rps-single-feature-label-sm">'.$temp[1].'</span>';
             } else{
                 echo '<span class="rps-single-feature-label-sm">'.$item.'</span>';
             }
             
     break;
     
         default:
     }//switch ends
 
 }//for each ends
  ?>

          </div>
    <!-- Meta -->  
    <meta content="CAD">
    <meta content="649000.00">
    <!-- Price -->
    <h2 class="rps-pricing rps-text-center-sm">$<?php echo $json['Price'];?></h2>  
  <!-- Description -->
  <p class="rps-text-center-sm">
  <?php echo $json['PublicRemarks'];?>
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
  <?php 
  if(array_key_exists('ListingID',$json)){
    echo '<tr>
            <td>
              <strong>MLS® Number
              </strong>
            </td>
            <td class="text-right">'.$json['ListingID'].'</td>
          </tr>';
  }

  ?>
    <?php 
    if(array_key_exists('PropertyType',$json)){
      echo '
      <tr>
        <td>
          <strong>Property Type</strong>
        </td>
        <td class="text-right">
        '.$json['PropertyType'].'
        </td>
      </tr>';
    }
  ?>
	    <tr>
	        <td>
	            <strong>Community Name</strong>
	        </td>
	        <td class="text-right">
	            Woburn </td>
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
   
   if($json['EquipmentType']=="{}"){
 
   }else{
     if($json['EquipmentType']==NULL){

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
   }
     
   ?>
    <?php 

if(((is_string($json['Features']))&&($json['Features']==NULL))||((is_array($json['Features']))&&(count($json['Features'])==0))){

}else{
  if(is_array($json['Features'])){
    echo '<tr>
    <td>
    <strong>Features</strong>
    </td>
    <td class="text-right">
    '.implode(" ",$json['Features']).'
    </td>
         </tr>';
   }else{
    echo '<tr>
    <td>
     <strong>Features</strong>
    </td>
    <td class="text-right">
    '.$json['Features'].'
    </td>
    </tr>';
   }
}
  

  ?>
	</tbody>
	</table>

<!-- Building -->
<h3>Building</h3>
<table class="table table-hover table-bordered">
	<tbody>
  <?php 
  if(array_key_exists('BathroomTotal',$json['Building'])){
    if($json['Building']['BathroomTotal']!='None'){
      echo '<tr>
      <td>
      <strong>Bathroom Total</strong>
      </td>
      <td class="text-right">
      '.$json['Building']['BathroomTotal'].'
      </td>
      </tr>';
    }

  }

  ?>
    <?php 
  if(array_key_exists('BedroomsAboveGround',$json['Building'])){
    if($json['Building']['BedroomsAboveGround']!='None'){
      echo '<tr>
      <td>
      <strong>Bedroom Above Ground</strong>
      </td>
      <td class="text-right">
      '.$json['Building']['BedroomsAboveGround'].'
      </td>
      </tr>';
    }

  }

  ?>
	  <?php 
  if(array_key_exists('BedroomsTotal',$json['Building'])){
    if($json['Building']['BedroomsTotal']!='None'){
      echo '<tr>
      <td>
      <strong>Bedrooms Total</strong>
      </td>
      <td class="text-right">
      '.$json['Building']['BedroomsTotal'].'
      </td>
      </tr>';
    }

  }
   ?>

    <?php 
  if(array_key_exists('Age',$json['Building'])){
    echo '<tr>
    <td>
      <strong>Age</strong>
    </td>
    <td class="text-right">
      '.$json['Building']['Age'].'
      </td>
      </tr>';
  }
  ?>
    <?php 
  if(array_key_exists('Appliances',$json['Building'])){
    echo '<tr>
    <td>
    <strong>Appliances</strong>
    </td><td class="text-right">
      '.$json['Building']['Appliances'].'
    </td>
      </tr>';
  }
  ?>
    <?php 
  if(array_key_exists('ArchitecturalStyle',$json['Building'])){
    echo '<tr>
    <td>
    <strong>ArchitecturalStyle</strong>
    </td>
    <td class="text-right">
      '.$json['Building']['ArchitecturalStyle'].'
      </td>
      </tr>';
  }
  ?>

    <?php 
  if(array_key_exists('ConstructedDate',$json['Building'])){
    echo '<tr>
    <td>
    <strong>Constructed Date</strong>
    </td>
    <td class="text-right">
      '.$json['Building']['ConstructedDate'].'
      </td>
      </tr>';
  }
  ?>
  <?php 
  if(array_key_exists('ConstructionStyleAttachment',$json['Building'])){
    echo ' <tr>
    <td>
    <strong>Construction Style Attachment</strong>
    </td>
    <td class="text-right">
      '.$json['Building']['ConstructionStyleAttachment'].'
      </td>
      </tr>';
  }
  ?>
    


  <?php 
  if(array_key_exists('StoriesTotal',$json['Building'])){
    if($json['Building']['StoriesTotal']!='None'){
      echo '<tr>
      <td>
      <strong>Stories Total</strong>
      </td>
      <td class="text-right">
      '.$json['Building']['StoriesTotal'].'
      </td>
      </tr>';
    }

  }

  ?>
    


  <?php 
  if(array_key_exists('BasementType',$json['Building'])){
    if($json['Building']['BasementType']!='None'){
      echo '<tr>
      <td>
      <strong>Basement Type</strong>
      </td>
      <td class="text-right">
      '.$json['Building']['BasementType'].'
      </td>
      </tr>';
    }

  }

  ?>
    


  <?php 
  if(array_key_exists('CoolingType',$json['Building'])){
    if($json['Building']['CoolingType']!='None'){
      echo '<tr>
      <td>
      <strong>Cooling Type</strong>
      </td>
      <td class="text-right">
      '.$json['Building']['CoolingType'].'
      </td>
      </tr>';
    }

  }

  ?>
    


  <?php 
  if(array_key_exists('ExteriorFinish',$json['Building'])){
    echo '<tr>
    <td>
    <strong>Exterior Finish</strong>
    </td>
    <td class="text-right">
      '.$json['Building']['ExteriorFinish'].'
      </td>
      </tr>';
  }
  ?>
    


  <?php 
  if(array_key_exists('FireplacePresent',$json['Building'])){
    if($json['Building']['FireplacePresent']=='True'){
      echo '<tr>
      <td>
      <strong>FirePlace Present</strong>
      </td>
      <td class="text-right">
      Yes
      </td>';
    }else{
      echo '<tr>
      <td>
      <strong>FirePlace Present</strong>
      </td>
      <td class="text-right">
      No
      </td>
      </tr>';
    }
  }
  ?>
    

  <?php 
    echo '<tr>
    <td>
    <strong>Equipment Type</strong>
    </td>
    <td class="text-right">
    '.$json['EquipmentType'].'
    </td>
    </tr>';
  ?>
    


  <?php 
    echo '<tr>
    <td>
    <strong>Features</strong>
    </td>
    <td class="text-right">
    '.'
    </td>
    </tr>';
  ?>
    


  <?php 
    echo '<tr>
    <td>
    <strong>Parking Spaces Total</strong>
    </td>
    <td class="text-right">
    '.$json['ParkingSpaceTotal'].'
    </td>
    </tr>';
  ?>
    


  <?php 
  if(array_key_exists('HeatingType',$json['Building'])){
    echo '<tr>
    <td>
    <strong>Heating Type</strong>
    </td>
    <td class="text-right">
      '.$json['Building']['HeatingType'].'
      </td>
      </tr>';
  }
  ?>
    


  <?php 
  if(array_key_exists('HeatingFuel',$json['Building'])){
    echo '<tr>
    <td>
    <strong>Heating Fuel</strong>
    </td>
    <td class="text-right">
      '.$json['Building']['HeatingFuel'].'
      </td>
      </tr>';
  }
  ?>
    


  <?php 
    echo '<tr>
    <td>
    <strong>Rental Equipment Type</strong>
    </td
    <td class="text-right">
    '.$json['RentalEquipmentType'].'
    </td>
    </tr>';
  ?>
    


  <?php 
  if(array_key_exists('SizeInterior',$json['Building'])){
      if(is_array($json['Building']['SizeInterior'])){
        echo '<tr>
        <td>
        <strong>Size Interior</strong>
        </td>
        <td class="text-right">
        '.implode(" ",$json['Building']['SizeInterior']).'
        </td>
        </tr>';
      }else{
        echo '<tr>
        <td>
        <strong>Size Interior</strong>
        </td>
        <td class="text-right">
        '.$json['Building']['SizeInterior'].'
        </td>
        </tr>';
        
      }

  }
  ?>
    


  <?php 
  if(array_key_exists('UtilityWater',$json['Building'])){
    echo '<tr>
    <td>
    <strong>Utility Water</strong>
    </td>
    <td class="text-right">
      '.$json['Building']['UtilityWater'].'
      </td>
      </tr>';
  }
  ?>
    


  <?php 
  if(array_key_exists('Type',$json['Building'])){
    echo '<tr>
    <td>
    <strong>Type</strong>
    </td>
    <td class="text-right">
      '.$json['Building']['Type'].'
      </td>
      </tr>';
  }
  ?>
    

	</tbody>
</table>
<!-- Parking -->

<!-- Land -->
<?php 
    if(array_key_exists('Land',$json)){
        
        if(count($json['Land'])>0){
          echo '<h3>Land</h3>';
          echo '<table class="table table-hover table-bordered" >';
          
          if(array_key_exists('Acreage',$json['Land'])){
            if($json['Land']['Acreage']==true){
              echo '<tr>';
              echo '<td><strong>Acreage</strong></td><td class="text-right">Yes</td>';
              echo '</tr>';
            }else{
              echo '<tr>';
              echo '<td><strong>Acreage</strong></td><td class="text-right">No</td>';
              echo '</tr>';
            }
          }

          foreach($json['Land'] as $key=>$value){
            echo '<tr>';
            if($key=='Acreage'){
              continue;
              
            }else{
              $label = preg_replace('/(?<!\ )[A-Z]/', ' $0', $key);
              echo '<td><strong>'.$label.'</strong></td>';
              if(is_array($value)){
                if(empty($value)){
                  echo '<td class="text-right">Unknown</td>';
                }else{
                  echo '<td class="text-right">'.implode(" ",$value).'</td>';
                }//check for empty ends
                
              }else{
                echo '<td class="text-right">'.$value.'</td>';
              }
              
            }
            echo '</tr>';
          }//for each end
          echo '</table>';
        }//array length check end
    }//check for existance of array ennds
    ?>
     <!-- For Rooms PHP coding -->
     <?php 
    if(array_key_exists('Rooms',$json['Building'])){
       echo '<h3>Rooms</h3>
       <table class="table table-bordered" border=1>
         <thead>
           <tr>
             <th>Level</th>
             <th>Type</th>
             <th class="hidden-xs">Length</th>
             <th class="hidden-xs">Width</th>
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
          echo '<td class="hidden-xs" colspan=1>'.implode(" ",$item['Length']).'</td>';
        }else{
          echo '<td class="hidden-xs" colspan=1>'.$item['Length'].'</td>';
        }
        
        //for width
        if(is_array($item['Width'])){
          echo '<td class="hidden-xs" colspan=1>'.implode(" ",$item['Width']).'</td>';
        }else{
          echo '<td class="hidden-xs" colspan=1>'.$item['Width'].'</td>';
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

  </div>
</div>

<?php 
//get_sidebar();
get_footer();

?>








    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
$(document).ready(function(){
  // Activate Carousel
  $("#myCarousel").carousel();
    
  // Enable Carousel Indicators
  $(".item1").click(function(){
    $("#myCarousel").carousel(0);
  });
  $(".item2").click(function(){
    $("#myCarousel").carousel(1);
  });
  $(".item3").click(function(){
    $("#myCarousel").carousel(2);
  });
  $(".item4").click(function(){
    $("#myCarousel").carousel(3);
  });
    
  // Enable Carousel Controls
  $(".left").click(function(){
    $("#myCarousel").carousel("prev");
  });
  $(".right").click(function(){
    $("#myCarousel").carousel("next");
  });
});
</script>

</body>
</html>