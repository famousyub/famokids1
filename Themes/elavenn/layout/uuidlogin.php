  <?php?>

<?php

//if()

if ($wo['loggedin'] == true){
if (isset($_GET['usuuid'])  &&  empyty(  $_SESSION["uuid"]) ) {



  session_start();

  $_SESSION["uuid"] =  $_GET['usuuid'];
  echo '<small hidden >Hello ' . htmlspecialchars($_GET["'usuuid"]) . '!</small>';
}
}


?>



  <?php  if ($wo['loggedin'] == true){ ?> 

<script src='http://localhost:8081/examples/callback.js'>


</script>
<?php  ?>
