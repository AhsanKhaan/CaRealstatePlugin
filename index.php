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
        AlternateURL varchar(400),
        EquipmentType  varchar(100),
        Features varchar(500),
        ListingContractDate  varchar(300),
        LocationDescription varchar(600),
        OwnershipType varchar(300),
        ParkingSpaces varchar(300),
        ParkingSpaceTotal varchar(100),
        Photo BLOB,

        Price DOUBLE ,
        PropertyType varchar(100) ,
        PublicRemarks BLOB,

        RentalEquipmentType varchar(100),
        Structure varchar(100),
        TransactionType varchar(30),
        UtilitiesAvailable varchar(1000),
        WaterFrontType varchar(20),
        ZoningDescription varchar(400),
        ViewType varchar(100),
        MoreInformationLink varchar(200),
        Card  varchar(1000),
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
// add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
// add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );

// function sdt_remove_ver_css_js( $src, $handle ) 
// {
//     $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!

//     if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
//         $src = remove_query_arg( 'ver', $src );

//     return $src;
// }
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

// return '<div class="cont container-fluid">
//         <div class="row">
//           <div class="col col-lg-auto">
//             <div class="container">   
//              <div class="wrapper">
//              <div class="container-pg">
//                 <div class="row">
//                   <div class="col-sm-12">
//                     <ul id="pagination-demo" class="pagination-sm"></ul>
//                     </div>
//                   </div>
//               </div>
//             </div>
            
            
//             <div class="row" id="card-stack">
//             </div>  
//           </div>
//           <div class="col col-lg-3">
//             <form class="">
//             <fieldset>
//             <legend>Property Search</legend>
//               <label for="TransactionType"></label>
//             <select id="TransactionType">
//             <option value="All">All Transaction Type</option>
//             <option value="Sale">For Sale</option>
//             <option value="Lease">For Lease</option>
//             <option value="Rent">For Rent</option>
//             <option value="Sale_Rent">For Sale or Rent</option>
//             </select><br><br>
//             <input id="search" type="submit" value="Search">
//             </fieldset>
//             </form>
//           </div>
//         </div>
//       </div>';
      
      return '<div class="cont">
      <div class="row">
      <div class="col-lg-9">
      <div class="row">
      <div class="col-lg-4 ">
      <!-- Card -->
  <div class="card booking-card">
  
    <!-- Card image -->
    <div class="view overlay">
  
      <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/8-col/img (5).jpg" alt="Card image cap">
      <a href="#!">
        <div class="mask rgba-white-slight"></div>
      </a>
    </div>
  
    <!-- Card content -->
    <div class="card-body">
  <div class="ribbon ribbon-top-left"><span>For Lease</span></div>
      <!-- Title -->
      <h2 class="card-title font-weight-bold"><a>Price</a></h2>
      <!-- Data -->
      <p class="mb-2">Country,Province</p>
      <!-- Text -->
      <p class="card-text">Country</p>
      <hr class="my-4">
      <p class="lead"><strong>Office Location</strong></p>
      <!-- Button -->
      
  
    </div>
  
  </div>
  <!-- Card -->
    </div>
    <div class="col-lg-4 ">
          <!-- Card -->
      <div class="card booking-card">
      
        <!-- Card image -->
        <div class="view overlay">
      
          <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/8-col/img (5).jpg" alt="Card image cap">
          <a href="#!">
            <div class="mask rgba-white-slight"></div>
          </a>
        </div>
      
        <!-- Card content -->
        <div class="card-body">
      <div class="ribbon ribbon-top-left"><span>For Lease</span></div>
          <!-- Title -->
          <h2 class="card-title font-weight-bold"><a>Price</a></h2>
          <!-- Data -->
          <p class="mb-2">Country,Province</p>
          <!-- Text -->
          <p class="card-text">Country</p>
          <hr class="my-4">
          <p class="lead"><strong>Office Location</strong></p>
          <!-- Button -->
          
      
        </div>
      
      </div>
      <!-- Card -->
        </div>
        <div class="col-lg-4 ">
          <!-- Card -->
      <div class="card booking-card">
      
        <!-- Card image -->
        <div class="view overlay">
      
          <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/8-col/img (5).jpg" alt="Card image cap">
          <a href="#!">
            <div class="mask rgba-white-slight"></div>
          </a>
        </div>
      
        <!-- Card content -->
        <div class="card-body">
      <div class="ribbon ribbon-top-left"><span>For Lease</span></div>
          <!-- Title -->
          <h2 class="card-title font-weight-bold"><a>Price</a></h2>
          <!-- Data -->
          <p class="mb-2">Country,Province</p>
          <!-- Text -->
          <p class="card-text">Country</p>
          <hr class="my-4">
          <p class="lead"><strong>Office Location</strong></p>
          <!-- Button -->
          
      
        </div>
      
      </div>
      <!-- Card -->
        </div>
      </div>
      </div><!--ends  col-lg-9-->
      <div col-lg-3>
        <div class="card">
          <div class="card-header">Property Search </div>
          <div class="card-body">
            <div class="form-group">
              <select name="input_property_type" id="input_property_type" class="form-control ">
                <option value="">All Property Types</option>
                <option value="Agriculture">Agriculture</option>
                <option value="Business">Business</option>
                <option value="Hospitality">Hospitality</option>
                <option value="Industrial">Industrial</option>
                <option value="Institutional - Special Purpose">Institutional - Special Purpose</option>
                <option value="Multi-family">Multi-family</option>
                <option value="Office">Office</option>
                <option value="Other">Other</option>
                <option value="Parking">Parking</option>
                <option value="Recreational">Recreational</option>
                <option value="Retail">Retail</option>
                <option value="Single Family">Single Family</option>
                <option value="Vacant Land">Vacant Land</option>
              </select>
            </div>
            <div class="form-group">
              <select name="input_transaction_type" id="input_transaction_type" class="form-control ">
                <option value="">All Transaction Types</option>
                <option value="for lease">For Lease</option>
                <option value="for rent">For Rent</option>
                <option value="for sale">For Sale</option>
                <option value="for sale or rent">For Sale Or Rent</option>
              </select>
              </div>
          </div>
          <div class="card-footer"><button class="btn-search">Search</button></div>
        </div>
      </div>
      </div><!--ends row-->
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