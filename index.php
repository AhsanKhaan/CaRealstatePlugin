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
	//mkdir(ABSPATH.'/wp-content/uploads/propertyimages');
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
        Building BLOB ,
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
// ////////////////////////////////////////////////////////////////
// ///  Redirect as wordpress root URL  instead of plugin URL
// ////////////////////////////////////////////////////////////////
// add_action( 'init', 'wpse9870_init_external' );
// function wpse9870_init_external()
// {
//     global $wp_rewrite;
//     $plugin_url = plugins_url( 'ListingDetail.php', __FILE__ );
//     $plugin_url = substr( $plugin_url, strlen( home_url() ) + 1 );
//     error_log('PLUGIN URL:      '.$plugin_url);
//     // The pattern is prefixed with '^'
//     // The substitution is prefixed with the "home root", at least a '/'
//     // This is equivalent to appending it to `non_wp_rules`
//     $wp_rewrite->add_external_rule( '^http://localhost:1000/wordpress/ListingDetail.php$', $plugin_url );
//     flush_rewrite_rules(); // Update the permalink entries in the database, so the permalink structure needn't be redone every page load

//     //error_log($wp_rewrite->add_external_rule( '^ListingDetail.php/$', $plugin_url ));
// }
function displayListing(){
////////////////////////////////////////////////
///// Register all style sheets and scripts ///
///////////////////////////////////////////////
add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );

function sdt_remove_ver_css_js( $src, $handle ) 
{
    $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!

    if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
        $src = remove_query_arg( 'ver', $src );

    return $src;
}
//error_log(sdt_remove_ver_css_js(plugin_dir_url( __FILE__ ) .'css/bootstrap.min.css','bootstrap.min.css'));
/*For Stylesheets*/
wp_enqueue_style( 'bootstrap.min.css', plugin_dir_url( __FILE__ ) .'css/bootstrap.min.css');
wp_enqueue_style( 'style.css', plugin_dir_url( __FILE__ ) .'css/style.css' );

/*For Scripts*/
wp_enqueue_script( 'jquery-3.2.1.slim.min.js', plugin_dir_url(__FILE__).'js/jquery-3.2.1.slim.min.js', $ver=false, $in_footer=true );
	
wp_enqueue_script( 'popper.min.js', plugin_dir_url(__FILE__).'js/popper.min.js', $ver=false, $in_footer=true );

wp_enqueue_script( 'bootstrap.min.js', plugin_dir_url(__FILE__).'js/bootstrap.min.js', $ver=false, $in_footer=true );

wp_enqueue_script( 'jquery.min.js', plugin_dir_url(__FILE__).'js/jquery.min.js', $ver=false, $in_footer=true );

wp_enqueue_script( 'jquery.twbsPagination.js', plugin_dir_url(__FILE__).'js/jquery.twbsPagination.js', $ver=false, $in_footer=true );

wp_enqueue_script( 'app.js', plugin_dir_url(__FILE__).'js/app.js', $ver=false, $in_footer=true );

/*   For showing listings all data at front end */
echo '<form class="">
<fieldset>
 <legend>Property Search</legend>
   <label for="TransType"></label>
 <select id="TransType">
 <option value="All">All Transaction Type</option>
 <option value="Sale">For Sale</option>
 <option value="Lease">For Lease</option>
 <option value="Rent">For Rent</option>
 <option value="Sale_Rent">For Sale or Rent</option>
</select><br><br>
 <input id="search" type="submit" value="Search">
</fieldset>
</form>';
echo ' <div class="container">   
<div class="wrapper">
<div class="container-pg">

<div class="row">
  <div class="col-sm-12">
    
    <ul id="pagination-demo" class="pagination-sm"></ul>
  </div>
</div>


</div>
</div>


<div class="row md-8" id="card-stack">

</div>';


}
//////////////////////////////////////////////////////////////
///////                                                ///////
///////      Add ALL Possible Shortcode               ///////
///////                                               ///////
/////////////////////////////////////////////////////////////
add_shortcode('Listing','displayListing');



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