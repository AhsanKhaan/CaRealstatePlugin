<?php
include 'db_connection.php';
//use Datetime;



$get_updated_time="SELECT * FROM wp_LastUpdated";
$result=mysqli_query($conn,$get_updated_time);
if (!$result) {
    echo "Could not successfully run query ($get_updated_time) from DB: " . mysql_error();
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo "No rows found, nothing to print so am exiting";
    exit;
}
$row=mysqli_fetch_assoc($result);


// $date_now=new DateTime();
// $date_now->setTimezone(new DateTimeZone('Asia/Karachi'));
// $date_now->format('Y-m-d H:i:s');
//echo $row['start'];
//echo "<br/>";
//echo $row['end'];
//var_dump(date('Y-m-d H:i:s'));


$prevTime=strtotime($row['start']);
$currentTime=strtotime(date('Y-m-d H:i:s'));
// echo "prev:".$prevTime;
// echo "current:".$currentTime;


// Formulate the Difference between two dates 
$hours = abs($currentTime - $prevTime)/3600;  
  







// do something every hour
/* Script Variables */
// Lots of output, saves requests to a local file.
$debugMode = false; 

$TimeBackPull="-".ceil($hours)." hours";
// echo "<h1>";
// print_r($TimeBackPull);
// echo "</h1>";
// $TimeBackPull="-51 hours";
$conn->close();
/* RETS Variables */
require("PHRets_CREA.php");
$RETS = new PHRets();
$RETSURL = "http://data.crea.ca/Login.svc/Login";
$RETSUsername = "sWMgPvGoz4Aj7EZhxEmgLrZx";
$RETSPassword = "4bOHdDpL0pdo2xCTuoD72amD";
$RETS->Connect($RETSURL, $RETSUsername, $RETSPassword);
$RETS->AddHeader("RETS-Version", "RETS/1.7.2");
$RETS->AddHeader('Accept', '/');
$RETS->SetParam('compression_enabled', true);
$RETS_PhotoSize = "LargePhoto";
$RETS_LimitPerQuery = 100;//100
if($debugMode /* DEBUG OUTPUT */)
{
	//$RETS->SetParam("catch_last_response", true);
	$RETS->SetParam("debug_file", "/var/web/CREA_Anthony.txt");
	$RETS->SetParam("debug_mode", true);
}


/* NOTES
 * With CREA, You have to ask the RETS server for a list of IDs.
 * Once you have these IDs, you can query for 100 listings at a time
 * Example Procedure:
 * 1. Get IDs (500 Returned)
 * 2. Get Listing Data (1-100)
 * 3. Get Listing Data (101-200)
 * 4. (etc)
 * 5. (etc)
 * 6. Get Listing Data (401-500)
 *
 * Each time you get Listing Data, you want to save this data and then download it's images...
 */
 
error_log("-----GETTING ALL ID's-----");
$DBML = "(LastUpdated=" . date('Y-m-d', strtotime($TimeBackPull)) . ")";
$params = array("Limit" => 1, "Format" => "STANDARD-XML", "Count" => 1);
$results = $RETS->SearchQuery("Property", "Property", $DBML, $params);
$totalAvailable = $results["Count"];
print_r("-----".$totalAvailable." Found-----");

//$totalAvailable=300;
if(empty($totalAvailable) || $totalAvailable == 0)
{
      error_log(print_r($RETS->GetLastServerResponse(), true));	
 }
 //$TimeBackPull="-48 hours";
 //print_r("Time:".$TimeBackPull);
 
 
      $index=0;
     
      $insert_lastupdated_start_column="UPDATE wp_LastUpdated SET start='".date('Y-m-d H:i:s')."' WHERE ID=1;";
      dbDelta($insert_lastupdated_start_column);
      
      for($i = 0; $i < ceil($totalAvailable/$RETS_LimitPerQuery); $i++)
      {	
         //mysqli_listing id
         
         
          ceil($totalAvailable/$RETS_LimitPerQuery);
          $startOffset = $i*$RETS_LimitPerQuery;
          print_r($i." off".$startOffset);
         //$startOffset=9900;
         //print_r("startoffset".$startOffset);
         //print_r("-----Get IDs For ".$startOffset." to ".($startOffset + $RETS_LimitPerQuery).". Mem: ".round(memory_get_usage()/(1024*1024), 1)."MB-----");
         $params = array("Limit" => $RETS_LimitPerQuery, "Format" => "STANDARD-XML", "Count" => 1, "Offset" => $startOffset);
         $results = $RETS->SearchQuery("Property", "Property", $DBML, $params);			

         if(is_array($results["Properties"])){
            foreach($results["Properties"] as $listing)
            {	

               include('db_connection.php');
               //echo "<h1>".$listing['ListingID']."</h1>";
               $sql="SELECT COUNT(*) AS count FROM wp_properties_2 WHERE ListingID='".$listing['ListingID']."'";
               //print_r($sql);
               $results= mysqli_fetch_assoc(mysqli_query($conn,$sql));
               $count=$results['count'];
               if($count==0){
                 Insert_to_database($listing);
                 
               }else if($count==1){
                  Update_to_database($listing,$listing['ListingID']);
                 
               }else{
                  echo "Duplicate data is Present";
                  exit();
               }     
               //Update_to_database($listing,30828205);
            
            }
         }else{
         
        //    var_dump($results["Properties"]);
         //   print_r("index#:".$index);
         print_r($results["Properties"]);   
         //return;
         }//if-else
         
      }//for loop ends
      $insert_lastupdated_end_column="UPDATE wp_LastUpdated SET end='".date('Y-m-d H:i:s')."' WHERE ID=1;";
      dbDelta($insert_lastupdated_end_column);

    //        if ($conn->query("INSERT INTO `wp_LastUpdated` (`End`) VALUES (now())") === TRUE) {
     //  echo "New record created successfully";
//    print_r("End Time Stamp Updated");    
 //  } else {
  //     echo "Error:Not updated Start Time Stamp "  . $conn->error;
   //}
   //$conn -> close();

      $RETS->Disconnect();

      /* This script, by default, will output something like this:

      Connecting to RETS as '[YOUR RETS USERNAME]'...
      -----GETTING ALL ID's-----
      -----81069 Found-----
      -----Get IDs For 0 to 100. Mem: 0.7MB-----
      -----Get IDs For 100 to 200. Mem: 3.7MB-----
      -----Get IDs For 200 to 300. Mem: 4.4MB-----
      -----Get IDs For 300 to 400. Mem: 4.9MB-----
      -----Get IDs For 400 to 500. Mem: 3.4MB-----
      */
      



function Update_to_database($data,$ListingID_to_update){
   

   
   

   // if(array_key_exists('ID',$data)){
   //    $ID="".$data['ID'];
      
   // }else{
   //    $ID=json_encode(json_decode("{}"));
   //   // error_log("---".$ID[0]["ID"]."----");
   // }
   // error_log("ID".$ID);
   
   if(array_key_exists('@attributes',$data)){
      if(array_key_exists('LastUpdated',$data['@attributes'])){
         $LastUpdated=$data['@attributes']['LastUpdated'];
      }else{
         $LastUpdated=json_encode(json_decode("{}"));
      }
      
   }else{
      $LastUpdated=json_encode(json_decode("{}"));
     
   }
   
    //$LASTUPDATED=$data['LastUpdated'];
    $ListingID=$data['ListingID'];

   

    $AgentDetails=str_replace("'","\'",json_encode($data['AgentDetails']));

   

    $Board=$data['Board'];

   
    
     //$wpdb = new wpdb();
   //  $var = $wpdb->_real_escape( $string );
   //@1
    //$Business=json_encode(wptexturize($data['Business']));
   //  $Business=json_encode(esc_attr($data['Business']));
   $Business=str_replace("'","\'",json_encode($data['Business']));
   //  if(preg_match('/[^0-9]*[\']/',json_encode($data['Business']))){
       //$Business=json_encode(str_replace("'","",$data['Business']));

   //  }else{
   //    $Business=json_encode($data['Business']);
      
   //  }
    
    
   

    //$Building=json_encode(json_decode("{}"));
    $Building=str_replace("'","\'",json_encode($data['Building']));

   

    //@2
   //$Land=json_encode(wptexturize($data['Land']));
   //  if(preg_match('/[\'][^\']/',json_encode($data['Land']))){
       //$Land=json_encode(str_replace("'","",$data['Land']));
      //  $Land=json_encode(esc_attr($data['Land']));
       $Land=str_replace("'","\'",json_encode($data['Land']));

   //  }else{
   //    $Land=json_encode($data['Land']);
      
   //  }
   

   if (array_key_exists('Address',$data)) {
      $Address=str_replace("'","\'",json_encode($data['Address']));
   }else{
      
      $Address=json_encode(json_decode("{}"));
   }
    

   

     if (array_key_exists('AmmenitiesNearBy',$data)) {
        $AmmenitiesNearBy=str_replace("'","\'","".$data['AmmenitiesNearBy']);
     }else{
        $AmmenitiesNearBy="";
     }

   

     if (array_key_exists('AlternateURL',$data)) {
        $AlternateURL=str_replace("'","\'",implode(" ",$data['AlternateURL']));
     }else{
        $AlternateURL=json_encode(json_decode("{}"));
     }

   

     if (array_key_exists('EquipmentType',$data)) {
        $EquipmentType=str_replace("'","\'",$data['EquipmentType']);
     }else{
        $EquipmentType="";
     }

   

     if (array_key_exists('Features',$data)) {
        $Features=str_replace("'","\'",$data['Features']);
     }else{
        $Features=json_encode(json_decode("{}"));
     }

   
     


     if (array_key_exists('ListingContractDate',$data)) {
                 
         $ListingContractDate=str_replace("'","\'",$data['ListingContractDate']);
         
         //error_log("TullaTullaTullaTullaa".var_dump($ListingContractDate));
     }else{
        $ListingContractDate="";
     }
     
   

     if (array_key_exists('LocationDescription',$data)) {
        $LocationDescription=str_replace("'","\'",$data['LocationDescription']);
     }else{
        $LocationDescription="";
     }
        if (array_key_exists('OwnershipType',$data)) {
        $OwnershipType=str_replace("'","\'",$data['OwnershipType']);
     }else{
        $OwnershipType="";
     }

   
    
     if (array_key_exists('ParkingSpaces',$data)) {
        $ParkingSpaces=str_replace("'","\'",json_encode($data['ParkingSpaces']));
     }else{
        $ParkingSpaces=json_encode(json_decode("{}"));
     }
   
     if(array_key_exists('ParkingSpaceTotal',$data)){
        $ParkingSpaceTotal=str_replace("'","\'",$data['ParkingSpaceTotal']);
     }else{
        $ParkingSpaceTotal="";
     }
   
    //photo
     if(array_key_exists('Photo',$data)){
      $Photo=str_replace("'","\'",json_encode($data['Photo']));
   }else{
      $Photo=json_encode(json_decode("{}"));
   }
   // $Photo=json_encode($data['Photo']);

   
    //$Price=$data['Price'];
    if(array_key_exists('Price',$data)){
      $Price=str_replace("'","\'",$data['Price']);
   }else{
      //$Price=0;
      $Price=0;
      
   }

   

     $PropertyType=str_replace("'","\'",json_encode($data['PropertyType']));

   

   //@3
    //$PublicRemarks=json_encode(wptexturize($data['PublicRemarks']));
     //$PublicRemarks=json_encode(str_replace("'","",$data['PublicRemarks']));
   //   $PublicRemarks=json_encode(esc_attr($data['PublicRemarks']));
   $PublicRemarks=str_replace("'","\'",$data['PublicRemarks']);
//    if(strpos($PublicRemarks,"\\'CHEERS\\'")!==false){

// $PublicRemarks=str_replace("\\'CHEERS\\'","CHEERS",$data['PublicRemarks']);
//    }
   

    if(array_key_exists('RentalEquipmentType',$data)){
        $RentalEquipmentType=str_replace("'","\'",$data['RentalEquipmentType']);
     }else{
        $RentalEquipmentType='';
     }

   

     if(array_key_exists('Structure',$data)){
        $Structure=str_replace("'","\'",$data['Structure']);
     }else{
        $Structure='';
     }
   
    
    $TransactionType=$data['TransactionType'];
    
   

    if(array_key_exists('UtilitiesAvailable',$data)){
        $UtilitiesAvailable=str_replace("'","\'",json_encode($data['UtilitiesAvailable']));
     }else{
        $UtilitiesAvailable=json_encode(json_decode("{}"));
     }

   

     if(array_key_exists('WaterFrontType',$data)){
        $WaterFrontType=str_replace("'","\'",$data['WaterFrontType']);
     }else{
        $WaterFrontType='';
     }

    
    
     if(array_key_exists('ZoningDescription',$data)){
        $ZoningDescription=str_replace("'","\'",$data['ZoningDescription']);
     }else{
        $ZoningDescription='';
     }

        
     if(array_key_exists('ViewType',$data)){
        $ViewType=$data['ViewType'];
     }else{
        $ViewType='';
     }
    
    

   // $AnalyticsClicks=$data['AnalyticsClick'];

   

    $MoreInformationLink=str_replace("'","\'",$data['MoreInformationLink']);

     /////////////////////////////////////////////////////////////////////////////
     ///////////////////Data INSERTION fOR CARD /////////////////////////////////
     ///////////////////////////////////////////////////////////////////////////
     //$ID_card;//get this at the time of card
     //Card:agent office location
     $Listing_Office_card;
     $temp=json_decode($AgentDetails,true);
           //var_dump($temp);
           if(is_array($temp)){
               if(array_key_exists(0,$temp)){
                  $Listing_Office_card=$temp[0]['Office']['Name'];
               }else{
                  $Listing_Office_card=$temp['Office']['Name'];
               }
               
           } else{
               $Listing_Office_card=$temp['Office']['Name'];
           }
      //Card:Building Size Interior     
     $Building_size_card;
     $Building_bed_card;
     $Building_bath_card;
     $temp_Building=json_decode($Building,true);
     if($temp_Building==null){
        // print_r($data['ID']);
         //print_r($Building);
         $temp_arr=explode(',"Rooms":',$Building);
         //for bedroom ,bath room ,
         $valid_json_str=$temp_arr[0]."}";
         //echo '<pre>';
         $valid_json=json_decode($valid_json_str,true);

         //echo '</pre>';
         //for bedroom and bath room 
         //1)For Bath room
         $Building_bath_card=$valid_json['BathroomTotal'];
         //2)For Bed room
         $Building_bed_card=$valid_json['BedroomsTotal'];
         $temp_size_arr=explode('"SizeInterior":',$Building);
         if(array_key_exists(1,$temp_size_arr)){
         $temp_size=explode(",",$temp_size_arr[1]);
         //3)Size Interior
         $Building_size_card=substr($temp_size[0],1,-1);
         }else{
            //3)Size Interior
            $Building_size_card="";
         }
        
         

     }else{
         if(array_key_exists('SizeInterior',$temp_Building)){
            // $Building_size=json_decode($row['Building']);
            $Building_size_card=$temp_Building['SizeInterior'];
            
         }else{
            $Building_size_card="";
         }
         //Card:Building bedrooms   
      if(array_key_exists('BedroomsTotal',$temp_Building)){
         $Building_bed_card=$temp_Building['BedroomsTotal'];
      }else{
         $Building_bed_card="";
      }
      //Card: Building bathroom 
      if(array_key_exists('BathroomTotal',$temp_Building)){
         $Building_bath_card=$temp_Building['BathroomTotal'];
      }else{
         $Building_bath_card="";
      }
     }

  //Card: 1)For Street Address 
  //      2)City
  //      3)Province


     $Address_card;
     $City_card;
     $Province_card;
     $temp_add=$Address;
            
     if($temp_add==="{}"){
         $Address_card="Address Not Available";
         $City_card="";
         $Province_card="";
     }else{
     $temp_add=json_decode($Address);
      if($temp_add==NULL){
            //if any exception occurs then display
            $temp_add=json_decode(stripslashes($Address));
            //1)
            $Address_card=$temp_add->StreetAddress;
            //2)
            $City_card=$temp_add->City;//['City'];
            //3)
            $Province_card=$temp_add->Province;
            // echo "<pre>";
            // print_r($Address_card);
            // print_r($City_card);
            // print_r($Province_card);
            // echo "</pre>";
            // var_dump($temp_add);
         }else{
            //1)
            $Address_card=$temp_add->StreetAddress;
            //2)
            $City_card=$temp_add->City;//['City'];
            //3)
            $Province_card=$temp_add->Province;//['Province'];
            //   var_dump($Address_card);
            //   var_dump($City_card);
            //   var_dump($Province_card);
         }

     }

     //Card:Price
     $Price_card=$Price;
     //Card:Transaction Type
     $TransactionType_card=$TransactionType;
     //Card:Photo
     $Photo_card;   
     $temp2=json_decode($Photo);
     if($temp2==NULL){
      
         $split_arr=explode('"PhotoURL":',$Photo);
         $photo_url_arr=explode(',"LargePhotoURL":',$split_arr[1]);
         $Photo_card=substr($photo_url_arr[0],1,-1);
      

    }else{

        if(!array_key_exists('Photo',$data)){
            $path=getcwd();
            //chdir('Assets');
            
            $path=getcwd().'/default.jpg';
            //chmod($path,0755);
            $Photo_card=$path;
            //echo "<pre>";
            //print_r($data['ListingID']);
            //print_r($path);
            // var_dump($temp2);
            // var_dump($Photo);
            //echo "</pre>";

         }else{
            $temp_Photo=$temp2->PropertyPhoto;//['PropertyPhoto'];//[0]['Thembnail URL'];
        
            //var_dump($temp_Photo);
            if(is_array($temp_Photo)){
               $Photo_card=$temp2->PropertyPhoto[0]->PhotoURL;
            }else{
               $Photo_card=$temp2->PropertyPhoto->PhotoURL;
            }
         }
        
        
    }//IF else NULL ends
    $json=response($Listing_Office_card,$Building_size_card,$Building_bed_card,$Building_bath_card,$Address_card,$City_card,$Province_card,$Photo_card,$Price_card,$TransactionType_card);
      //   echo "<pre>"; 
      //   print_r(json_decode($json,true));
      //   echo "</pre>";

     //--AnalyticsClicks,  
      //   $sql_insert="INSERT INTO `{$wpdb->base_prefix}properties`(ID,LastUpdated,ListingID,Board,Features,ListingContractDate,LocationDescription,OwnershipType,Price,PropertyType,PublicRemarks,TransactionType,WaterFrontType,ZoningDescription)        
      //           VALUES(`$ID`,`$LastUpdated`,`$ListingID`,`$Board`,`$Features`,`$ListingContractDate`,`$LocationDescription`,`$OwnershipType`,`$Price`,`$PropertyType`,`$PublicRemarks`,`$TransactionType`,`$WaterFrontType`,`$ZoningDescription`)";
// valid query for insertion
             $City_card=addslashes($City_card);
             $sql_update="UPDATE  wp_properties_2
             SET LastUpdated=NOW(),
             AgentDetails='$AgentDetails',
             Board='$Board',
             Business='$Business',
             Building='$Building',
             Land='$Land',
             Address='$Address',
             AmmenitiesNearBy='$AmmenitiesNearBy',
             AlternateURL='$AlternateURL',
             EquipmentType='$EquipmentType',
             Features='$Features',
             ListingContractDate='$ListingContractDate',
             LocationDescription='$LocationDescription',
             OwnershipType='$OwnershipType',
             ParkingSpaces='$ParkingSpaces',
             ParkingSpaceTotal='$ParkingSpaceTotal',
             Photo='$Photo',
             Price='$Price',
             PropertyType='$PropertyType',
             PublicRemarks='$PublicRemarks',
             RentalEquipmentType='$RentalEquipmentType',
             Structure='$Structure',
             TransactionType='$TransactionType',
             UtilitiesAvailable='$UtilitiesAvailable',
             WaterFrontType='$WaterFrontType',
             ZoningDescription='$ZoningDescription',
             ViewType='$ViewType',
             MoreInformationLink='$MoreInformationLink',
             Card='$json',
             City='$City_card',
             Province='$Province_card',
             Bedroom='$Building_bed_card',
             Bathroom='$Building_bath_card'
             WHERE ListingID='$ListingID_to_update';";
 // Query Ends 
 

 
 //VALUES('$ID','$LastUpdated','$ListingID','$AgentDetails','$Board','$Business','$Building','$Land','$Address','$AmmenitiesNearBy','$AlternateURL','$EquipmentType','$Features','$ListingContractDate','$LocationDescription','$OwnershipType','$ParkingSpaces','$ParkingSpaceTotal','$Photo','$Price','$PropertyType','$PublicRemarks','$RentalEquipmentType','$Structure','$TransactionType','$UtilitiesAvailable','$WaterFrontType','$ZoningDescription','$ViewType','$AnalyticsClicks','$MoreInformationLink')";
                
         // echo "<pre>";
         // print_r($sql_insert);
         // echo "</pre>";
         //--`$AnalyticsClicks`,
 //data insertion function              

 
 dbDelta($sql_update);

       
}
// register_deactivation_hook(__FILE__, 'my_deactivation');

// function my_deactivation(){
//     global $wpdb;
// 	wp_clear_scheduled_hook('my_hourly_event');
	
// 	$sql="DROP TABLE IF EXISTs`{$wpdb->base_prefix}properties;";
// 	$wpdb->query($sql);
//     rmdir(ABSPATH.'/wp-content/uploads/propertyimages');
//     $sql="DROP TABLE IF EXISTs`{$wpdb->base_prefix}AgentDetails;";
// 	$wpdb->query($sql);
   

// }
//function response( $ID,$Listing_Office,$Building_size,$Building_bed,$Building_bath,$Address,$City,$Province,$Photo,$Price,$TransactionType){
function response($Listing_Office_card,$Building_size_card,$Building_bed_card,$Building_bath_card,$Address_card,$City_card,$Province_card,$Photo_card,$Price_card,$TransactionType_card){
   //$response['ID']=$ID;//get card.php at the time of ID
   $response['Listing Office']=$Listing_Office_card;
    $response['Size'] = $Building_size_card;
    $response['Bedroom']=$Building_bed_card;
    $response['Bathroom']=$Building_bath_card;
    
    $response['Address'] = $Address_card;
    $response['City']=$City_card;
    $response['Province']=$Province_card;
    
    $response['Photo'] = $Photo_card;
    $response['Price'] = $Price_card;
   
   $response['TransactionType'] = $TransactionType_card;
   
   $json_response = str_replace("'","\'",json_encode($response,true));
  return $json_response;
  }
function dbDelta($sql_update){

   include 'db_connection.php';
  
   
   
   
   
   if ($conn->query($sql_update) === TRUE) {
     //  echo "New record created successfully";
     
   } else {
       echo "Error: " ."<pre>". $sql_update . "</pre>" . $conn->error;
       exit();
       
   }
   $conn -> close();
   



  
   
  
}


//insert to database
function Insert_to_database($data){
   

   
   

   // if(array_key_exists('ID',$data)){
   //    $ID="".$data['ID'];
      
   // }else{
   //    $ID=json_encode(json_decode("{}"));
   //   // error_log("---".$ID[0]["ID"]."----");
   // }
   // error_log("ID".$ID);
   
   if(array_key_exists('@attributes',$data)){
      if(array_key_exists('LastUpdated',$data['@attributes'])){
         $LastUpdated=$data['@attributes']['LastUpdated'];
      }else{
         $LastUpdated=json_encode(json_decode("{}"));
      }
      
   }else{
      $LastUpdated=json_encode(json_decode("{}"));
     
   }
   
    //$LASTUPDATED=$data['LastUpdated'];
    $ListingID=$data['ListingID'];

   

    $AgentDetails=str_replace("'","\'",json_encode($data['AgentDetails']));

   

    $Board=$data['Board'];

   
    
     //$wpdb = new wpdb();
   //  $var = $wpdb->_real_escape( $string );
   //@1
    //$Business=json_encode(wptexturize($data['Business']));
   //  $Business=json_encode(esc_attr($data['Business']));
   $Business=str_replace("'","\'",json_encode($data['Business']));
   //  if(preg_match('/[^0-9]*[\']/',json_encode($data['Business']))){
       //$Business=json_encode(str_replace("'","",$data['Business']));

   //  }else{
   //    $Business=json_encode($data['Business']);
      
   //  }
    
    
   

    //$Building=json_encode(json_decode("{}"));
    $Building=str_replace("'","\'",json_encode($data['Building']));

   

    //@2
   //$Land=json_encode(wptexturize($data['Land']));
   //  if(preg_match('/[\'][^\']/',json_encode($data['Land']))){
       //$Land=json_encode(str_replace("'","",$data['Land']));
      //  $Land=json_encode(esc_attr($data['Land']));
       $Land=str_replace("'","\'",json_encode($data['Land']));

   //  }else{
   //    $Land=json_encode($data['Land']);
      
   //  }
   

   if (array_key_exists('Address',$data)) {
      $Address=str_replace("'","\'",json_encode($data['Address']));
   }else{
      
      $Address=json_encode(json_decode("{}"));
   }
    

   

     if (array_key_exists('AmmenitiesNearBy',$data)) {
        $AmmenitiesNearBy=str_replace("'","\'","".$data['AmmenitiesNearBy']);
     }else{
        $AmmenitiesNearBy="";
     }

   

     if (array_key_exists('AlternateURL',$data)) {
        $AlternateURL=str_replace("'","\'",implode(" ",$data['AlternateURL']));
     }else{
        $AlternateURL=json_encode(json_decode("{}"));
     }

   

     if (array_key_exists('EquipmentType',$data)) {
        $EquipmentType=str_replace("'","\'",$data['EquipmentType']);
     }else{
        $EquipmentType="";
     }

   

     if (array_key_exists('Features',$data)) {
        $Features=str_replace("'","\'",$data['Features']);
     }else{
        $Features=json_encode(json_decode("{}"));
     }

   
     


     if (array_key_exists('ListingContractDate',$data)) {
                 
         $ListingContractDate=str_replace("'","\'",$data['ListingContractDate']);
         
         //error_log("TullaTullaTullaTullaa".var_dump($ListingContractDate));
     }else{
        $ListingContractDate="";
     }
     
   

     if (array_key_exists('LocationDescription',$data)) {
        $LocationDescription=str_replace("'","\'",$data['LocationDescription']);
     }else{
        $LocationDescription="";
     }
        if (array_key_exists('OwnershipType',$data)) {
        $OwnershipType=str_replace("'","\'",$data['OwnershipType']);
     }else{
        $OwnershipType="";
     }

   
    
     if (array_key_exists('ParkingSpaces',$data)) {
        $ParkingSpaces=str_replace("'","\'",json_encode($data['ParkingSpaces']));
     }else{
        $ParkingSpaces=json_encode(json_decode("{}"));
     }
   
     if(array_key_exists('ParkingSpaceTotal',$data)){
        $ParkingSpaceTotal=str_replace("'","\'",$data['ParkingSpaceTotal']);
     }else{
        $ParkingSpaceTotal="";
     }
   
    //photo
     if(array_key_exists('Photo',$data)){
      $Photo=str_replace("'","\'",json_encode($data['Photo']));
   }else{
      $Photo=json_encode(json_decode("{}"));
   }
   // $Photo=json_encode($data['Photo']);

   
    //$Price=$data['Price'];
    if(array_key_exists('Price',$data)){
      $Price=str_replace("'","\'",$data['Price']);
   }else{
      //$Price=0;
      $Price=0;
      
   }

   

     $PropertyType=str_replace("'","\'",json_encode($data['PropertyType']));

   

   //@3
    //$PublicRemarks=json_encode(wptexturize($data['PublicRemarks']));
     //$PublicRemarks=json_encode(str_replace("'","",$data['PublicRemarks']));
   //   $PublicRemarks=json_encode(esc_attr($data['PublicRemarks']));
   $PublicRemarks=str_replace("'","\'",$data['PublicRemarks']);
//    if(strpos($PublicRemarks,"\\'CHEERS\\'")!==false){

// $PublicRemarks=str_replace("\\'CHEERS\\'","CHEERS",$data['PublicRemarks']);
//    }
   

    if(array_key_exists('RentalEquipmentType',$data)){
        $RentalEquipmentType=str_replace("'","\'",$data['RentalEquipmentType']);
     }else{
        $RentalEquipmentType='';
     }

   

     if(array_key_exists('Structure',$data)){
        $Structure=str_replace("'","\'",$data['Structure']);
     }else{
        $Structure='';
     }
   
    
    $TransactionType=$data['TransactionType'];
    
   

    if(array_key_exists('UtilitiesAvailable',$data)){
        $UtilitiesAvailable=str_replace("'","\'",json_encode($data['UtilitiesAvailable']));
     }else{
        $UtilitiesAvailable=json_encode(json_decode("{}"));
     }

   

     if(array_key_exists('WaterFrontType',$data)){
        $WaterFrontType=str_replace("'","\'",$data['WaterFrontType']);
     }else{
        $WaterFrontType='';
     }

    
    
     if(array_key_exists('ZoningDescription',$data)){
        $ZoningDescription=str_replace("'","\'",$data['ZoningDescription']);
     }else{
        $ZoningDescription='';
     }

        
     if(array_key_exists('ViewType',$data)){
        $ViewType=$data['ViewType'];
     }else{
        $ViewType='';
     }
    
    

   // $AnalyticsClicks=$data['AnalyticsClick'];

   

    $MoreInformationLink=str_replace("'","\'",$data['MoreInformationLink']);

     /////////////////////////////////////////////////////////////////////////////
     ///////////////////Data INSERTION fOR CARD /////////////////////////////////
     ///////////////////////////////////////////////////////////////////////////
     //$ID_card;//get this at the time of card
     //Card:agent office location
     $Listing_Office_card;
     $temp=json_decode($AgentDetails,true);
           //var_dump($temp);
           if(is_array($temp)){
               if(array_key_exists(0,$temp)){
                  $Listing_Office_card=$temp[0]['Office']['Name'];
               }else{
                  $Listing_Office_card=$temp['Office']['Name'];
               }
               
           } else{
               $Listing_Office_card=$temp['Office']['Name'];
           }
      //Card:Building Size Interior     
     $Building_size_card;
     $Building_bed_card;
     $Building_bath_card;
     $temp_Building=json_decode($Building,true);
     if($temp_Building==null){
        // print_r($data['ID']);
         //print_r($Building);
         $temp_arr=explode(',"Rooms":',$Building);
         //for bedroom ,bath room ,
         $valid_json_str=$temp_arr[0]."}";
         //echo '<pre>';
         $valid_json=json_decode($valid_json_str,true);

         //echo '</pre>';
         //for bedroom and bath room 
         //1)For Bath room
         $Building_bath_card=$valid_json['BathroomTotal'];
         //2)For Bed room
         $Building_bed_card=$valid_json['BedroomsTotal'];
         $temp_size_arr=explode('"SizeInterior":',$Building);
         if(array_key_exists(1,$temp_size_arr)){
         $temp_size=explode(",",$temp_size_arr[1]);
         //3)Size Interior
         $Building_size_card=substr($temp_size[0],1,-1);
         }else{
            //3)Size Interior
            $Building_size_card="";
         }
        
         

     }else{
         if(array_key_exists('SizeInterior',$temp_Building)){
            // $Building_size=json_decode($row['Building']);
            $Building_size_card=$temp_Building['SizeInterior'];
            
         }else{
            $Building_size_card="";
         }
         //Card:Building bedrooms   
      if(array_key_exists('BedroomsTotal',$temp_Building)){
         $Building_bed_card=$temp_Building['BedroomsTotal'];
      }else{
         $Building_bed_card="";
      }
      //Card: Building bathroom 
      if(array_key_exists('BathroomTotal',$temp_Building)){
         $Building_bath_card=$temp_Building['BathroomTotal'];
      }else{
         $Building_bath_card="";
      }
     }

  //Card: 1)For Street Address 
  //      2)City
  //      3)Province


     $Address_card;
     $City_card;
     $Province_card;
     $temp_add=$Address;
            
     if($temp_add==="{}"){
         $Address_card="Address Not Available";
         $City_card="";
         $Province_card="";
     }else{
     $temp_add=json_decode($Address);
      if($temp_add==NULL){
            //if any exception occurs then display
            $temp_add=json_decode(stripslashes($Address));
            //1)
            $Address_card=$temp_add->StreetAddress;
            //2)
            $City_card=$temp_add->City;//['City'];
            //3)
            $Province_card=$temp_add->Province;
            // echo "<pre>";
            // print_r($Address_card);
            // print_r($City_card);
            // print_r($Province_card);
            // echo "</pre>";
            // var_dump($temp_add);

         }else{
            //1)
            $Address_card=$temp_add->StreetAddress;
            //2)
            $City_card=$temp_add->City;//['City'];
            //3)
            $Province_card=$temp_add->Province;//['Province'];

         }

     }

     //Card:Price
     $Price_card=$Price;
     //Card:Transaction Type
     $TransactionType_card=$TransactionType;
     //Card:Photo
     $Photo_card;   
     $temp2=json_decode($Photo);
     if($temp2==NULL){
      
         $split_arr=explode('"PhotoURL":',$Photo);
         $photo_url_arr=explode(',"LargePhotoURL":',$split_arr[1]);
         $Photo_card=substr($photo_url_arr[0],1,-1);
      

    }else{

        if(!array_key_exists('Photo',$data)){
            $path=getcwd();
            chdir('Assets');
            
            $path=getcwd().'/default.jpg';
            chmod($path,0755);
            $Photo_card=$path;
            //echo "<pre>";
            //print_r($data['ListingID']);
            //print_r($path);
            // var_dump($temp2);
            // var_dump($Photo);
            //echo "</pre>";

         }else{
            $temp_Photo=$temp2->PropertyPhoto;//['PropertyPhoto'];//[0]['Thembnail URL'];
        
            //var_dump($temp_Photo);
            if(is_array($temp_Photo)){
               $Photo_card=$temp2->PropertyPhoto[0]->PhotoURL;
            }else{
               $Photo_card=$temp2->PropertyPhoto->PhotoURL;
            }
         }
        
        
    }//IF else NULL ends
    $json=response($Listing_Office_card,$Building_size_card,$Building_bed_card,$Building_bath_card,$Address_card,$City_card,$Province_card,$Photo_card,$Price_card,$TransactionType_card);

// valid query for insertion
             $City_card=addslashes($City_card);
             $sql_insert="INSERT INTO wp_properties_2(LastUpdated,ListingID,AgentDetails,Board,Business,Building,Land,Address,AmmenitiesNearBy,AlternateURL,EquipmentType,Features,ListingContractDate,LocationDescription,OwnershipType,ParkingSpaces,ParkingSpaceTotal,Photo,Price,PropertyType,PublicRemarks,RentalEquipmentType,Structure,TransactionType,UtilitiesAvailable,WaterFrontType,ZoningDescription,ViewType,MoreInformationLink,Card,City,Province,Bedroom,Bathroom)
             VALUES('$LastUpdated','$ListingID','$AgentDetails','$Board','$Business','$Building','$Land','$Address','$AmmenitiesNearBy','$AlternateURL','$EquipmentType','$Features','$ListingContractDate','$LocationDescription','$OwnershipType','$ParkingSpaces','$ParkingSpaceTotal','$Photo','$Price','$PropertyType','$PublicRemarks','$RentalEquipmentType','$Structure','$TransactionType','$UtilitiesAvailable','$WaterFrontType','$ZoningDescription','$ViewType','$MoreInformationLink','$json','$City_card','$Province_card','$Building_bed_card','$Building_bath_card')";
 // Query Ends 
 

 
 //VALUES('$ID','$LastUpdated','$ListingID','$AgentDetails','$Board','$Business','$Building','$Land','$Address','$AmmenitiesNearBy','$AlternateURL','$EquipmentType','$Features','$ListingContractDate','$LocationDescription','$OwnershipType','$ParkingSpaces','$ParkingSpaceTotal','$Photo','$Price','$PropertyType','$PublicRemarks','$RentalEquipmentType','$Structure','$TransactionType','$UtilitiesAvailable','$WaterFrontType','$ZoningDescription','$ViewType','$AnalyticsClicks','$MoreInformationLink')";
                
         // echo "<pre>";
         // print_r($sql_insert);
         // echo "</pre>";
         //--`$AnalyticsClicks`,
 //data insertion function              
              dbDelta($sql_insert);
       
}