$(document).ready(function(){
  init();
  setUserInterface();
 $("#search").click(function(){
    //get all data from for and build query string
    data_collection=$('#property_search').serialize();
    var url="http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/card.php?"+data_collection;

     $.get( url, function(dataset) {
  //    use for destroing old pages
  $('#pagination-demo').twbsPagination('destroy');
   
      var Limit=9;
    var totalPages=Math.ceil(dataset.TotalListing/Limit);
    
    array_chunks=chunkarray(dataset.property,Limit);
    show_chunks(array_chunks[0]);
     
  //$('#pagination-demo-1').empty();
    $('#pagination-demo').twbsPagination({
      totalPages: totalPages,
      visiblePages: 6,
      next: 'Next',
      prev: 'Prev',
      onPageClick: function (event, page) {
          //fetch content and render here
          $("#card-stack").empty(); 
          show_chunks(array_chunks[page-1]); 
         
      }
  });//twbs Pagination
    

    });//get ajax function ends
  });//Search Button Ends click
   
  

  function showdata(dataset){
    $("#card-stack").empty();
    dataset.property.forEach(data => {
     // alert(data["TotalCount"]);
if(data['Size']==undefined){
  var html=` <div class="col-lg-4 ">
  <!-- Card -->
<div class="card booking-card">

<!-- Card image -->
<div class="view overlay">

  
  <a href="http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
    <div class="mask rgba-white-slight"><img class="card-img-top" src="`+data['Photo']+`" alt="Card image cap"></div>
  </a>
</div>

<!-- Card content -->
<div class="card-body">
<div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
  <!-- Title -->
  <h2 class="card-title font-weight-bold"><a>`+data['Price']+`</a></h2>
  <!-- Data -->
  <p class="mb-2">`+data['City']+`,`+data['Province']+`</p>
  <!-- Text -->
  <p class="card-text">
  <span>`+data['Bathroom']+` BathRooms</span>
  <span>`+data['Bedroom']+` BedRooms</span>

  </p>
  <hr class="my-4">
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
<div class="view overlay">

  
  <a href="http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
    <div class="mask rgba-white-slight"><img class="card-img-top" src="`+data['Photo']+`" alt="Card image cap"></div>
  </a>
</div>

<!-- Card content -->
<div class="card-body">
<div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
  <!-- Title -->
  <h2 class="card-title font-weight-bold"><a>`+data['Price']+`</a></h2>
  <!-- Data -->
  <p class="mb-2">`+data['City']+`,`+data['Province']+`</p>
  <!-- Text -->
  <p class="card-text">
  <span>`+data['Bathroom']+` BathRooms</span>
  <span>`+data['Bedroom']+` BedRooms</span>
  <span>`+data['Size']+` </span>

  </p>
  <hr class="my-4">
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
  }//dataset function

  function chunkarray(array,size){
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
  
  
  function show_chunks(dataset){
    $("#card-stack").empty();
    dataset.forEach(data => {

      if(data['Size']==undefined){
        var html=` <div class="col-lg-4 ">
        <!-- Card -->
      <div class="card booking-card">
      
      <!-- Card image -->
      <div class="view overlay">
      
        
        <a href="http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
          <div class="mask rgba-white-slight"><img class="card-img-top" src="`+data['Photo']+`" alt="Card image cap"></div>
        </a>
      </div>
      
      <!-- Card content -->
      <div class="card-body">
      <div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
        <!-- Title -->
        <h2 class="card-title font-weight-bold"><a>`+data['Price']+`</a></h2>
        <!-- Data -->
        <p class="mb-2">`+data['City']+`,`+data['Province']+`</p>
        <!-- Text -->
        <p class="card-text">
        <span>`+data['Bathroom']+` BathRooms</span>
        <span>`+data['Bedroom']+` BedRooms</span>
      
        </p>
        <hr class="my-4">
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
      <div class="view overlay">
      
        
        <a href="http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank">
          <div class="mask rgba-white-slight"><img class="card-img-top" src="`+data['Photo']+`" alt="Card image cap"></div>
        </a>
      </div>
      
      <!-- Card content -->
      <div class="card-body">
      <div class="ribbon ribbon-top-left"><span>`+data['TransactionType']+`</span></div>
        <!-- Title -->
        <h2 class="card-title font-weight-bold"><a>`+data['Price']+`</a></h2>
        <!-- Data -->
        <p class="mb-2">`+data['City']+`,`+data['Province']+`</p>
        <!-- Text -->
        <p class="card-text">
        <span>`+data['Bathroom']+` BathRooms</span>
        <span>`+data['Bedroom']+` BedRooms</span>
        <span>`+data['Size']+` </span>
      
        </p>
        <hr class="my-4">
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
  
  function init(){
    //total number of pages can be shown from here
    //uses for displaying total pages
  $("#LastPage").text($('#TotalCount').text()/10);
  $.get("http://localhost/wordpress/wordpress/wp-content/plugins/crea/card.php?Page=1", function(data, status){
     
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
        $.get("http://localhost/wordpress/wordpress/wp-content/plugins/crea/card.php?Page="+page, function(data, status){
        
          //var dataset=JSON.parse(data);
          if(data==null){
            $('#card-stack').text('No Listing was found');
          }else{
            showdata(data);
          }
          
          
          });
       
    }
});//twbs Pagination
    });
  }//init ends
  
function setUserInterface(){
  
}



});//document.ready