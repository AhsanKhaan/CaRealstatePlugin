$(document).ready(function(){
  init();

$(".btn").click(function(){
 
  });//btn click
   
  

  function showdata(dataset){
    dataset.property.forEach(data => {
     // alert(data["TotalCount"]);
      var html=`
      <div class="col-md-4">
    <div class="card" >
        <h1>`+data['TransactionType']+`</h1>
        <h4>ID#`+data['ID']+`</h4>
        <a href="http://localhost:1000/wordpress/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank"><img class="card-img-top" src="`+data['Photo']+`" alt="Card image"></a>
        <div class="card-body">
          <h3 style="text-color:green;">PRICE:$`+data['Price']+`</h3>
          <a href="http://localhost:1000/wordpress/wp-content/plugins/crea/ListingDetail.php?ID=`+data['ID']+`" target="_blank"><h4 class="card-title">`+data['Address']+`</h4></a>
          <p class="lead mb-2"><strong>`+data['City']+`,`+data['Province']+`</strong></p>
          <ul class="list-unstyled list-inline d-flex justify-content-between mb-0">
        
          <li class="list-inline-item mr-0">
          <div class="chip mr-0">`+data['Bedroom']+` BedRooms</div>
          </li>

          <li class="list-inline-item mr-0">
          <div class="chip mr-0">`+data['Bathroom']+` BathRooms</div>
          </li>
        <li class="list-inline-item mr-0">
          <div class="chip deep-purple white-text mr-0">`+data['Size']+` Sqft</div>
          </li>
        

        </ul>
  
          
        </div>
        <div class="card-footer"><i>`+data['Listing Office']+`</i></div>
      
    </div>
    </div>
    `;


    //alert(html);
     $("#card-stack").append(html);
    });
  }//dataset function

  function init(){
    //total number of pages can be shown from here
    //uses for displaying total pages
  $("#LastPage").text($('#TotalCount').text()/10);
  $.get("http://localhost:1000/wordpress/wp-content/plugins/crea/card.php?Page=1", function(data, status){
     
    var dataset=JSON.parse(data);
    //Setting the text on UI
    //Set total Listing On UI
    $("#TotalCount").text(dataset["TotalCount"]);

   //Set Lsiting on UI
   showdata(dataset);
   //Use for calculating number of pages on UI
   var Pages=dataset["TotalCount"];
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
        $.get("http://localhost:1000/wordpress/wp-content/plugins/crea/card.php?Page="+page, function(data, status){
           
          var dataset=JSON.parse(data);
          
         showdata(dataset);
          
          });
       
    }
});
    });
  }//init ends
  




});//document.ready