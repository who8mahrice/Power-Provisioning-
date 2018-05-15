// START jQuery for query_functions.php
// ***NOTE*** -2 is for the sessions when you are done editing sID and going back to query that will use customerNameSession and customerLocationSession 
$(document).ready(function(){

	/* Data Delete Starts Here */
	$(".delete-link").click(function()
	{
		var sID = $(this).attr("id");
		console.log(sID);
		var del_sID = sID;
		var parent = $(this).parent("td").parent("tr");
		
		if(confirm('R U Sure to DELETE sID: ' +del_sID))
		{
		
			$.post('delete.php', {'del_sID':del_sID}, function(data)
			{
				parent.fadeOut('slow');
			});	
		
		}
		
		return false;
	});
	/* Data Delete Ends Here */

	/* Get Edit ID  */
	$(".edit-link").click(function()
	{

		var sID = $(this).attr("id");
		var edit_sID = sID;
		console.log("Going to edit");
		console.log(edit_sID);
		
		if(confirm('R U Sure to EDIT sID: ' +edit_sID))
		{
		
			$(".content-loader").fadeOut('slow', function()
			 {
				$(".content-loader").fadeIn('slow');
				$(".content-loader").load('edit.php?edit_id='+edit_sID);
				
				//$("#ouput").fadeIn('slow');
				//$("#ouput").load('edit?edit_id='+edit_sID);
				//$("#btn-add").hide();
				//$("#btn-view").show();
			});
		
		} // end of if

		return false;
	});
	/* Get Edit ID  */

	/* Update Record --Can be deleted, DOUBLE CHECK  */
	$(document).on('submit', '#emp-UpdateForm', function() {
	 
	   $.post("update.php", $(this).serialize())
        .done(function(data){
			$("#dis").fadeOut();
			$("#dis").fadeIn('slow', function(){
			     $("#dis").html('<div class="alert alert-info">'+data+'</div>');
			     $("#emp-UpdateForm")[0].reset();
				 $("body").fadeOut('slow', function()
				 {
					$("body").fadeOut('slow');
					//window.location.href="index.php";
					window.location.href="query.php";
					
				 });				 
		     });	
		});   
	    return false;
    });
	/* Update Record  --Can be deleted, DOUBLE CHECK */


});
// END jQuery for query_functions.php

// START of JS for query.php
/* START Customer Name and Location values for Primary and Secondary Power */
    $(function(){
    var $cat = $("#customerName"),
    $subcat = $("#customerLocation");
    $cat.on("change",function(){
        var _rel = $(this).val();
        $subcat.find("option").attr("style","");
        $subcat.val("");
        if(!_rel) return $subcat.prop("disabled",true);
        $subcat.find("[rel="+_rel+"]").show();
        $subcat.prop("disabled",false);
        });
    });

    //  -2 
    $(function(){
    var $cat = $("#customerNameSession"),
    $subcat = $("#customerLocationSession");
    $cat.on("change",function(){
        var _rel = $(this).val();
        $subcat.find("option").attr("style","");
        $subcat.val("");
        if(!_rel) return $subcat.prop("disabled",true);
        $subcat.find("[rel="+_rel+"]").show();
        $subcat.prop("disabled",false);
        });
    });


    // Query for customer dropdown menu
     $(document).ready(function(){
        var $cName = $('#customerName');
    $('#customerLocation').change(function(){
        if(!$(this).val())
             
            $('.content-loader').fadeOut('slow');
        else{
            $('#test').fadeIn('slow');
            $('.content-loader').fadeIn('slow');
            var cus = $('#customerName').val();
            var loc = $('#customerLocation').val();
            $.post('query_functions.php', { customer: cus, location: loc}, function(data) {
            	$("#test").html(data);
            	});
        }         
    });
});

     // Query for customer SESSIONs dropdown menu -2 
     $(document).ready(function(){
        var $cName = $('#customerName');
    $('#customerLocationSession').change(function(){
        if(!$(this).val())
             
            $('.content-loader').fadeOut('slow');

        else{
            $('#test').fadeIn('slow');
            $('.content-loader').fadeIn('slow');
            var cusSession = $('#customerNameSession').val();
            var locSession = $('#customerLocationSession').val();
            $.post('query_functions.php', { customer: cusSession, location: locSession}, function(data) {
            	$("#test").html(data);
            	});
        }         
    });
});

     // Query for customer dropdown menu with Session values for customer and location -2
     $(document).ready(function(){
     	var $cName = $('#customerNameSession');
     	var $cLocation = $('#customerLocationSession');
    //$('#customerLocationSession').change(function(){
    	$(window).on("load",function(){
        //if(!$(this).val() )
        if($cLocation.val() == "" )    
        	$('.content-loader').fadeOut('slow');
        else{
            // $('#test').fadeIn('slow');
        	$('.content-loader').fadeIn('slow');

        	var cusSession = $('#customerNameSession').val();
        	var locSession = $('#customerLocationSession').val();
        	$.post('query_functions.php', { customer: cusSession, location: locSession}, function(data) {
        		$("#test").html(data);
        	});
        }         
    });
    });





// END of JS for query.php



     /* If customerName value is empty, hide main */
    $(document).ready(function(){
    $('#customerName').change(function(){
        if(!$(this).val() ){
            $('#test').fadeOut('slow');
        }      
        if ($(this).val() == "-SELECT-"){
            $('#test').fadeOut('slow');
        }       
            
    });
});


    
/* END Customer Name and Location values for Primary and Secondary Power */



/* If customerNameSession value is empty, hide main -2 */
    $(document).ready(function(){
    $('#customerNameSession').change(function(){
        if(!$(this).val() )             
            $('#test').fadeOut('slow');
    });
});




// -2
$(document).ready(function(){
 	var $loc = $("#customerLocationSession");
	var $locval = $loc.val();

	if( $locval != ""){
		$loc.prop("disabled",false); // Set  to true if cat2 has value
	} else {
		console.log("There is no value given to category2");
	}
});	


//new
// $(document).ready(function(){
//     var cid = $("#customerName");
//     cid.change(function(){
//         var val = cid.val();
//         if(val == "-SELECT-"){
//         console.log("Reg -SELECT-");
//         }
//     });
// });

//new
$(document).ready(function(){

    var cid = $("#customerName");
    var val = cid.val();

    cid.change(function(){

        if(val == "-SELECT-"){

        console.log("Reg -SELECT-");

        } else {
            console.log("Not a select");
        }

    });

});


