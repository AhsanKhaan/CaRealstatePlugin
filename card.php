
<?php
header("Content-Type:application/json");
if (isset($_GET['Page'])&& $_GET['Page']!="" ) {
    $Listing_id = $_GET['Page'];
    $Limit=9;
    $page=isset($Listing_id)?$Listing_id:1;
    $startwith=($page-1)*$Limit;

    $query="SELECT ID,Card FROM `wp_properties_2` LIMIT $startwith,$Limit";
    $count="SELECT COUNT(ID) FROM `wp_properties_2`";
 prepareAPI($query,$count,$Limit);

}else if(isset($_SERVER['QUERY_STRING'])&& $_SERVER['QUERY_STRING']!=""){
    
    parse_str($_SERVER['QUERY_STRING'],$params);
    //var_dump($params);
    $query="SELECT ID,Card FROM wp_properties_2 WHERE ";
    $count="SELECT COUNT(ID) FROM wp_properties_2 WHERE ";
    if(array_key_exists("input_transaction_type",$params)){
        if($params['input_transaction_type']==NULL){

        }else{
            
            $query.="TransactionType IN ".$params["input_transaction_type"];
            //$query=stripslashes($query);
            $count.=" TransactionType IN ".$params["input_transaction_type"];
            //$count=stripslashes($count);
            //print_r($query);
            //exit();
            //prepareAPI($query,$count,100);
        }
    }
    if(array_key_exists("input_property_type",$params)){
        if($params['input_property_type']==NULL){
            //do nothing
            
        }else{
            
            $query.=" AND PropertyType=\'\"".$params["input_property_type"]."\"\'";
           // $query=stripslashes($query);
            $count.=" AND PropertyType=\'\"".$params["input_property_type"]."\"\'";
           // $count=stripslashes($count);
           // print_r($query);
           // print_r($count);
           // exit();
            //prepareAPI($query,$count,100);
        }
    }
    if(array_key_exists("input_city",$params)){
        if($params['input_city']==NULL){
            //do nothing
            
        }else{
            
            $query.=" AND City Like \'".$params["input_city"]."\'";
            $count.=" AND City Like \'".$params["input_city"]."\'";
            //prepareAPI($query,$count,100);
        }
    }

    if(array_key_exists("input_province",$params)){
        if($params['input_province']==NULL){
            //do nothing
            
        }else{
            
            $query.=" AND Province=\'".$params["input_province"]."\'";
            $count.=" AND Province=\'".$params["input_province"]."\'";
            //prepareAPI($query,$count,100);
        }
    }
    if(array_key_exists("input_mls",$params)){
        if($params['input_mls']==NULL){
            //do nothing
            
        }else{
            
            $query.=" AND ListingID=\'\"".$params["input_mls"]."\"\'";
            $query=stripslashes($query);
            $count.=" AND ListingID=\'\"".$params["input_mls"]."\"\'";
            $count=stripslashes($count);
            print_r($query);
            print_r($count);
            exit();
            //prepareAPI($query,$count,100);
        }
    }
    
    // $query="SELECT ID,Address,Price,Building,AgentDetails,Photo,TransactionType FROM `wp_properties_2` WHERE TransactionType=".$_GET['Type'];
    // $count="SELECT COUNT(ID) FROM `wp_properties_2`WHERE TransactionType=".strtolower($_GET['Type']);
    // prepareAPI($query,$count,9);
}else{
 	echo response(NULL,NULL,NULL,NULL,NULL,NULL,NULL ,NULL,NULL, 400,"Invalid Request");
 }
 

function prepareAPI($query,$count,$Limit){
    include('db_connection.php');
    
   // print_r("QUERY".$query);
	$result = mysqli_query(
	$conn,
    $query);
    
    $getcount=mysqli_query($conn,$count);
	//var_dump($result);
	if(mysqli_num_rows($result)>0){
        
       // $arr=new Array();
        $response="";
        if(mysqli_num_rows($getcount)>0){
            $TotalListing=mysqli_fetch_array($getcount,MYSQLI_NUM);
            $response.='{"TotalCount" : "'.ceil($TotalListing[0]/$Limit).'","TotalListing":'.$TotalListing[0].',"property":[';
            //$response.=',';
        }
        $index=0;
        while($row = mysqli_fetch_array($result)){
         //  print_r($row);
         // $response.=$index.":";
            $index++;
            $ID=$row['ID'];
            //conversion to array
            $json=json_decode($row['Card'],true);
            if($json==NULL){
                print_r($row['Card']);
                print_r($ID);
                exit();
            }
            $AgentDetails=$json['Listing Office'];
            $Building_size=$json['Size'];
            $Building_bed=$json['Bedroom'];
            $Building_bath=$json['Bathroom'];
            $Address=$json['Address'];
            $City=$json['City'];
            $Province=$json['Province'];
            $Photo=$json['Photo'];
            $Price=$json['Price'];
            $TransactionType=$json['TransactionType'];
            
                
        
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
?>