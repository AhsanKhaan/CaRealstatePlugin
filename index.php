<?php

/**
* Plugin Name: Crea.ca
* Plugin URI: https://www.BuddyPlugin.com/
* Description: It can retrieved data from API and store it in Database
* Version: 1.0
* Author: Ahsan Khan
* Author URI: http://yourwebsiteursfdsl.com/
**/
//if user can changed the url then abort it
defined('ABSPATH') or die('Un authorized Access');
//action when user passed in into admin panel
//add_action("admin_init","callback_function_name");
//add short code for display table

/*If you looking for the php eneral code, please try this :

1- dowload PHRets_CREA.php file from CREA website : https://support.crea.ca/DDF#/discussion/20/crea-data-distribution-code-sample-in-php.

2- create your php file in the same folder : Of course you must have $ListingKey, change it on the code
*/




global $wpdb;
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
register_activation_hook(__FILE__, 'my_activation');

function my_activation() {
    
    //for making folder locallly for storing images
	mkdir(ABSPATH.'/wp-content/uploads/propertyimages');
    global $wpdb;
    //     define character of its own query.
        $charset_collate = $wpdb->get_charset_collate();
    //create table for agent det
    
    
        //	create table command for properties
        $sql = "CREATE TABLE IF NOT EXISTs`{$wpdb->base_prefix}properties_2` (
        ID int NOT NULL AUTO_INCREMENT,
        LastUpdated varchar(100) ,
        ListingID varchar(50) ,
        AgentDetails BLOB ,
        Board varchar(100) ,
        Business varchar(1000) ,
        Building varchar(500) ,
        Land  varchar(1500),
        Address varchar(2000) ,
        AmmenitiesNearBy varchar(100),
        AlternateURL varchar(200),
        EquipmentType  varchar(100),
        Features varchar(200),
        ListingContractDate  varchar(300),
        LocationDescription varchar(300),
        OwnershipType varchar(300),
        ParkingSpaces varchar(300),
        ParkingSpaceTotal varchar(100),
        Photo BLOB,

        Price DOUBLE ,
        PropertyType varchar(100) ,
        PublicRemarks varchar(1000),

        RentalEquipmentType varchar(100),
        Structure varchar(100),
        TransactionType varchar(30),
        UtilitiesAvailable varchar(1000),
        WaterFrontType varchar(20),
        ZoningDescription varchar(20),
        ViewType varchar(10),
        MoreInformationLink varchar(200),
        PRIMARY KEY(ID)
         ) $charset_collate;";

      
   dbDelta($sql);
}
function displayListing(){
global $wpdb;
$query = $wpdb->get_results(`SELECT ListingID FROM {$wpdb->prefix}_properties WHERE ID=1`);
echo "<pre>";
print_r($query);
echo "</pre>";
return $query;


}
//////////////////////////////////////////////////////////////
///////                                                ///////
///////      Add ALL Possible Shortcode               ///////
///////                                               ///////
/////////////////////////////////////////////////////////////
add_shortcode('displaylist','displayListing');



////////////////////////////////////////////////////////////////
////Actions at deactivation of Plugin                  /////////
////////////////////////////////////////////////////////////////

// register_deactivation_hook(__FILE__, 'my_deactivation');

// function my_deactivation(){
//     global $wpdb;
// 	wp_clear_scheduled_hook('my_hourly_event');
	
// 	$sql="DROP TABLE IF EXISTs`{$wpdb->base_prefix}properties_2;";
// 	$wpdb->query($sql);
//     rmdir(ABSPATH.'/wp-content/uploads/propertyimages');
//     $sql="DROP TABLE IF EXISTs`{$wpdb->base_prefix}AgentDetails;";
// 	$wpdb->query($sql);
   

// }