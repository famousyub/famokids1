<?php
include_once "functions/connect_db.php";
$pages = scandir('home_pages/');
if(isset($_GET['page']) AND !empty($_GET['page'])){
	if(in_array($_GET['page'].'.php', $pages)){
		$page = $_GET['page'];
	}else{
		$page = "error";
	}
}else{
	$page = "login";
}

?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/ilysocial.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
</head>
<body>

<!-- include the the navigation bar -->
	
	<?php
		include_once "home_body/home_navbar.php";
	?>
	
<!-- apply a container for all the page -->
	<div class="container">
	<?php 	
		include_once 'home_pages/'.$page.'.php';
	?>
	</div>




</body>
</html>