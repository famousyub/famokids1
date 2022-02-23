 <link rel="icon" href="http://localhost:8081/examples/logo1.jpg" type="image/jpg" sizes="16x16">

<?php
$color='purple';
$_theme='famousMe11';
?>




<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.3/vue.min.js"></script>
<?php


$developpemnt =  true  ;


if($developpemnt==true){
    echo '<script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>';


}

else {

  echo '<script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>';
}

?>
<?php
// Set session variables
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "<small hidden>Session variables are set. </small>";
?>

<script>

console.log("hello ");
</script>



<style>


svg {

  height: 30;
  width:30;
}

</style>
