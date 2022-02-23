 <?php
include_once "home_functions/connect_db.php";
$pages = scandir('home_pages/');
if(isset($_GET['page']) AND !empty($_GET['page'])){
	if(in_array($_GET['page'].'.php', $pages)){
		$page = $_GET['page'];
	}else{
		$page = "error";
	}
}else{
	$page = "home";
}

$functionPages = scandir('home_functions/');
if(in_array($page.'.func.php', $functionPages)){
  include_once 'home_functions/'.$page.'.func.php';
}else{
  $page="error";
}

?>



<!DOCTYPE html>
<html>
<head>
	<title>Social Network</title>
	<!-- Link the jequery -->

	<!-- Link the styllesheet file-->
	<link rel="stylesheet" type="text/css" href="home_css/socialNet.css">
	<!-- These links are gotten from bootstrap-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
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




	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

</body>
</html>
