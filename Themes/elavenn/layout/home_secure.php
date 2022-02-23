



  <?php  if ($wo['loggedin'] == true){ ?>
<?php

if  isset($_GET["socialito"]){}

 ?>

<?php  $user_famous =true ;

 if($user_famous==false){

   echo "<p hidden>https://www.nicesnippets.com/snippet/image-gallery-with-filter-using-bootstrap-and-jquery#messages</p>";


 ?>


 <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <div class="container">

      <a class="navbar-brand" href="#">FamousMe.com</a>

      <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline my-2 my-lg-0" action="index.php?page=home" method="post">
          <input class="form-control mr-sm-2" type="email" name="login_email" placeholder="Email" aria-label="Email">
          <input class="form-control mr-sm-2" type="password" name="login_password" placeholder="Password" aria-label="Password">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="login">Login</button>
        </form>
    </div>
  </div>
 </nav>



 <!-- some CSS-->

 <style media="screen">
  .navbar .navbar-brand
  {
    font-family: 'Titillium Web', sans-serif;
    font-size: 30px;
    color: #4e4e4e;
  }
  .navbar
  {

    border-bottom: 2px solid #e2e2e2;
  }
 </style>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 	<link rel="stylesheet" type="text/css" href="css/ilysocial.css">
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
 </head>
 <body>

 <!-- include the the navigation bar -->


 	</div>




 </body>
 </html>



<?php }?>

<?php
/*include_once "functions/connect_db.php";
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
*/
?>

<?php
  //include_once "home_body/home_navbar.php";
?>

<!-- apply a container for all the page -->
<div class="container">
<?php
//	include_once 'home_pages/'.$page.'.php';
?>



<?php } ?>
