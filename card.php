
<?php
header("Content-Type:application/json");
if (isset($_GET['Page'])&& $_GET['Page']!="" ) {
    $Listing_id = $_GET['Page'];
    $Limit=9;
    $page=isset($Listing_id)?$Listing_id:1;
    $startwith=($page-1)*$Limit;

    $query="SELECT ID,Address,Price,Building,AgentDetails,Photo,TransactionType FROM `wp_properties_2` LIMIT $startwith,$Limit";
    $count="SELECT COUNT(ID) FROM `wp_properties_2`";
 prepareAPI($query,$count,$Limit);
}else if(isset($_GET['Type'])&& $_GET['Type']!=""){
    echo json_encode('{"Name":"Hello World"}');
    // $query="SELECT ID,Address,Price,Building,AgentDetails,Photo,TransactionType FROM `wp_properties_2` WHERE TransactionType=".$_GET['Type'];
    // $count="SELECT COUNT(ID) FROM `wp_properties_2`WHERE TransactionType=".strtolower($_GET['Type']);
    // prepareAPI($query,$count,9);
}else{
 	echo response(NULL,NULL,NULL,NULL,NULL,NULL,NULL ,NULL,NULL, 400,"Invalid Request");
 }
 

function prepareAPI($query,$count,$Limit){
    include('db_connection.php');
    
    //print_r("QUERY".$query);
	$result = mysqli_query(
	$conn,
    $query);
    
    $getcount=mysqli_query($conn,$count);
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
           
            //error in json format at id=3
            //text where null comes:
// $Photo_txt='{"PropertyPhoto":[{"SequenceId":"1","LastUpdated":"20/03/2020 12:15:40 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:40 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601402300000/reb13/lowres/6/251986_1.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601402300000/reb13/medres/6/251986_1.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601402300000/reb13/highres/6/251986_1.jpg"},{"SequenceId":"2","Description":"DOUBLE WIDE DRIVEWAY","LastUpdated":"20/03/2020 12:15:41 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:41 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601412200000/reb13/lowres/6/251986_2.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601412200000/reb13/medres/6/251986_2.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601412200000/reb13/highres/6/251986_2.jpg"},{"SequenceId":"3","Description":"ALL BRICK MAIN FLOOR EXTERIOR","LastUpdated":"20/03/2020 12:15:41 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:41 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601418800000/reb13/lowres/6/251986_3.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601418800000/reb13/medres/6/251986_3.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601418800000/reb13/highres/6/251986_3.jpg"},{"SequenceId":"4","Description":"SPACIOUS FOYER","LastUpdated":"20/03/2020 12:15:40 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:40 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601406800000/reb13/lowres/6/251986_4.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601406800000/reb13/medres/6/251986_4.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601406800000/reb13/highres/6/251986_4.jpg"},{"SequenceId":"5","Description":"HARDWOOD FLOORING IN LIVING ROOM & DINING ROOM","LastUpdated":"20/03/2020 12:15:43 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:43 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601431170000/reb13/lowres/6/251986_5.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601431170000/reb13/medres/6/251986_5.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601431170000/reb13/highres/6/251986_5.jpg"},{"SequenceId":"6","Description":"SEPARATE DINING ROOM","LastUpdated":"20/03/2020 12:15:41 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:41 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601418770000/reb13/lowres/6/251986_6.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601418770000/reb13/medres/6/251986_6.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601418770000/reb13/highres/6/251986_6.jpg"},{"SequenceId":"7","Description":"LARGE EAT-IN KITCHEN","LastUpdated":"20/03/2020 12:15:40 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:40 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601402870000/reb13/lowres/6/251986_7.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601402870000/reb13/medres/6/251986_7.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601402870000/reb13/highres/6/251986_7.jpg"},{"SequenceId":"8","Description":"LOADS OF STORAGE","LastUpdated":"20/03/2020 12:15:41 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:41 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601412200000/reb13/lowres/6/251986_8.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601412200000/reb13/medres/6/251986_8.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601412200000/reb13/highres/6/251986_8.jpg"},{"SequenceId":"9","Description":"STAINLESS DISHWASHER","LastUpdated":"20/03/2020 12:15:40 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:40 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601404170000/reb13/lowres/6/251986_9.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601404170000/reb13/medres/6/251986_9.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601404170000/reb13/highres/6/251986_9.jpg"},{"SequenceId":"10","Description":"BREAKFAST BAR ISLAND","LastUpdated":"20/03/2020 12:15:40 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:40 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601405530000/reb13/lowres/6/251986_10.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601405530000/reb13/medres/6/251986_10.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601405530000/reb13/highres/6/251986_10.jpg"},{"SequenceId":"11","Description":"FULL FRIDGE & STOVE INCLUDED","LastUpdated":"20/03/2020 12:15:42 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:42 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601426000000/reb13/lowres/6/251986_11.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601426000000/reb13/medres/6/251986_11.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601426000000/reb13/highres/6/251986_11.jpg"},{"SequenceId":"12","Description":"4 PC MAIN BATH ON 2ND LEVEL","LastUpdated":"20/03/2020 12:15:42 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:42 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601429330000/reb13/lowres/6/251986_12.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429330000/reb13/medres/6/251986_12.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429330000/reb13/highres/6/251986_12.jpg"},{"SequenceId":"13","Description":"LARGE MASTER BEDROOM ON 2ND LEVEL","LastUpdated":"20/03/2020 12:15:39 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:39 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601397770000/reb13/lowres/6/251986_13.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601397770000/reb13/medres/6/251986_13.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601397770000/reb13/highres/6/251986_13.jpg"},{"SequenceId":"14","Description":"SITTING AREA IN MASTER BEDROOM ON 2ND LEVEL","LastUpdated":"20/03/2020 12:15:39 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:39 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601396500000/reb13/lowres/6/251986_14.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601396500000/reb13/medres/6/251986_14.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601396500000/reb13/highres/6/251986_14.jpg"},{"SequenceId":"15","Description":"WALK-IN CLOSET IN MASTER BEDROOM ON 2ND LEVEL","LastUpdated":"20/03/2020 12:15:42 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:42 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601429330000/reb13/lowres/6/251986_15.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429330000/reb13/medres/6/251986_15.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429330000/reb13/highres/6/251986_15.jpg"},{"SequenceId":"16","Description":"2ND BEDROOM ON 2ND LEVEL","LastUpdated":"20/03/2020 12:15:41 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:41 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601418770000/reb13/lowres/6/251986_16.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601418770000/reb13/medres/6/251986_16.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601418770000/reb13/highres/6/251986_16.jpg"},{"SequenceId":"17","Description":"3RD BEDROOM ON 2ND LEVEL","LastUpdated":"20/03/2020 12:15:42 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:42 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601422030000/reb13/lowres/6/251986_17.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601422030000/reb13/medres/6/251986_17.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601422030000/reb13/highres/6/251986_17.jpg"},{"SequenceId":"18","Description":"GAMES ROOM ON 3RD LEVEL WITH CLOSET AND LARGE WINDOW COULD EASILY BE 4TH BEDROOM","LastUpdated":"20/03/2020 12:15:43 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:43 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601430870000/reb13/lowres/6/251986_18.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601430870000/reb13/medres/6/251986_18.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601430870000/reb13/highres/6/251986_18.jpg"},{"SequenceId":"19","Description":"LARGE REC ROOM ON 3RD LEVEL","LastUpdated":"20/03/2020 12:15:39 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:39 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601397000000/reb13/lowres/6/251986_19.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601397000000/reb13/medres/6/251986_19.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601397000000/reb13/highres/6/251986_19.jpg"},{"SequenceId":"20","Description":"LARGE REC ROOM ON 3RD LEVEL","LastUpdated":"20/03/2020 12:15:40 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:40 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601401770000/reb13/lowres/6/251986_20.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601401770000/reb13/medres/6/251986_20.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601401770000/reb13/highres/6/251986_20.jpg"},{"SequenceId":"21","Description":"3 PC BATH ON 3RD LEVEL","LastUpdated":"20/03/2020 12:15:41 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:41 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601419630000/reb13/lowres/6/251986_21.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601419630000/reb13/medres/6/251986_21.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601419630000/reb13/highres/6/251986_21.jpg"},{"SequenceId":"22","Description":"3 PC BATH ON 3RD LEVEL","LastUpdated":"20/03/2020 12:15:42 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:42 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601429730000/reb13/lowres/6/251986_22.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429730000/reb13/medres/6/251986_22.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429730000/reb13/highres/6/251986_22.jpg"},{"SequenceId":"23","Description":"COMPLETELY FINISHED 4TH LEVEL WITH HOME GYM","LastUpdated":"20/03/2020 12:15:42 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:42 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601423800000/reb13/lowres/6/251986_23.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601423800000/reb13/medres/6/251986_23.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601423800000/reb13/highres/6/251986_23.jpg"},{"SequenceId":"24","Description":"4TH LEVEL OFFICE","LastUpdated":"20/03/2020 12:15:43 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:43 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601430700000/reb13/lowres/6/251986_24.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601430700000/reb13/medres/6/251986_24.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601430700000/reb13/highres/6/251986_24.jpg"},{"SequenceId":"25","Description":"LARGE PATIO","LastUpdated":"20/03/2020 12:15:43 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:43 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601430930000/reb13/lowres/6/251986_25.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601430930000/reb13/medres/6/251986_25.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601430930000/reb13/highres/6/251986_25.jpg"},{"SequenceId":"26","Description":"HUGE DECK OFF KITCHEN","LastUpdated":"20/03/2020 12:15:42 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:42 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601429330000/reb13/lowres/6/251986_26.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429330000/reb13/medres/6/251986_26.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429330000/reb13/highres/6/251986_26.jpg"},{"SequenceId":"27","Description":"COMPLETELY FENCED YARD","LastUpdated":"20/03/2020 12:15:43 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:43 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601430770000/reb13/lowres/6/251986_27.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601430770000/reb13/medres/6/251986_27.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601430770000/reb13/highres/6/251986_27.jpg"},{"SequenceId":"28","Description":"GARDENS AND STORAGE SHED","LastUpdated":"20/03/2020 12:15:42 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:42 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601422000000/reb13/lowres/6/251986_28.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601422000000/reb13/medres/6/251986_28.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601422000000/reb13/highres/6/251986_28.jpg"},{"SequenceId":"29","Description":"GARDENS IN BACK YARD","LastUpdated":"20/03/2020 12:15:42 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:42 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601429730000/reb13/lowres/6/251986_29.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429730000/reb13/medres/6/251986_29.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601429730000/reb13/highres/6/251986_29.jpg"},{"SequenceId":"30","Description":"100 AMP PANEL","LastUpdated":"20/03/2020 12:15:40 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:40 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601400900000/reb13/lowres/6/251986_30.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601400900000/reb13/medres/6/251986_30.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601400900000/reb13/highres/6/251986_30.jpg"},{"SequenceId":"31","Description":"HIGH EFFICIENCY "AIREASE" FORCED AIR GAS FURNACE PLUS EXTERIOR AIR CONDITIONING UNIT REPLACED IN 2016","LastUpdated":"20/03/2020 12:15:41 AM","PhotoLastUpdated":"Fri, 20 Mar 2020 05:15:41 GMT","ThumbnailURL":"https://ddfcdn.realtor.ca/listings/TS637202601418770000/reb13/lowres/6/251986_31.jpg","PhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601418770000/reb13/medres/6/251986_31.jpg","LargePhotoURL":"https://ddfcdn.realtor.ca/listings/TS637202601418770000/reb13/highres/6/251986_31.jpg"}]}';
// // initial coding
             $temp2=json_decode($row['Photo']);
// //coding ends
//            $temp2=json_decode($Photo_txt);
//            print_r(substr_count($Photo_txt,"Description"));
//            $arr=explode('Description',$Photo_txt);
//            $desc_arr=array();

//            foreach($arr as $key=>$item){
//             $temp=explode(",",$item);
//             $desc_arr[$key]=$temp[0];
//            }
//             unset($desc_arr[0]);//unset() is an inbuilt function that removes the specified element from an array .
//             $desc_arr=array_values($desc_arr);//and reindex an array
//            print_r($desc_arr);
//         //    $pht=preg_match('/"Description":(([a-zA-Z\d\s"]+)("))/',$Photo_txt,$matches);
        
//        // $pht=preg_match('/":(([a-zA-Z\d\s"]+)("))/',$desc_arr[0],$matches);
//        // var_dump($pht);
//         $description_list=array();
//         foreach($desc_arr as $key=>$item){
//       //      preg_match('/":(([a-zA-Z\d\s&"]+)("))/',$item,$matches);
//       //      print_r($matches[2]);
//             $description_list[$key]=substr($item,3,-1);   
//         }
//         print_r($description_list);
//         //var_dump($pht);
//            print_r($matches);

    if($temp2==NULL){
          //  print_r($Photo_txt);
             //print_r($row['Photo']);
             $split_arr=explode('"PhotoURL":',$row['Photo']);
             $photo_url_arr=explode(',"LargePhotoURL":',$split_arr[1]);
             $Photo=substr($photo_url_arr[0],1,-1);
             //var_dump($Photo);
            
            
             //     print_r("if->".$temp2);
            //     //print_r(js$arr);
            //     //print_r($row['Photo']);
         //     exit();
        }else{
            $temp_Photo=$temp2->PropertyPhoto;//['PropertyPhoto'];//[0]['Thembnail URL'];
            
            //var_dump($temp_Photo);
            if(is_array($temp_Photo)){
               $Photo=$temp2->PropertyPhoto[0]->PhotoURL;
            }else{
               $Photo=$temp2->PropertyPhoto->PhotoURL;
            }
        }//IF NULL ends
            // if(!property_exists($temp2,'PropertyPhoto')){
            //     print_r("asdf");
            //     //var_dump($temp2);
            //     print_r($row['Photo']);
            //     print_r("asdf");
            // }            
            
            
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
        // if($temp==null){
        //     print_r($row['ID']);
        //     print_r($row['Building']);
            
        //     exit();
        // }
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