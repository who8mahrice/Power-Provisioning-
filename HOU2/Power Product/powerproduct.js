
	
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



