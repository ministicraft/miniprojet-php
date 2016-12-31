
/* Selection Promo */
  //$("#container").hide();

  $("#selectPromo").change(function() {
    var promo = $(this).attr('value');
    console.log(promo);
    $.ajax({
      type: "GET",
      url: "includes/listDoc.php",
      data: "promo="+promo,
      dataType: 'json',
      async: false,
      success: function(data){
        if (data.status==200) {
          
          $("#container").slideUp(400);
          $("#container").html(data.message);
          $("#container").slideDown(1200);
                    
        }
        else {
          alert(data.message);
          console.log(data);
        }           
      },
      error: function(request, error){
        alert("Une erreur est survenue !" + error);
        console.log(request);
      }
    });
  });
