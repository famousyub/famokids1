<?php
    session_start();
    if(!$_SESSION['id']) {
      header('Location: ../index.php');
    }
    // update the pseudo of the user
    if(isset($_POST['updatePseudoBtn']))
    {
      $updatePseudo = htmlspecialchars(trim($_POST['updatePseudo']));
      if(!empty($updatePseudo))
      {
          updateUserPseudo($updatePseudo);
      }else{
        echo "You cannot have an empty pseudo";
      }
    }
    // update the user email
    if(isset($_POST['updateEmailBtn']))
    {
      $updateEmail = htmlspecialchars(trim($_POST['updateEmail']));
      if(!empty($updateEmail))
      {
          updateUserEmail($updateEmail);
      }else{
        echo "You have to spercify an email ";
      }
    }
?>
<div class="container">
    <div class="row">
       <div class="col s3 leftSection">
         <ul>
           <li>  <a href="user_index.php?page=profile"><i class="material-icons">account_circle</i>General Information</a></li>
           <li>  <a href="user_index.php?page=profilePic"><i class="material-icons">image</i>Profile Picture</a></li>
           <li>  <a href="user_index.php?page=password_edit"><i class="material-icons">lock</i>Password</a></li>
           <li>  <a href="#"><i class="material-icons">language</i>Language</a></li>
         </ul>

       </div>

      <!-- The main section-->
      <div class="col s9 mainSection">
          <h2 class="flow-text profilePageTitle">General Account Settings</h2><hr>
          <!-- Edit the user pseudo -->

            <div class="editTitle">
                <h6 class="name">Pseudo</h6>
                <a class="editPseudoClick" href="#"><h6 class="edit">Edit</h6></a>
            </div>
          <div class="editContentParentPseudo">
            <div class="editContent">
                <h6>Pseudo</h6>
                <form action="user_index.php?page=profile" method="post">

                  <input type="text" name="updatePseudo" placeholder="New Pseudo">

                  <button class="updateEditBtn" type="submit" name="updatePseudoBtn">Update</button>
                  <button class="cancelEditBtnPseudo">Cancel</button>
                </form>
            </div>
          </div>
          <!-- edit the user email -->

            <div class="editTitle">
                <h6 class="name">Email</h6>
                <a class="editEmailClick" href="#"><h6 class="edit">Edit</h6></a>
            </div>
          <div class="editContentParentEmail">
            <div class="editContent">
                <h6>Email</h6>
                <form action="user_index.php?page=profile" method="post">

                  <input type="email" name="updateEmail" placeholder="New Email">

                  <button class="updateEditBtn" type="submit" name="updateEmailBtn">Update</button>
                  <button class="cancelEditBtnEmail">Cancel</button>
                </form>
            </div>
          </div>









      </div>
    </div>



</div>

<!-- ************************************************* CSS ********************************************************-->
    <style media="screen">
      .mainSection {
        position: relative;
        top:70px;
      }
      .leftSection
      {
        border-right: 1px solid #e0e0e0;
        background-color: #fafafa;
        position: relative;
        top:70px;

      }
      .leftSection li
      {

        padding-top: 4px;
        padding-left: 20px;
        height: 40px;

      }
      .profilePageTitle
      {
        font-family: 'Titillium Web', sans-serif;
        color: #4e4e4e;
      }
      .editTitle
      {
        font-family: 'Titillium Web', sans-serif;
        font-size: 20px;
        background-color: #fafafa;
        height: 42px;
        padding-top: 0.5px;
        padding-left: 1px;
        margin-bottom: 3px;
      }
      .editTitle .name
      {
        display: inline-block;
      }
      .editTitle .edit
      {
        display: inline;
        position: absolute; right: 218px;
      }
      .editContent
      {
        font-family: 'Titillium Web', sans-serif;
        font-size: 20px;
        height: 250px;
        background-color: #9e9e9e;
        padding: 10px 10px;
        color: #ffffff;

      }
      .editContent .updateEditBtn
      {
        position: relative;
        left: 0px;
        top: 100px;
        border: 1px solid #4e4e4e;
        color: #ffffff;
        background-color: #4e4e4e;
        height: 35px;
        font-family: 'Titillium Web', sans-serif;
        width: 100px;
        font-size: 18px;
        border-radius: 2px 2px 2px 2px;
      }
      .editContent .cancelEditBtnPseudo
      {
        position: relative;
        left: 10px;
        top: 100px;
        border: 1px solid #4e4e4e;
        color: #ffffff;
        background-color: #4e4e4e;
        height: 35px;
        font-family: 'Titillium Web', sans-serif;
        width: 100px;
        font-size: 18px;
        border-radius: 2px 2px 2px 2px;
      }

      .editContent .cancelEditBtnEmail
      {
        position: relative;
        left: 10px;
        top: 100px;
        border: 1px solid #4e4e4e;
        color: #ffffff;
        background-color: #4e4e4e;
        height: 35px;
        font-family: 'Titillium Web', sans-serif;
        width: 100px;
        font-size: 18px;
        border-radius: 2px 2px 2px 2px;
      }


      .editContent input[type=text]
      {
        border: 1px #4e4e4e solid;
        width: 202px;
        height: 40px;
        position: relative;
        top: 40px;
        left:220px;
        background-color: #eeeeee;
        padding-left: 5px;
        padding-right: 5px;
      }
      .editContent input[type=email]
      {
        border: 1px #4e4e4e solid;
        width: 202px;
        height: 40px;
        position: relative;
        top: 40px;
        left:220px;
        background-color: #eeeeee;
        padding-left: 5px;
        padding-right: 5px;
      }
      .editContentParentPseudo
      {
        padding: 1px 1px;
        margin-bottom: 2px;
        display: none;
      }
      .editContentParentEmail
      {
        padding: 1px 1px;
        margin-bottom: 2px;
        display: none;
      }


    </style>
<!--  ****************************************** Jquery****************************************************** -->
    <script>
    // function to show and hide pseudo edit
    $(function() {
       $('.editPseudoClick').click(function() {
          if( $(".editContentParentPseudo").is(":hidden") ) {
           $(".editContentParentPseudo").slideDown();
          }
        });
     });

     $(function() {
        $('.cancelEditBtnPseudo').click(function() {
           $(".editContentParentPseudo").hide();
         });
      });
      // function to show and hide email edit
      $(function() {
         $('.editEmailClick').click(function() {
            if( $(".editContentParentEmail").is(":hidden") ) {
             $(".editContentParentEmail").slideDown();
            }
          });
       });

       $(function() {
          $('.cancelEditBtnEmail').click(function() {
             $(".editContentParentEmail").hide();
           });
        });
    </script>
