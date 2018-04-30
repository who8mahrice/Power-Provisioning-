	
	$(document).ready(function(){
    
    /* Data Insert Starts Here */
    
    $(document).on('submit', '#myForm', function() {
      
       $.post("power_product_functions.php", $(this).serialize())
        .done(function(data){
            $("#dis").fadeOut();
            $("#dis").fadeIn('slow', function(){
                $("#dis").html('<div class="alert alert-info">'+data+'</div>');
                $("#myForm")[0].reset();
             });    
         });   
         return false;
    });
    /* Data Insert Ends Here */


});


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

     $(document).ready(function(){
        var $cName = $('#customerName');
    $('#customerLocation').change(function(){
        if(!$(this).val() )
             
            $('#gui').fadeOut('slow');
        else{
            $('#gui').fadeIn('slow');
            document.getElementById("primaryCid").value = $cName.val();
            document.getElementById("primaryLocation").value = $(this).val();
        }
            


    });
});


     /* If customerName value is empty, hide main */
    $(document).ready(function(){
    $('#customerName').change(function(){
        if(!$(this).val() )             
            $('#gui').fadeOut('slow');
    });
});




	// Primary RPP and Panel
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


	// Primary PowerType and PhaseLetters
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


	// Secondary RPP and Panel
	$(function(){
	var $cat = $("#category5"),
	$subcat = $("#category6");
	$cat.on("change",function(){
		var _rel = $(this).val();
		$subcat.find("option").attr("style","");
		$subcat.val("");
		if(!_rel) return $subcat.prop("disabled",true);
		$subcat.find("[rel="+_rel+"]").show();
		$subcat.prop("disabled",false);
		});
	});

	// Secondary PowerType and PhaseLetters
	$(function(){
	var $cat = $("#category7"),
	$subcat = $("#category8");
	$cat.on("change",function(){
		var _rel = $(this).val();
		$subcat.find("option").attr("style","");
		$subcat.val("");
		if(!_rel) return $subcat.prop("disabled",true);
		$subcat.find("[rel="+_rel+"]").show();
		$subcat.prop("disabled",false);
		});
	});



	// Primary Power Check
	$(function(){
	var $cat = $("#category9"),
	$subcat = $("#category10");
	$cat.on("change",function(){
		var _rel = $(this).val();
		$subcat.find("option").attr("style","");
		$subcat.val("");
		if(!_rel) return $subcat.prop("disabled",true);
		$subcat.find("[rel="+_rel+"]").show();
		$subcat.prop("disabled",false);
		});
	});


	// Secondary Power Check
	$(function(){
	var $cat = $("#category11"),
	$subcat = $("#category12");
	$cat.on("change",function(){
		var _rel = $(this).val();
		$subcat.find("option").attr("style","");
		$subcat.val("");
		if(!_rel) return $subcat.prop("disabled",true);
		$subcat.find("[rel="+_rel+"]").show();
		$subcat.prop("disabled",false);
		});
	});

/* for checked boxes
    $(document).ready(function(){
    $('#customerLocation').change(function(){
        if(this.checked)
            $('#main').fadeIn('slow');
        else
            $('#main').fadeOut('slow');

    });
});
*/



