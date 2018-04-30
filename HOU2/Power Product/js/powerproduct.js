    
    $(document).ready(function(){

    
    /* Data Insert Starts Here */
    $(document).on('submit', '#myForm', function() {
        $("#secondaryAdd").hide();
        $("#primaryAdd").hide();
        $("#addAll").show();
      
       $.post("power_product_functions.php", $(this).serialize())
        .done(function(data){
            $("#dis").fadeOut();
            $("#dis").fadeIn('slow', function(){
                $("#dis").html('<div class="alert alert-info">'+data+'</div>');
                $("#myForm")[0].reset();
                $("#primaryPower").show();
                $("#secondaryPower").show();
             });    
         });   
         return false;
    });
});


/* =============== START Form Validation  ===============  */
$(document).ready(function(){
// Still need to add Primary/Secondary validation for the power dropdown menu
// Validates Primary Section
$("#primaryAdd").click(function(e) {
    console.log("primary add button clicked");
  var message = "";
  var primarySid = document.forms["myForm"]["primarySid"].value;
  var primaryRow = document.forms["myForm"]["primaryRow"].value;
  var primaryCab = document.forms["myForm"]["primaryCab"].value;
  var primaryMau = document.forms["myForm"]["primaryMau"].value;
  

  if ( primarySid.length > 6  ) {
    message += "Please fill in Primary sID \r\n";
    //return false;
    }
  if (primaryRow == "") {
    message += "Please fill in Primary Row \r\n";
    //return false;
    }
    if (primaryCab == "") {
        message +="Please fill in Primary Cab \r\n";
        //return false;
    } 
    if (primaryMau == "") {
        message += "Please fill in Primary MAU \r\n";
        //return false;
    } 

    if (message != "") {
        alert(message);
        e.preventDefault();
    }
   
    });

  // Validates Secondary Section
    $("#secondaryAdd").click(function(e) {
    console.log("secondary add button clicked");
  var message = "";
  var secondarySid = document.forms["myForm"]["secondarySid"].value;
  var secondaryRow = document.forms["myForm"]["secondaryRow"].value;
  var secondaryCab = document.forms["myForm"]["secondaryCab"].value;
  var secondaryMau = document.forms["myForm"]["secondaryMau"].value;
  

  if ( secondarySid.length > 6  ) {
    message += "Please fill in Secondary sID \r\n";
    //return false;
    }
  if (secondaryRow == "") {
    message += "Please fill in Secondary Row \r\n";
    //return false;
    }
    if (secondaryCab == "") {
        message +="Please fill in Secondary Cab \r\n";
        //return false;
    } 
    if (secondaryMau == "") {
        message += "Please fill in Secondary MAU \r\n";
        //return false;
    } 

    if (message != "") {
        alert(message);
        e.preventDefault();
    }
   
    });

    // Validates Primary And Secondary Section
    $("#addAll").click(function(e) {
    console.log("Add All button clicked");
  var message = "";
  var primarySid = document.forms["myForm"]["primarySid"].value;
  var primaryRow = document.forms["myForm"]["primaryRow"].value;
  var primaryCab = document.forms["myForm"]["primaryCab"].value;
  var primaryMau = document.forms["myForm"]["primaryMau"].value;
  var secondarySid = document.forms["myForm"]["secondarySid"].value;
  var secondaryRow = document.forms["myForm"]["secondaryRow"].value;
  var secondaryCab = document.forms["myForm"]["secondaryCab"].value;
  var secondaryMau = document.forms["myForm"]["secondaryMau"].value;
  
  if (primarySid.length > 6  ) {
    message += "Please fill in Primary sID! \r\n";
    //return false;
    }
  if (primaryRow == "") {
    message += "Please fill in Primary Row \r\n";
    //return false;
    }
    if (primaryCab == "") {
        message +="Please fill in Primary Cab \r\n";
        //return false;
    } 
    if (primaryMau == "") {
        message += "Please fill in Primary MAU \r\n";
        //return false;
    } 

  if ( secondarySid.length > 6  ) {
    message += "Please fill in Secondary sID \r\n";
    //return false;
    }
  if (secondaryRow == "") {
    message += "Please fill in Secondary Row \r\n";
    //return false;
    }
    if (secondaryCab == "") {
        message +="Please fill in Secondary Cab \r\n";
        //return false;
    } 
    if (secondaryMau == "") {
        message += "Please fill in Secondary MAU \r\n";
        //return false;
    } 

    if (message != "") {
        alert(message);
        e.preventDefault();
    }
   
    });
});
    /* =============== END Form Validation  ===============  */

    
  
    /* =============== START show and hide check boxes for Primary and Secondary Power =============== */
    $(document).ready(function() {

        $("#primaryOnly").click(function() {

            if($("#primaryOnly:checked" === true)){
                console.log("Primary is checked");
            }
            else if($("#primaryOnly:checked" === false)){
                console.log("Primary is NOT checked");
            }

            if($('#primaryOnly:checked').length) {
              /* alert('primary only checks out'); */
                //$("#primaryAdd").prop("disabled",false);
                $(".secondaryPower").hide();
                $("#primaryAdd").show();

                // Remove the requireds from secondary drop down menus
                
                $("#category5").removeAttr("required");
                $("#category6").removeAttr("required");
                $("#category7").removeAttr("required");
                $("#category8").removeAttr("required");
                //$("#primaryOnly").prop('checked', false);
                

            } else {
                $(".secondaryPower").show();
                //$("#primaryAdd").prop("disabled",true);
                $("#primaryAdd").hide();
            }
        });

        $("#secondaryOnly").click(function() {

            if($("#secondaryOnly:checked" === true)){
                console.log("Secondary is checked");
            }
            else if ($("#secondaryOnly:checked" === false))  {
                console.log("Secondary is NOT checked");
            }

            if($('#secondaryOnly:checked').length) {
                 /* alert('secondary only checks out'); */
                $("#primaryAdd").hide();
                $("#addAll").hide();
                $("#primaryPower").hide();
                //$("#secondaryAdd").prop("disabled",false);
                $("#secondaryAdd").show();

                /* remove the requireds from Primary drop down menus */
                
                $("#category1").removeAttr("required");
                $("#category2").removeAttr("required");
                $("#category3").removeAttr("required");
                $("#category4").removeAttr("required");
                
                //$("#").removeAttr("required");

            } else {
                $("#primaryPower").show();
               // $("#secondaryAdd").prop("disabled",true);
                $("#secondaryAdd").hide();
                $("#addAll").show();
            }
        });
    });
    /* =============== END show and hide check boxes for Primary and Secondary Power =============== */


/*
    $('#primaryRow').on('change', function(e) {
    var checkbox = document.getElementById("primaryOnly").checked;
    if (e.target.name == "primaryRow"){
        var form = $('#myForm'),
        $primaryRow = form.find('#primaryRow'),
         $secondaryRow = form.find('#secondaryRow'),
          $primaryMau = form.find('#primaryMau'),
           $secondaryMau = form.find('#secondaryMau');
           //message = "";

        if (checkbox == false){
            console.log("In add all");
            if (primaryRow != ""){
                primaryRowVal = $primaryRow.val();
                secondaryRowVal = $secondaryRow.val();
                secondaryRowVal = primaryRowVal;
                $('#secondaryRow').val(secondaryRowVal);
                console.log(primaryRowVal);
                console.log(secondaryRowVal);
                //secondaryRow = primaryRow;
            }
        } else if (checkbox == true) {
            console.log("Primary only");
        }
    }
});
*/
    /* =============== START Auto fills Row, Cab, MAU of Seoncdary values with Primary values =============== */

    // These jQueries have multiple events: change and click
    $('#primaryRow').on('change click', function(e) {
    var checkbox = document.getElementById("primaryOnly").checked;
    if (e.target.name == "primaryRow"){
        if (checkbox == false){
            console.log("Adding Row to Primary and Secondary");
            var form = $('#myForm'),
            $primaryRow = form.find('#primaryRow'),
            $secondaryRow = form.find('#secondaryRow'),
            $primaryMau = form.find('#primaryMau'),
            $secondaryMau = form.find('#secondaryMau');
            if (primaryRow != ""){
                primaryRowVal = $primaryRow.val();
                secondaryRowVal = $secondaryRow.val();
                secondaryRowVal = primaryRowVal;
                $('#secondaryRow').val(secondaryRowVal);
                console.log(primaryRowVal);
                console.log(secondaryRowVal);
                //secondaryRow = primaryRow;
            }
        } else if (checkbox == true) {
            console.log("PrimaryRow only");
            $('#secondaryRow').val("");
        }
    }
});

    $('#primaryCab').on('change click', function(e) {
    var checkbox = document.getElementById("primaryOnly").checked;
    if (e.target.name == "primaryCab"){
        if (checkbox == false){
            console.log("Adding Cab to Primary and Secondary");
            var form = $('#myForm'),
            $primaryCab = form.find('#primaryCab'),
            $secondaryCab = form.find('#secondaryCab'),
            $primaryMau = form.find('#primaryMau'),
            $secondaryMau = form.find('#secondaryMau');
            if (primaryCab != ""){
                primaryCabVal = $primaryCab.val();
                secondaryCabVal = $secondaryCab.val();
                secondaryCabVal = primaryCabVal;
                $('#secondaryCab').val(secondaryCabVal);
                console.log(primaryCabVal);
                console.log(secondaryCabVal);
                //secondaryRow = primaryRow;
            }
        } else if (checkbox == true) {
            console.log("PrimaryCab only");
            $('#secondaryCab').val("");
        }
    }
});
   // This MAU only assigns pairs that are not ADDITIONAL PAIRS
   $('#primaryMau').on('change click', function(e) {
    var checkbox = document.getElementById("primaryOnly").checked;
    if(e.target.name == "primaryMau"){
        if (checkbox == false){
            console.log("Adding MAU to Primary and Secondary");
            var form = $('#myForm'),
            $primaryRow = form.find('#primaryRow'),
            $secondaryRow = form.find('#secondaryRow'),
            $primaryMau = form.find('#primaryMau'),
            $secondaryMau = form.find('#secondaryMau');
            if (primaryMau != ""){
               primaryMauVal = $primaryMau.val();
                secondaryMauVal = $secondaryMau.val();
                secondaryMauVal =  primaryMauVal;
                $('#secondaryMau').val(secondaryMauVal);
                console.log(primaryMauVal);
                console.log(secondaryMauVal);
                //secondaryRow = primaryRow;
            }
        } else if (checkbox == true) {
            console.log("Primary only");
            $('#secondaryMau').val("");
        }
     }

    });
    /* checks if MAU was click for another ADDITIONAL new pair in cab  --- need to do this still */

    /* =============== END Auto fills Row, Cab, MAU of Seoncdary values with Primary values =============== */
    


    /* =============== START Customer Name and Customer Location Dropdown Menu =============== */
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
            document.getElementById("secondaryCid").value = $cName.val();
            document.getElementById("secondaryLocation").value = $(this).val();
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
    /* =============== END Customer Name and Customer Location Dropdown Menu =============== */
    



    /* =============== START  Primary and Secondary Power Dropdown Menu =============== */
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
/* =============== END Primary and Secondary Power Dropdown Menu =============== */











