<?php
  session_start();

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
        <div class="infoProfilePicture">
          <p>Please load a square profile image where your face is well shown.
            Prefered size is 800px * 800px
          </p>
        </div>
          <?php
            foreach (displayProfilePic() as $image) {
              ?>
                  <div class="profilePictureDislayedSquare">
                      <img src="user_profile/<?=$image['userProfilePic']?>" width="200px" height="200px">
                  </div>
                  <div class="profilePictureDislayedCircle">
                      <img src="user_profile/<?=$image['userProfilePic']?>" width="200px" height="200px">
                  </div>

                  <div class="profilePictureDislayedSquareSmall">
                      <img src="user_profile/<?=$image['userProfilePic']?>" width="80px" height="80px">
                  </div>

                  <div class="profilePictureDislayedCircleSmall">
                      <img src="user_profile/<?=$image['userProfilePic']?>" width="80px" height="80px">
                  </div>
              <?php
            }
            ?>
          <!-- Load a profile picture  -->
          <?php updateProfilePicture(); ?>

          <form class="loadPictureForm" action="user_index.php?page=profilePic" method="post" enctype="multipart/form-data">
            <input class="LoadPicBtn" type="file" name="loadProfilePicture" value="Profile Picture">
            <button class="loadPictureFormBtn" type="file" name="ValideProfilePicture">Load Image</button>
          </form>



      </div>
    </div>
</div>






      <!-- ************************************** CSS *************************************************-->
      <style media="screen">
      /* left section */
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
        /* end of left section */
        .infoProfilePicture
        {
          background-color: #8dfcd9;
          height: 60px;
          font-family: 'Titillium Web', sans-serif;
          padding-left: 25px;
          position: absolute;
          top: 67px;
          width: 706px;
          color: #2e2e2e;
          border-radius: 2px 2px 2px 2px;


        }
        .profilePictureDislayedSquare
        {
          display: inline-block;
          position: absolute;
          top: 150px;
          border: 2px #4e4e4e solid;
          width: 206px ;
          height: 206px;
          padding: 1px 1px;

        }
        .profilePictureDislayedCircle
        {
          border-radius: 103px 103px;
          display: inline-block;
          position: absolute;
          top: 150px;
          border: 2px #4e4e4e solid;
          width: 206px ;
          height: 206px;
          padding: 1px 1px;
          left: 750px;

        }
        .profilePictureDislayedCircle img
        {
          border-radius: 100px 100px;
        }

        .profilePictureDislayedSquareSmall
        {
          display: inline-block;
          position: absolute;
          top: 150px;
          border: 2px #4e4e4e solid;
          width: 86px ;
          height: 86px;
          padding: 1px 1px;
          left: 1075px;
        }
        .profilePictureDislayedCircleSmall
        {
          border-radius: 53px 53px;
          display: inline-block;
          position: absolute;
          top: 280px;
          border: 2px #4e4e4e solid;
          width: 86px ;
          height: 86px;
          padding: 1px 1px;
          left: 1075px;
        }
        .profilePictureDislayedCircleSmall img
        {
          border-radius: 50px 50px;
        }
        .loadPictureForm .loadPictureFormBtn
        {
          position: absolute;
          top: 450px;
          width: 200px;
          border: 1px #4e4e4e solid;
          background-color: #4e4e4e;
          color: #ffffff;
          height: 38px;
          right: 500px;
        }
        .loadPictureForm .LoadPicBtn
        {
          position: absolute;
          top: 450px;
          width: 200px;
          border: 1px #4e4e4e solid;
          background-color: #4e4e4e;
          color: #ffffff;
          height: 38px;
          color: transparent;
          padding-top: 6px;
          padding-left: 50px;*/
        }

        .loadPictureForm .LoadPicBtn input[type="file"]
        {
            background-color: transparent;
        }


      </style>
