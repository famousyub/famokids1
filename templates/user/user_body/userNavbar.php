
<nav>
   <div class="nav-wrapper teal lighten-2">
     <div class="container">
       <a href="user_index.php" class="brand-logo">SO.NET</a>
         <ul id="nav-mobile" class="right hide-on-med-and-down">
           <li><a class="homeIcon" href="user_index.php?page=dashboard">Home</a></li>
           <li><a class="messageIcon" href="#"><i class="material-icons">mode_comment</i></a></li>
           <li><a class="notificationIcon" href="#"><i class="material-icons">public</i></a></li>
           <li><a class="menu dropDownIco" href="#"><i class="material-icons">arrow_drop_down_circle</i></a></li>
         </ul>
     </div>
   </div>
 </nav>


 <div class="menuDrop teal lighten-2">
     <ul>
       <li class="dropDownMenuLineSetting"><a href="user_index.php?page=profile">Settings</a></li>
       <li><a href="user_index.php?page=logout">logout</a></li>
     </ul>
 </div>





 <script>
 /*
 $(document).ready(function(){
     $(".menu").click(function(){
         $(".menuDrop").slideDown(1000);
     });
 });*/

 $(function() {
  $('.menu').click(function() {
   if( $(".menuDrop").is(":hidden") ) {
    $(".menuDrop").slideDown();
   }
   else
   {
    $(".menuDrop").slideUp();
   }
   });
  });

 </script>


<style media="screen">

  .nav-wrapper ul li a
  {
    color: #ffffff;
    font-size: 20px;
    font-family:  'Titillium Web', sans-serif;
  }

  .menuDrop
  {
    position: absolute;
    width: 200px;
    right: 203px;
    display: none;
    top: 70px;
    z-index: 4;
  }
  .menuDrop li a
  {
    color: #ffffff;
    font-size: 18px;
    font-family:  'Titillium Web', sans-serif;
    position: relative;
    left: 50px;
  }
  .menuDrop ul li
  {
    height: 40px;
    padding-top: 5px;
  }

  .menuDrop ul li:hover
  {
    background-color: #4e4e4e;
    color: #ffffff;

  }

  .dropDownMenuLineSetting
  {
    border-bottom: 1px solid #eeeeee;
  }
  nav
  {
    margin-bottom: 2px;
    position: fixed;
      z-index: 4;
  }
  .dropDownIco
  {
    border-left: 1px solid #bdbdbd;
  }

  .dropDownIco i
  {
    position: relative;
    top:3px;
  }

  .messageIcon i
  {
    position: relative;
    top: 3px;
  }
  .notificationIcon i  {
    position: relative;
    top:3px;
  }
  .homeIcon {
    background-color: #3A8E87;
    color: #fefefe;
  }



</style>
