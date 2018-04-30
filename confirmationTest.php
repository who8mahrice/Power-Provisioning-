<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 



</head>
<body>

<!-- Button confirmation Does NOTHING-->
  <a class="btn btn-default" data-toggle="confirmation">Confirmation</a>


<!-- Button confirmation Link to page -->
<a class="btn btn-large btn-primary" data-toggle="confirmation" data-title="Open Google?"
   href="https://google.com" target="_blank">Confirmation</a>

<!-- Button confirmation Custom -->
<button class="btn btn-large btn-primary" data-toggle="confirmation"
        data-btn-ok-label="Continue" data-btn-ok-icon="glyphicon glyphicon-share-alt"
        data-btn-ok-class="btn-success"
        data-btn-cancel-label="Stoooop!" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
        data-btn-cancel-class="btn-danger"
        data-title="Is it ok?" data-content="This might be dangerous">
  Confirmation
</button>




<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/datatables.min.js"></script>
<script type="text/javascript" src="js/query.js"></script>
<script src="test/bootstrap-confirmation.min.js"></script> 



<script type="text/javascript" charset="utf-8">
// JS script needed for data-toggle="confirmation"

// confirm with a pop of your selected confirmation
$("[data-toggle=confirmation]").confirmation({btnOkLabel: 'Yes', btnCancelLabel: 'No', title: 'Are you sure?',container:"body",btnOkClass:"btn btn-sm btn-success btn-xs",btnCancelClass:"btn btn-sm btn-danger btn-xs",onConfirm:function(event, element) { alert('confirm clicked'); }});


/* // confirmation with out onConfirm alert
$('[data-toggle=confirmation]').confirmation({ btnOkClass: 'btn btn-sm btn-success', btnCancelClass: 'btn btn-sm btn-danger'});	
*/ 
</script>

</body>
</html>