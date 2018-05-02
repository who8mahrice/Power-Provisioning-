$(document).ready(function(){
/* Get Edit ID  */
	$(".edit-link").click(function()
	{
		var id = $(this).attr("id");
		var edit_id = id;
		if(confirm('Sure to Edit ID no = ' +edit_id))
		{
			$(".content-loader").fadeOut('slow', function()
			 {
				$(".content-loader").fadeIn('slow');
				// $(".content-loader").load('edit_form.php?edit_id='+edit_id); // works
				$(".content-loader").load('edit.php?edit_id='+edit_id);
				//$("#btn-add").hide();
				//$("#btn-view").show();
			});
		}
		return false;
	});
	/* Get Edit ID  */


/* Update Record  */
	$(document).on('submit', '#emp-UpdateForm', function() {
	 
	   $.post("update.php", $(this).serialize())
        .done(function(data){
			$("#dis").fadeOut();
			$("#dis").fadeIn('slow', function(){
			     $("#dis").html('<div class="alert alert-info">'+data+'</div>');
			     $("#emp-UpdateForm")[0].reset();
				  // $("body").fadeOut('slow', function()
				  $("dis").fadeOut('slow', function()
				  {
					// $("body").fadeOut('slow');
					$("dis").fadeOut('slow');
					window.location.href="query.php";
				  });				 
		     });	
		});   
	    //return false;
    });
	/* Update Record  */

});


/* Cancel button */
$(document).ready(function(){
	$("#btn-cancel").click(function(){ 
		$("#test").fadeIn('slow', function(){ 
			$("#test").fadeOut('slow', function()
			{
					// $("body").fadeOut('slow');
					$("#test").fadeOut('slow');
					window.location.href="query.php";
				});				 
		});
	});
});

/* =============== START  Primary and Secondary Power Dropdown Menu =============== */
   
    // Update RPP and Panel
    $(function(){
    var $cat = $("#category1"),
    $subcat = $("#category2");
    $cat.on("change",function(){
        var _rel = $(this).val();
        $subcat.find("option").attr("style","");
        $subcat.val("");
        if(!_rel) return $subcat.prop("disabled",true);
        $subcat.find("[rel="+_rel+"]").show();
        $subcat.prop("disabled",false);
        });
    });

    // Update PowerType and PhaseLetters
    $(function(){
    var $cat = $("#category3"),
    $subcat = $("#category4");
    $cat.on("change",function(){
        var _rel = $(this).val();
        $subcat.find("option").attr("style","");
        $subcat.val("");
        if(!_rel) return $subcat.prop("disabled",true);
        $subcat.find("[rel="+_rel+"]").show();
        $subcat.prop("disabled",false);
        });
    });

/* =============== END  Primary and Secondary Power Dropdown Menu =============== */

// $(document).ready(function(){
//         //var $cat4 = $('#category4');
//         var $cat1 = document.getElementById('#category2').rel();
//          //document.getElementById("category3").value = $cat4.rel();
//          console.log($cat1);   
 
           

//     });

/* =============== START JS to assign "Panel Name section in Edit form" ***NOT USED**  =============== */
$(document).ready(function(){
	var $hiddenRpp = $("#rpp");
	var $hiddenRppVal = $hiddenRpp.val();
	var $cat2 = $("#category2");
	var $cat2val = $cat2.val();
	 $hiddenRppVal = $cat2.find('option:contains(' + $cat2val + ')').attr('rel');
	
	var $catRel = $cat2.find('option:contains(' + $cat2val + ')').attr('rel');
	var $rel = $cat2.find('option:selected').attr('rel');

	// var $rel = $cat2.find('option:selected').attr('rel'); // works for getting value of rel from val()
	
	
	console.log("-----------");
	console.log($rel);   
	console.log($cat2val);   
});
/* =============== END JS to assign "Panel Name section in Edit form"  ***NOT USED**   =============== */


/* =============== START [SEE FIX1 in workflowy] ***TEMP FIX*** for making category[24] disabled to be false (to show true if only cat[24] has values) =============== */
// $(document).ready(function(){
//  	var $cat2 = $("#category2");
// 	var $cat2val = $cat2.val();

// 	if( $cat2val != ""){
// 		$cat2.prop("disabled",false); // Set  to true if cat2 has value
// 	} else {
// 		console.log("There is no value given to category2");
// 	}

// 	var $cat4 = $("#category4");
// 	var $cat4val = $cat4.val();

// 	if( $cat4val != ""){
// 		$cat4.prop("disabled",false);
// 	} else {
// 		console.log("There is no value given to category4");
// 	}


// });	
/* =============== END [SEE FIX1 in workflowy] ***TEMP FIX*** for making category[24] disabled to be false (to show true if only cat[24] has values) =============== */


$(document).ready(function(){
	// var mau = $("#editMau");
	var mau = $("#editMau");
	var previousMauVal = mau.val();
		$('#editMau').change(function(){
		var x = $("#editMau");
		var xVal = x.val();
		if(previousMauVal != xVal){
			console.log("Mau are different " + previousMauVal + " and " + xVal);
		} else{
			console.log("Maus are the same");
		}
	});
});




//--test phase
$(document).ready(function(){
 	
	//var $panelcat2Val = $panelcat2.val();

	$("#category2").change(function(){
		var $panelcat2 = $('#category2').val();
        $.post('phases_left_message.php', { panel: $panelcat2}, function(data) {
            	$("#phases_here").html(data);
            });
    });
});	
