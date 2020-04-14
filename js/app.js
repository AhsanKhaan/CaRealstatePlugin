$(document).ready(function(){
  init();
  setUserInterface();
 $("#search").click(function(){
    //var PropertyType_selected=$('#PropertyType option:selected').text()
    //var TransactionType_selected=$('#TransactionType option:selected').text();
    //get all data from for and build query string
    data_collection=$('#property_search').serialize();
    //window.location.href="http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/card.php?Type="+item_selected;
    var url="http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/card.php?"+data_collection;
    $.get(url,function(data,status){
      if(data==null){

      }else{
        showdata(data);
      }
      var d=data;
      //console.log();
        
    });
  });//Search Button Ends click
   
  

  function showdata(dataset){
    dataset.property.forEach(data => {
     // alert(data["TotalCount"]);
    //   var html=`
    //   <div class="col-md-4">
    // <div class="card" >
    //     <h1>`+data['TransactionType']+`</h1>
    //     <h4>ID#`+data['ID']+`</h4>
    //     <a href="http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank"><img class="card-img-top" src="`+data['Photo']+`" alt="Card image"></a>
    //     <div class="card-body">
    //       <h3 style="text-color:green;">PRICE:$`+data['Price']+`</h3>
    //       <a href="http://localhost:80/wordpress/wordpress/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank"><h4 class="card-title">`+data['Address']+`</h4></a>
    //       <p class="lead mb-2"><strong>`+data['City']+`,`+data['Province']+`</strong></p>
    //       <ul class="list-unstyled list-inline d-flex justify-content-between mb-0">
        
    //       <li class="list-inline-item mr-0">
    //       <div class="chip mr-0">`+data['Bedroom']+` BedRooms</div>
    //       </li>

    //       <li class="list-inline-item mr-0">
    //       <div class="chip mr-0">`+data['Bathroom']+` BathRooms</div>
    //       </li>
    //     <li class="list-inline-item mr-0">
    //       <div class="chip deep-purple white-text mr-0">`+data['Size']+` Sqft</div>
    //       </li>
        

    //     </ul>
  
          
    //     </div>
    //     <div class="card-footer"><i>`+data['Listing Office']+`</i></div>
      
    // </div>
    // </div>
    // `;
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
    <span>`+data['Size']+` sqft</span>

    </p>
    <hr class="my-4">
    <p class="lead"><strong>`+data['Listing Office']+`</strong></p>
    <!-- Button -->
    

  </div>

</div>
<!-- Card -->
  </div>`;


    //alert(html);
     $("#card-stack").append(html);
    });
  }//dataset function

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
   showdata(data);
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
          
        // showdata(dataset);
          
          });
       
    }
});
    });
  }//init ends
  
function setUserInterface(){
  
}



});//document.ready