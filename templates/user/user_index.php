<?php
include_once "../home_functions/connect_db.php";
$pages = scandir('user_pages/');
if(isset($_GET['page']) AND !empty($_GET['page'])){
 if(in_array($_GET['page'].'.php', $pages)){
   $page = $_GET['page'];
 }else{
   $page = "userError";
 }
}else{
 $page = "dashboard";
}

$functionPages = scandir('user_functions/');
if(in_array($page.'.func.php', $functionPages)){
 include_once 'user_functions/'.$page.'.func.php';
}else{
 $page="userError";
}

?>



<!DOCTYPE html>
<html>
<head>
 <title>Social Network</title>
 <!-- Link the jequery -->

 <!-- Link the styllesheet file-->

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
 <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


</head>
<body>

<!-- include the the navigation bar -->

 <?php
   include_once "user_body/userNavbar.php";
 ?>

<!-- apply a container to all the page -->

 <?php
   include_once 'user_pages/'.$page.'.php';
 ?>






</body>
</html>
