<?php
  session_start();
  if(!$_SESSION['id']) {
    header('Location: ../index.php');
  }
 ?>
 <!-- The left section-->
 </script>
 <div class="row">
    <div class="col s3 leftSection">
      <!-- display the image and pseudo of the user-->
        <div class="userProfileDisplayBlock">
            <div class="userProfileDashboardDisplay">
                <?php
                  foreach (displayProfilePic() as $image) {
                    ?>
                       <img src="user_profile/<?=$image['userProfilePic']?>" width="80px" height="80px">
                    <?php
                  }
                ?>
            </div>

            <div class="userProfilePseudoDisplay">
              <h2 class="flow-text userPseudoText"><?= $_SESSION['pseudo']?></h1>
            </div>
        </div>
        <div class="postStatus">

        </div>
    </div>

<!-- The main section-->

<div class="col s6 mainSection">
        <!-- Create the userPostForm -->

        <div class="userFormPost">
          <form method="post" enctype="multipart/form-data" class="sendForm">
            <div class="userFormPostButtons">
              <input type="file" name="addPostImageBtn" class="waves-effect waves-light btn userPicBtn" value="ADD IMAGE">
                <button type="submit" name="publishPostBtn" class="waves-effect waves-light btn userPostBtn">
                  <i class="material-icons right">send</i>Post
                </button>
            </div>
              <textarea type="text" name="addPostTextCore" class="userPostText"></textarea>
          </form>
        </div>
        <!-- Some php to deal with data-->
        <?php publishPost();?>
        <!-- create a line -->
        <div class="line">

        </div>

        <!--create the post area-->

        <div class="userPostDisplayArea">
                <?php foreach (sharePostDisplayData() as $result) {
                ?>
                  <div class="displayPosterInfoBlock">
                    <div class="displayedProfilePicturePoster">
                        <img src="user_profile/<?= $result['userProfilePic']?>" width="90px" height="90px">
                    </div>

                    <div class="displayedProfileNamePoster">
                        <h6><?= $result['poster_name']?> </h6>
                        <p><?= date("d-m-Y  h:i", strtotime($result['post_date']))?></p>
                    </div>
                  </div>

                    <div class="postTextCore">
                      <p><?= $result['post_core']?></p>
                    </div>

                    <div class="postImageCore">
                        <img src="user_post_image/<?= $result['post_image']?>" width="100%">
                    </div>

                    <div class="postLikeDislikeShareBlock">
                        <ul class="postLikeDislikeShare">
                          <li class="postLike"><i class="material-icons">thumb_up</i></li>
                          <li class="postDislike"><i class="material-icons">thumb_down</i></li>
                          <li class="postShare"><i class="material-icons">share</i></li>
                          <li class="postLikeNum">Like(0)</li>
                          <li class="postDislikeNum">Dislike(0)</li>
                          <li class="postShareNum">Shared(0)</li>
                          <a href="user_index.php?page=comment&postId=<?=$result['post_id']?>"
                            target="_blank"><li class="postCommentNum">Comments</li></a>
                        </ul>
                    </div>
                <?php
              }

            ?>
        </div>


</div>


<!-- The right section-->
    <div class="col s3 rightSection">

        <!-- Display the left content-->
        <div class="displayFriendsSide">
            <!-- Display the messenger title-->
            <div class="MessengerHeader">
                <p> FRIENDS</p>
            </div>
            <!-- Display the messenger friends-->
            <div class="slider">
                <?php
                  foreach (displayFriends() as $friend) {
                    ?>
                    <div class="MessengerFriendDisplay">

                        <div class="MessengerFriendPicture">
                            <img src="user_profile/<?= $friend['userProfilePic']?>" width="50px" height="50px" alt="imageProfile">
                        </div>

                        <div class="MessengerFriendName">
                            <p><a href="user_index.php?page=tchat&name=<?=$friend['pseudo']?>" target="_blank"><?= $friend['pseudo']?></a></p>
                        </div>


                    </div>
                    <?php
                  }
                ?>


            </div>

    </div>
 </div>


<script src="js/postPublish.js"></script>



<!-- Additional css-->
<style media="screen">

    .leftSection
    {
      background-color: #ffffff;
      height: 600px;
      /*border-right: 1px solid #e0e0e0;*/
    }


    .mainSection
    {
      background-color: #ffffff;
      height: 600px;
      /*border-left: 1px solid #F4F4F4;*/
    }


    .rightSection
    {
      background-color: #ffffff;
      height: 600px;
      /*border-left: 1px solid #e0e0e0;*/
    }

/* CSS for the upload form*/
  .userFormPostButtons
  {
    background-color: #eeeeee;
    height: 30px;
    margin-bottom: 3px;
    border-radius: 2px 2px 2px 2px;
    position: relative;
    top: 70px;
  }

  .userPostText
  {
    height: 80px;
    padding: 10px 10px;
    border: 1px solid #eeeeee;
    border-radius: 2px 2px 2px 2px;
    font-family: 'Titillium Web', sans-serif;
    color: #4e4e4e;
    font-size: 17px;
    position: relative;
    top: 70px;
  }


  .userPostBtn
  {
    height: 26px;
    line-height: 26px;
    top:2px;
    font-family: 'Titillium Web', sans-serif;
  }
  .userPostBtn:hover
  {
    background-color: #ff9900;
    font-family: 'Titillium Web', sans-serif;
  }
  .userPicBtn
  {
    height: 26px;
    line-height: 26px;
    top:2px;
    font-family: 'Titillium Web', sans-serif;
  }
  .userPicBtn:hover
  {
    background-color: green;
    font-family: 'Titillium Web', sans-serif;
  }

  /*Create the poste display area*/
  .displayPosterInfoBlock
  {
      display: flex;
  }
  .displayedProfilePicturePoster
  {
    /*display: inline-block;*/
    height: 90px;
    width: 90px;
    vertical-align: top;
  }
  .displayedProfilePicturePoster img
  {
    border-radius: 90px 90px;
  }
  .displayedProfileNamePoster
  {
    /*display: inline-block;*/
    background-color: #fafafa;
    height: 90px;
    width: 553px;
    vertical-align: top;
    padding-left: 10px;
  }
  .displayedProfileNamePoster h6
  {
    color: #1e1e1e;
    position: relative;
    top: 0px;
  }
  .displayedProfileNamePoster h6
  {
    color: #6e6e6e;
    position: relative;
    top: 0px;
  }
  .userPostDisplayArea
  {
    border: 1px #eeeeee solid;
    padding: 2px 2px;
    position: relative;
    top: 70px;
  }
  /*.line{
    border: 1px #eeeeee solid;
    height: 0;
    margin-bottom: 7px;
    margin-top: 5px;
  }*/
  .postTextCore
  {
    border:1px #e9e9e9 solid;
    margin-top: 1px;
  }
  /* user profile display*/
  .userProfileDashboardDisplay
  {
  /*  display: inline-block;
    vertical-align:top;*/
    border-right: 1px solid #e0e0e0;
    width: 86px ;
    height: 86px;
    padding: 1px 1px;
  }
  .userProfileDashboardDisplay img
  {
    border-radius: 50px 50px;
  }
  .userProfilePseudoDisplay
  {
    /*display: inline-block;
    vertical-align:top;*/
    background-color: #eeeeee;
    width: 217px;
  }
  .userProfileDisplayBlock
  {
    display: flex;
    border: 1px #eeeeee solid;
    padding-left: 3px;
    position: fixed;
    top: 70px;
  }
  .userPseudoText
  {
    font-family: 'Titillium Web', sans-serif;
    margin-left: 7px;
    position: relative;
    top: -10px;
    color: #4e4e4e;
  }
  /* like and dislike blick*/
  .postLikeDislikeShareBlock
  {
    border: 1px solid #eeeeee;
    margin-bottom: 5px;
  }

  .postLikeDislikeShareBlock .postLikeDislikeShare li
  {
    display: inline;
  }

  .postLikeDislikeShareBlock .postLikeDislikeShare .postLike
  {
    font-family: 'Titillium Web', sans-serif;
    color: #4e4e4e;
    font-size: 17px;
    margin-left: 20px;
  }

  .postLikeDislikeShareBlock .postLikeDislikeShare .postDislike
  {
    font-family: 'Titillium Web', sans-serif;
    color: #4e4e4e;
    font-size: 17px;

  }

  .postLikeDislikeShareBlock .postLikeDislikeShare .postShare
  {
    font-family: 'Titillium Web', sans-serif;
    color: #ff9900;
    font-size: 17px;
  }

  .postLikeDislikeShareBlock .postLikeDislikeShare .postLikeNum
  {
    position: relative;
    font-family: 'Titillium Web', sans-serif;
    color: #4e4e4e;
    font-size: 17px;
    top: -5px;
    left: 100px;
  }
  .postLikeDislikeShareBlock .postLikeDislikeShare .postDislikeNum
  {
    position: relative;
    font-family: 'Titillium Web', sans-serif;
    color: #4e4e4e;
    font-size: 17px;
    top: -5px;
    left: 130px;
  }

  .postLikeDislikeShareBlock .postLikeDislikeShare .postShareNum
  {
    position: relative;
    font-family: 'Titillium Web', sans-serif;
    color: #4e4e4e;
    font-size: 17px;
    top: -5px;
    left: 160px;
  }
  .postLikeDislikeShareBlock .postLikeDislikeShare .postCommentNum
  {
    position: relative;
    font-family: 'Titillium Web', sans-serif;
    color: #00897b;
    font-size: 17px;
    top: -5px;
    left: 190px;
  }







/* right section styles*/


  .displayFriendsSide {
    background-color: #ffffff;
    width: 324px;
    position: fixed;
    top: 70px;
    border-left: 1px solid #F4F4F4;
  }

  .displayFriendsSide .slider
  {
    overflow: auto;
    position: relative;
    top: -20px;
    height: 500px;
  }
  .displayFriendsSide .MessengerHeader
  {
    background-color: #C4C4C4;
    height: 60px;
    position: relative;
    top: -20px;
    line-height: 55px;
    text-align: center;
    color: #ffffff;
    font-family:'Titillium Web', sans-serif;
    font-size: 20px;
  }

  .MessengerFriendDisplay
  {
    display: flex;
    padding: 0px 10px;
    height: 62px;
    line-height: 30px;
    position: relative;
    border-bottom: 1px solid #F4F4F4;
  }
  .MessengerFriendDisplay:hover
  {
    background-color: #F4F4F4;
  }


  .MessengerFriendDisplay .MessengerFriendPicture img
  {
    border-radius: 50px 50px;
    margin-right: 10px;
    border: 1px solid #4e4e4e;
    position: relative;
    top: 5px;
  }

  /*just a simple test*/
  .postStatus {
    background-color: red;
    position: relative;
    top: 150px;
  }

  /*end of the test/











</style>
