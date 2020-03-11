
<?php
header("Content-Type:application/json");
if (isset($_GET['id'])&& $_GET['id']!="" ) {
	include('db_connection.php');
	$order_id = $_GET['id'];
	$result = mysqli_query(
	$conn,
	"SELECT * FROM `wp_properties_2` WHERE id=$order_id");
	
	if(mysqli_num_rows($result)>0){
		$row = mysqli_fetch_array($result);
	//	print_r($row);
		
// ID
// LastUpdated
// ListingID
// AgentDetails
// Board
// Business
// Building
// Land
// Address
// AmmenitiesNearBy
// AlternateURL
// EquipmentType
// Features
// ListingContractDate
// LocationDescription
// OwnershipType
// ParkingSpaces
// ParkingSpaceTotal
// Photo
// Price
// PropertyType
// PublicRemarks
// RentalEquipmentType
// Structure
// TransactionType
// UtilitiesAvailable
// WaterFrontType
// ZoningDescription
// ViewType
// MoreInformationLink
$ID=$row['ID'];
$LastUpdated=json_decode($row['LastUpdated']);
$ListingID=json_decode($row['ListingID']);
$AgentDetails=json_decode($row['AgentDetails']);
$Board=json_decode($row['Board']);
$Business=json_decode($row['Business']);
$Building=json_decode($row['Building']);
$Land=json_decode($row['Land']);
$Address=json_decode($row['Address']);
$AmmenitiesNearBy=json_decode($row['AmmenitiesNearBy']);
$AlternateURL=json_decode($row['AlternateURL']);
$EquipmentType=json_decode($row['EquipmentType']);
$Features=json_decode($row['Features']);
$ListingContractDate=json_decode($row['ListingContractDate']);
$LocationDescription=json_decode($row['LocationDescription']);
$OwnershipType=json_decode($row['OwnershipType']);
$ParkingSpaces=json_decode($row['ParkingSpaces']);
$ParkingSpaceTotal=json_decode($row['ParkingSpaceTotal']);
$Photo=json_decode($row['Photo']);
$Price=json_decode($row['Price']);
$PropertyType=json_decode($row['PropertyType']);
$PublicRemarks=json_decode($row['PublicRemarks']);
//$RentalEquipmentType=json_decode($row['RentalEquipmentType']);
$RentalEquipmentType=$row['RentalEquipmentType'];
$Structure=$row['Structure'];
$TransactionType=$row['TransactionType'];
$UtilitiesAvailable=json_decode($row['UtilitiesAvailable']);
$WaterFrontType=json_decode($row['WaterFrontType']);
$ZoningDescription=json_decode($row['ZoningDescription']);
$ViewType=json_decode($row['ViewType']);
$MoreInformationLink=json_decode($row['MoreInformationLink']);
		// $id = $row['ID'];
		// $name = $row['name'];
		// $skills = $row['skills'];
		// $address = $row['address'];
		// $designation = $row['designation'];
		// $age = $row['age'];
		response( $ID, $LastUpdated,$ListingID,$AgentDetails,$Board,$Business,$Building,$Land,$Address,$AmmenitiesNearBy,$AlternateURL,$EquipmentType,$Features,$ListingContractDate,$LocationDescription,$OwnershipType,$ParkingSpaces,$ParkingSpaceTotal,$Photo,$Price,$PropertyType,$PublicRemarks,$RentalEquipmentType,$Structure,$TransactionType,$UtilitiesAvailable,$WaterFrontType,$ZoningDescription,$ViewType,$MoreInformationLink);
		mysqli_close($conn);
	}else{
		response( NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL ,200,"No Record Found");
	}
}else{
 	response( NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL,NULL,NULL ,NULL,NULL,NULL,NULL , 400,"Invalid Request");
 }
 
function response( $ID, $LastUpdated,$ListingID,$AgentDetails,$Board,$Business,$Building,$Land,$Address,$AmmenitiesNearBy,$AlternateURL,$EquipmentType,$Features,$ListingContractDate,$LocationDescription,$OwnershipType,$ParkingSpaces,$ParkingSpaceTotal,$Photo,$Price,$PropertyType,$PublicRemarks,$RentalEquipmentType,$Structure,$TransactionType,$UtilitiesAvailable,$WaterFrontType,$ZoningDescription,$ViewType,$MoreInformationLink){
 //$response['order_id'] = $order_id;
 $response['ID'] = $ID;
 $response['LastUpdated'] = $LastUpdated;
 $response['ListingID'] = $ListingID;
 $response['AgentDetails']=$AgentDetails;
 $response['Board']=$Board;
 $response['Business']=$Business;

 $response['Building'] = $Building;
 $response['Land'] = $Land;
 $response['Address'] = $Address;
 $response['AmmenitiesNearBy']=$AmmenitiesNearBy;
 $response['AlternateURL']=$AlternateURL;
 $response['EquipmentType']=$EquipmentType;

 $response['Features'] = $Features;
 $response['ListingContractDate'] = $ListingContractDate;
 $response['LocationDescription'] = $LocationDescription;
 $response['OwnershipType']=$OwnershipType;
 $response['ParkingSpaces']=$ParkingSpaces;
 $response['ParkingSpaceTotal']=$ParkingSpaceTotal;

 

 $response['Photo'] = $Photo;
 $response['Price'] = $Price;
 $response['PropertyType'] = $PropertyType;
 $response['PublicRemarks']=$PublicRemarks;
 $response['RentalEquipmentType']=$RentalEquipmentType;
 $response['Structure']=$Structure;
 
 $response['TransactionType'] = $TransactionType;
 $response['UtilitiesAvailable'] = $UtilitiesAvailable;
 $response['WaterFrontType'] = $WaterFrontType;
 $response['ZoningDescription']=$ZoningDescription;
// $response['RentalEquipmentType']=$RentalEquipmentType;
 $response['MoreInformationLink']=$MoreInformationLink;
 $json_response = json_encode($response,JSON_UNESCAPED_SLASHES);
 echo $json_response;
}
?>