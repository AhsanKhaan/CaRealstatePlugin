$(document).ready(function(){
  //url = new URL(window.location.href);
  var baseURL="https://crea.bmsastech.com/";
  var SiteURL="http://localhost/wordpress/";

  $('html, body').animate({
	        scrollTop: $('#property_search').offset().top
      }, 200);
       
  init(baseURL);
  //setUserInterface();
 $("#search").click(function(){
    //get all data from for and build query string
    data_collection=$('#property_search').serialize();
    var url=baseURL+"card.php?"+data_collection;
    window.location.href+="?"+data_collection;
    display_data_with_url(url);
  });//Search Button Ends click
   
function display_data_with_url(url){

  $.get( url, function(dataset) {
    var dataset = JSON.parse(dataset);
//    use for destroing old pages
$('#pagination-demo').twbsPagination('destroy');

   var Limit=12;
 var totalPages=Math.ceil(dataset.TotalListing/Limit);
 if(dataset.TotalListing<=Limit){
   showdata(dataset,SiteURL);
 }else if(!parseInt(totalPages)){
   //console.log("Else if"+totalPages);
   $("#card-stack").empty();
   $("#card-stack").html("<h2>No Record Found</h2>");
 }else{
   console.log("Hello World"+totalPages);
   array_chunks=chunkarray(dataset.property,Limit);
   show_chunks(array_chunks[0],baseURL);
   
     //$('#pagination-demo-1').empty();
 $('#pagination-demo').twbsPagination({
   totalPages: totalPages,
   visiblePages: 6,
   next: 'Next',
   prev: 'Prev',
   onPageClick: function (event, page) {
       //fetch content and render here
       $("#card-stack").empty(); 
       show_chunks(array_chunks[page-1],baseURL); 
      
   }
});//twbs Pagination

 }

  
 

 });//get ajax function ends
}  



  
  function showdata(dataset,SiteURL){
    $("#card-stack").empty();
    dataset.property.forEach(data => {
     // alert(data["TotalCount"]);
if(data['Size']==undefined){
  var html=` <div class="col-lg-3 ">
  <!-- Card -->
<div class="card booking-card">

<!-- Card image -->
<div class="view overlay zoom-effect-container">

  
  <a href="`+SiteURL+`/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
    <div class="mask rgba-white-slight image-card">
    <img class="card-img-top img-fluid" src="`+data['Photo']+`" alt="Card image cap"></div>
  </a>
</div>

<!-- Card content -->
<div class="card-body">
<div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
  <!-- Title -->
  <h2 class="card-title font-weight-bold price">$`+numberWithCommas(data['Price'])+`</h2>
  <!-- Data -->
  <p class="mb-2 city-province">`+data['City']+`,`+data['Province']+`</p>
  <!-- Text -->
  <p class="card-text">
  <span class="chips">`+data['Bathroom']+` BathRooms</span>
  <span class="chips">`+data['Bedroom']+` BedRooms</span>

  </p>
  
  <p class="lead"><strong>`+data['Listing Office']+`</strong></p>
  <!-- Button -->
  

</div>

</div>
<!-- Card -->
</div>`;
}else if(data['Size']==""){
  var html=` <div class="col-lg-3 ">
  <!-- Card -->
<div class="card booking-card">

<!-- Card image -->
<div class="view overlay zoom-effect-container">

  
  <a href="`+SiteURL+`/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
    <div class="mask rgba-white-slight image-card">
    <img class="card-img-top img-fluid" src="`+data['Photo']+`" alt="Card image cap"></div>
  </a>
</div>

<!-- Card content -->
<div class="card-body">
<div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
  <!-- Title -->
  <h2 class="card-title font-weight-bold price">$`+numberWithCommas(data['Price'])+`</h2>
  <!-- Data -->
  <p class="mb-2 city-province">`+data['City']+`,`+data['Province']+`</p>
  <!-- Text -->
  <p class="card-text">
  <span class="chips">`+data['Bathroom']+` BathRooms</span>
  <span class="chips">`+data['Bedroom']+` BedRooms</span>

  </p>
 
  <p class="lead"><strong>`+data['Listing Office']+`</strong></p>
  <!-- Button -->
  

</div>

</div>
<!-- Card -->
</div>`;
}else{
  var html=` <div class="col-lg-3 ">
  <!-- Card -->
<div class="card booking-card">

<!-- Card image -->
<div class="view overlay zoom-effect-container">

  
  <a href="`+SiteURL+`/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
    <div class="mask rgba-white-slight image-card">
    <img class="card-img-top img-fluid" src="`+data['Photo']+`" alt="Card image cap"></div>
  </a>
</div>

<!-- Card content -->
<div class="card-body">
<div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
  <!-- Title -->
  <h2 class="card-title font-weight-bold price">$`+numberWithCommas(data['Price'])+`</h2>
  <!-- Data -->
  <p class="mb-2 city-province">`+data['City']+`,`+data['Province']+`</p>
  <!-- Text -->
  <p class="card-text">
  <span class="chips">`+data['Bathroom']+` BathRooms</span>
  <span class="chips">`+data['Bedroom']+` BedRooms</span>
  <span class="chips">`+data['Size']+` </span>

  </p>
 
  <p class="lead"><strong>`+data['Listing Office']+`</strong></p>
  <!-- Button -->
  

</div>

</div>
<!-- Card -->
</div>`;
}



    //alert(html);
     $("#card-stack").append(html);
     $("html, body").animate({ scrollTop: 0 },10);
    });
  }//dataset function

  function chunkarray(array,size){
      console.log(array);
    result=[];
    var begin;
    var end=size;

    while(end<=array.length){
      if(size==array.length){
        result.push(array.slice(begin,array.length));
        break;
      }else if(end+size>array.length){
        begin=end;
        end=array.length;
        result.push(array.slice(begin,end));
        break;
      }else{
        begin=(begin===undefined)?0:end;
        end=begin+size;
        result.push(array.slice(begin,end));
      }
      

    }
    //begin=end;
    //end=array.length;
    //result.push(array.slice(begin,end));
    return result;
  }
  
  
  function show_chunks(dataset,baseURL){
    $("#card-stack").empty();
    dataset.forEach(data => {

      if(data['Size']==undefined){
        var html=` <div class="col-lg-4 ">
        <!-- Card -->
      <div class="card booking-card">
      
      <!-- Card image -->
      <div class="view overlay zoom-effect-container">
      
        
        <a href="`+SiteURL+`/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
          <div class="mask rgba-white-slight image-card">
          <img class="card-img-top img-fluid" src="`+data['Photo']+`" alt="Card image cap"></div>
        </a>
      </div>
      
      <!-- Card content -->
      <div class="card-body">
      <div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
        <!-- Title -->
        <h2 class="card-title font-weight-bold price">`+numberWithCommas(data['Price'])+`</h2>
        <!-- Data -->
        <p class="mb-2 city-province">`+data['City']+`,`+data['Province']+`</p>
        <!-- Text -->
        <p class="card-text">
        <span class="chips">`+data['Bathroom']+` BathRooms</span>
        <span class="chips">`+data['Bedroom']+` BedRooms</span>
      
        </p>
        
        <p class="lead"><strong>`+data['Listing Office']+`</strong></p>
        <!-- Button -->
        
      
      </div>
      
      </div>
      <!-- Card -->
      </div>`;
      }else if(data['Size']==""){
        var html=` <div class="col-lg-4 ">
        <!-- Card -->
      <div class="card booking-card">
      
      <!-- Card image -->
      <div class="view overlay zoom-effect-container">
      
        
        <a href="`+SiteURL+`/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
          <div class="mask rgba-white-slight image-card">
          <img class="card-img-top img-fluid" src="`+data['Photo']+`" alt="Card image cap"></div>
        </a>
      </div>
      
      <!-- Card content -->
      <div class="card-body">
      <div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
        <!-- Title -->
        <h2 class="card-title font-weight-bold price">$`+numberWithCommas(data['Price'])+`</h2>
        <!-- Data -->
        <p class="mb-2 city-province">`+data['City']+`,`+data['Province']+`</p>
        <!-- Text -->
        <p class="card-text">
        <span class="chips">`+data['Bathroom']+` BathRooms</span>
        <span class="chips">`+data['Bedroom']+` BedRooms</span>
      
        </p>
        
        <p class="lead"><strong>`+data['Listing Office']+`</strong></p>
        <!-- Button -->
        
      
      </div>
      
      </div>
      <!-- Card -->
      </div>`;
      }else{
        var html=` <div class="col-lg-4 ">
        <!-- Card -->
      <div class="card booking-card">
      
      <!-- Card image -->
      <div class="view overlay zoom-effect-container">
      
        
        <a href="`+SiteURL+`/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
          <div class="mask rgba-white-slight image-card">
          <img class="card-img-top img-fluid" src="`+data['Photo']+`" alt="Card image cap"></div>
        </a>
      </div>
      
      <!-- Card content -->
      <div class="card-body">
      <div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
        <!-- Title -->
        <h2 class="card-title font-weight-bold price">$`+numberWithCommas(data['Price'])+`</h2>
        <!-- Data -->
        <p class="mb-2 city-province">`+data['City']+`,`+data['Province']+`</p>
        <!-- Text -->
        <p class="card-text">
        <span class="chips">`+data['Bathroom']+` BathRooms</span>
        <span class="chips">`+data['Bedroom']+` BedRooms</span>
        <span class="chips">`+data['Size']+` </span>
      
        </p>
        
        <p class="lead"><strong>`+data['Listing Office']+`</strong></p>
        <!-- Button -->
        
      
      </div>
      
      </div>
      <!-- Card -->
      </div>`;
      }


    //alert(html);
     $("#card-stack").append(html);
    });
  }
  
  function init(baseURL){
  
    if(window.location.search!=""){
      var url=baseURL+"card.php"+window.location.search;
      display_data_with_url(url);
   }else{
          //total number of pages can be shown from here
    //uses for displaying total pages
  $("#LastPage").text($('#TotalCount').text()/10);
  $.get(baseURL+"card.php?Page=1", function(data, status){
       var data = JSON.parse(data);
       console.log(data.property);
       console.log(status);
       
    //var dataset=JSON.parse(data);
    //Setting the text on UI
    //Set total Listing On UI
    $("#TotalCount").text(data["TotalCount"]);

   //Set Lsiting on UI
   //showdata(data);
   //showdata(dataset);
   //Use for calculating number of pages on UI
   var Pages=data["TotalCount"];
    //Set last Page to the UI
    $("#LastPage").text(Pages);   
   $('#pagination-demo').twbsPagination({
    totalPages:  Pages,
    visiblePages: 6,
    next: 'Next',
    prev: 'Prev',
    onPageClick: function (event, page) {
        //fetch content and render here
        $("#card-stack").empty();  
        $.get(baseURL+"card.php?Page="+page, function(data, status){
      
          //var dataset=JSON.parse(data);
          if(data==null){
            $('#card-stack').text('No Listing was found');
          }else{
            var data = JSON.parse(data);
            showdata(data,baseURL);
          }
          
          
          });
       
    }
});//twbs Pagination
    });
   
  }//else ends
    

  }//init ends


function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
});//document.ready
