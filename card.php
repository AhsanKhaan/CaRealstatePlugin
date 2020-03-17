
<?php
header("Content-Type:application/json");
if (isset($_GET['Page'])&& $_GET['Page']!="" ) {
 prepareAPI();
}else{
 	echo response(NULL,NULL,NULL,NULL,NULL,NULL,NULL ,NULL,NULL, 400,"Invalid Request");
 }
 
function response( $ID,$AgentDetails,$Building_size,$Building_bed,$Building_bath,$Address,$City,$Province,$Photo,$Price,$TransactionType){
 //$response['order_id'] = $order_id;
 $response['ID']=$ID;
 $response['Listing Office']=$AgentDetails;
  $response['Size'] = $Building_size;
  $response['Bedroom']=$Building_bed;
  $response['Bathroom']=$Building_bath;
  
  $response['Address'] = $Address;
  $response['City']=$City;
  $response['Province']=$Province;
  
  $response['Photo'] = $Photo;
  $response['Price'] = $Price;
 
 $response['TransactionType'] = $TransactionType;
 
 $json_response = json_encode($response,true);
return $json_response;
}

function prepareAPI(){
    include('db_connection.php');
    $Listing_id = $_GET['Page'];
    $Limit=9;
    $page=isset($Listing_id)?$Listing_id:1;
    $startwith=($page-1)*$Limit;

    $query="SELECT ID,Address,Price,Building,AgentDetails,Photo,TransactionType FROM `wp_properties_2` LIMIT $startwith,$Limit";
    //print_r("QUERY".$query);
	$result = mysqli_query(
	$conn,
    $query);
    
    $getcount=mysqli_query($conn,"SELECT COUNT(ID) FROM `wp_properties_2`");
	//print_r($result);
	if(mysqli_num_rows($result)>0){
        
       // $arr=new Array();
        $response="";
        if(mysqli_num_rows($getcount)>0){
            $TotalListing=mysqli_fetch_array($getcount,MYSQLI_NUM);
            $response.='{"TotalCount" : "'.ceil($TotalListing[0]/$Limit).'","property":[';
            //$response.=',';
        }
        $index=0;
        while($row = mysqli_fetch_array($result)){
          //  print_r($row);
            // $response.=$index.":";
             $index++;
            $ID=$row['ID'];
            $TransactionType=$row['TransactionType'];
            $Price=$row['Price'];
           
           $temp=json_decode($row['AgentDetails'],true);
           //var_dump($temp);
           if(is_array($temp)){
               if(array_key_exists(0,$temp)){
                   $AgentDetails=$temp[0]['Office']['Name'];
               }else{
                   $AgentDetails=$temp['Office']['Name'];
               }
               
           } else{
               $AgentDetails=$temp['Office']['Name'];
           }
           
            
            
            $temp2=json_decode($row['Photo']);
            //$Photo=$temp2->PropertyPhoto[0]->ThumbnailURL
            $temp_Photo=$temp2->PropertyPhoto;//['PropertyPhoto'];//[0]['Thembnail URL'];
            //var_dump($temp_Photo);
            if(is_array($temp_Photo)){
               $Photo=$temp2->PropertyPhoto[0]->PhotoURL;
            }else{
               $Photo=$temp2->PropertyPhoto->PhotoURL;
            }
            
            
        //    if(strpos($row['Building'],'SizeInterior')!==FALSE){
        //        $position=strpos($row['Building'],'SizeInterior');
        //        // print_r("String postion ".$position);
        //        $temp_str=substr($row['Building'],$position);
        //        $size_str=substr($temp_str,strpos($temp_str,':'));
               
        //        if((bool)strpos($size_str,"[]")!==FALSE){
        //            $Building_size="NULL";
                  
        //        }else if((bool)strpos($size_str,"\"")!==FALSE){
               
        //            $Building_size=substr($size_str,strpos($size_str,"\"")+1,strpos($size_str,"sqft")-3);
        //           }
               
        //    }else{
        //        $Building_size="";
               
        //    }
        $temp=json_decode($row['Building'],true);
            if(array_key_exists('SizeInterior',$temp)){
               // $Building_size=json_decode($row['Building']);
                $Building_size=$temp['SizeInterior'];
                
            }else{
                $Building_size="";
            }
        //    if(strpos($row['Building'],'BedroomsTotal')!==FALSE){
        //        //print_r($row['Building']);
        //        $position=strpos($row['Building'],'BedroomsTotal');
        //        // print_r("String postion ".$position);
        //        $temp_str=substr($row['Building'],$position);
        //        $size_str=substr($temp_str,strpos($temp_str,':'));
               
               
        //        if((bool)strpos($size_str,"\"")!==FALSE){
                   
        //           $Building_bed=explode("\"",$size_str)[1];
        //        }
        //     }else{
        //        $Building_bed="";
        //        }
        if(array_key_exists('BedroomsTotal',$temp)){
            $Building_bed=$temp['BedroomsTotal'];
        }else{
            $Building_bed="";
        }   
            //    if(strpos($row['Building'],'BathroomTotal')!==FALSE){
            //        //print_r($row['Building']);
            //        $position=strpos($row['Building'],'BathroomTotal');
            //        // print_r("String postion ".$position);
            //        $temp_str=substr($row['Building'],$position);
            //        $size_str=substr($temp_str,strpos($temp_str,':'));
            //        //print_r("string position".$size_str."\n\n");
                   
            //        if((bool)strpos($size_str,"\"")!==FALSE){
                       
            //           $Building_bath=explode("\"",$size_str)[1];
            //        }
            //    }else{
            //        $Building_bath="";
            //        }
            if(array_key_exists('BathroomTotal',$temp)){
                $Building_bath=$temp['BathroomTotal'];
            }else{
                $Building_bath="";
            }  
            //print_r("\n\n\n\n\n\n\n\n".$row['Building']."\n\n\n\n\n\n\n\n");
            $temp_add=$row['Address'];
            
            if($temp_add==="{}"){
                $Address="Address Not Available";
                $City="";
                $Province="";
            }else{
            $temp_add=json_decode($row['Address']);
            $Address=$temp_add->StreetAddress;
            $City=$temp_add->City;//['City'];
            $Province=$temp_add->Province;//['Province'];
            }
            
                   
           
              //$arr.push(response( $AgentDetails,$Building_size,$Building_bed,$Building_bath,$Address,$City,$Province,$Photo,$Price,$TransactionType));     
              //response( $ID,$AgentDetails,$Building_size,$Building_bed,$Building_bath,$Address,$City,$Province,$Photo,$Price,$TransactionType);
              $response.= response( $ID,$AgentDetails,$Building_size,$Building_bed,$Building_bath,$Address,$City,$Province,$Photo,$Price,$TransactionType);
              if($index!=mysqli_num_rows($result)){
                $response.=",";
    
              }
         }
         $response.="]}";
         //$response.=str_replace(",","",strpos($response,-2));
        $response=json_decode($response);
         $response=json_encode($response);
        //$response=str_replace("\/","\\",$response);
        //var_dump($response);
        echo $response;
        mysqli_free_result($getcount);
        mysqli_free_result($result);
        mysqli_close($conn);
	}else{
		echo response( NULL,NULL,NULL,NULL,NULL,NULL,NULL ,NULL,NULL,200,"No Record Found");
	}
}
?>