<?php
    session_start();
    if(!$_SESSION['id']) {
      header('Location: ../index.php');
    }
    $post_id = $_GET['postId'];
    $_SESSION['post_id'] = $post_id;

?>

<!-- The main section-->

<div class="col s6 mainSection container">

       <!--create the post area-->

       <div class="userPostDisplayArea">

          <?php
              foreach (getPost() as $post) {
                ?>
                <div class="displayPosterInfoBlock">
                  <div class="displayedProfilePicturePoster">
                      <img src="user_profile/<?=$post['userProfilePic']?>" width="90px" height="90px">
                  </div>

                  <div class="displayedProfileNamePoster">
                      <h6><?=$post['poster_name']?></h6>
                      <p><?= date("d-m-Y  h:i", strtotime($post['post_date']))?></p>
                  </div>
                </div>


                  <div class="postTextCore">
                    <p><?= $post['post_core']?> </p>
                  </div>

                  <div class="postImageCore">
                      <img src="user_post_image/<?= $post['post_image']?>" width="100%">
                  </div>

                  <div class="postLikeDislikeShareBlock">
                      <ul class="postLikeDislikeShare">
                        <li class="postLike"><i class="material-icons">thumb_up</i></li>
                        <li class="postDislike"><i class="material-icons">thumb_down</i></li>
                        <li class="postShare"><i class="material-icons">share</i></li>
                        <li class="postLikeNum">Like(0)</li>
                        <li class="postDislikeNum">Dislike(0)</li>
                        <li class="postShareNum">Shared(0)</li>
                        <li class="postCommentNum">Comments(<?= displayTotalNumCommentsOnSelectedPost();?>)</li>
                      </ul>
                  </div>


                  <?php
              }

          ?>
          <!-- Form to leave a comment -->
          <?php
                //insertComments();
            ?>
            <div class="statusDisplay">

            </div>

          <h1 class="replyTitle flow-text">Leave a reply</h1>
          <form class="commentForm" action="" method="post">
              <textarea name="commentReply" class="replayCommentArea"></textarea><br>
              <button name="commentReplyBtn" class="waves-effect waves-light btn replyBtn"><i class="material-icons right">send</i>Comment</button>
          </form>


          <!-- Display the comment left by the commenter -->

              <div class="commentsContainer">
                  <div class="commenterImage">

                  </div>

                  <div class="commentCore">

                  </div>
              </div>













       </div>
</div>

<script src="js/comments.js"></script>

<!-- The right section-->
<!-- some style-->

<style>
    /*display the post part styles */
    .mainSection
    {
      background-color: #ffffff;
      position: relative;
      top: 70px;
    }

    .userPostDisplayArea
    {
      display: block;
      border: 1px #eeeeee solid;
      padding: 2px 2px;
    }
    .displayPosterInfoBlock
    {
      display: flex;
    }
    .displayedProfilePicturePoster
    {
      /*display: inline-block;*/
      height: 90px;
      width: 90px;
    }
    .displayedProfilePicturePoster img
    {
      border-radius: 90px 90px;
      border:1px solid #e9e9e9;
      background-color: #fafafa;
    }

    .displayedProfileNamePoster
    {
      /*display: inline-block;*/
      background-color: #fafafa;
      height: 90px;
      width: 556px;
      border:1px solid #e9e9e9;
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

    .postTextCore
    {
      border:1px #e9e9e9 solid;
      margin-top: 1px;

      width: 647px;
    }
    .postImageCore
    {
      width: 647px;
    }
    .postLikeDislikeShareBlock
    {
      border: 1px solid #eeeeee;
      margin-bottom: 5px;
      width: 647px;
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



    /*display the comments part styles */

    .replyTitle
    {
      font-family: 'Titillium Web', sans-serif;
      color: #00897b;
      position: relative;
      top: -12px;
    }
    .replayCommentArea
    {
      border: 1px solid #00897b;
      height: 80px;
      position: relative;
      top: -19px;
      width: 650px;

    }

    .replyBtn
    {
      background-color: #00897b;
      position: relative;
      top: -10px;
    }

    /*comment display patr style*/
    .commenterPicture
    {
      display: inline-block;
      border-radius: 50px 50px;
    }

    .commenterImage .commenterName
    {
      display: inline-block;
      vertical-align: top;
      position: relative;
      top: -10px;
      color: #2e2e2e;
      left: 10px;
      font-family: 'Titillium Web', sans-serif;
    }
    .commenterImage .commenteTime
    {
      display: inline-block;
      position: relative;
      left: -69px;
      top: -8px;
      font-family: 'Titillium Web', sans-serif;
      font-size: 12px;
    }

    .commentCore
    {
      width: 584px;
      position: relative;
      left: 63px;
      top: -10px;
      color: #2e2e2e;
      border: 1px solid #00897b;
      background-color: #b2dfdb;
      font-family: 'Titillium Web', sans-serif;
      border-radius: 0 12px 0 12px;
      padding-left: 5px;
      padding-top:2px;
      padding-bottom: 2px;
    }

    .statusDisplay
    {
      background-color: #FB3640;
      color: #F4F4F4;
      text-align: center;
      height: 40px;
      width: 646px;

    }

    .statusDisplay p
    {
      position: relative;
      top: 9px;

    }











</style>
