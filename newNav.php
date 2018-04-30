
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!--
	<script src="js/bootstrap.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
	<script type="text/javascript" src="assets/jquery-1.11.3-jquery.min.js"></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
	<link href="assets/datatables.min.css" rel="stylesheet" type="text/css">
-->

	<!-- ajax jquery.min.js is needed for button dropdown menu -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>



	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
	<link href="assets/datatables.min.css" rel="stylesheet" type="text/css">

</head>

<!-- nav tabs -->
<body data-spy="scroll" data-target="#spy-scroll-id">
    <!-- <nav class="navbar navbar-default navbar-fixed-top"> -->
    <div class="container" id="spy-scroll-id">
             <ul class="nav nav-tabs"> 
                <li class="active"><a  href="new_customer.php">New Customer</a></li>
                <li><a  href="spaceproduct.php">Add Space</a></li>
                <li><a  href='powerproduct.php'>Add Power</a></li>
                <li><a  href="query.php">Query Customer</a></li>
            </ul>
    </div>
  <!--   </nav> -->
</body>


<!-- <body>
	
     <nav class="navbar navbar-default">
         <div class="container">           
            <div class="navbar-header">
                <ul class="nav navbar-nav"> 
                    <li class="active"><a  href="new_customer.php">New Customer</a></li>
                    <li><a href="spaceproduct.php">Add Space</a></li>
                    <li><a href='powerproduct.php'>Add Power</a></li>
                    <li><a href="query.php">Query Customer</a></li>
                </ul> 
            </div>
        </div>
    </nav>
</body> -->

<script>


// $(".nav li").on("click", function(){
//    $(".nav").find(".active").removeClass("active");
//    $(this).parent().addClass("active");
// });

// $(".nav .nav-link").on("click", function(){
//    $(".nav").find(".active").removeClass("active");
//    $(this).addClass("active");
// });

$(document).ready(function() {
  $('li.active').removeClass('active');
  $('a[href="' + location.pathname + '"]').closest('li').addClass('active'); 
});

</script>
</html>
			
