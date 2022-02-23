<?php
    session_start();
    include_once "connectDb.php";

    $query = $db->query("SELECT  comments.comment_id,
                                 comments.commentPost_id,
                                 comments.commenter_name,
                                 comments.comment_core,
                                 comments.comment_date,
                                 users.pseudo,
                                 users.userProfilePic
                         FROM comments
                         INNER JOIN users ON comments.commenter_name = users.pseudo
                         WHERE comments.commentPost_id = '{$_SESSION['post_id']}'
                         ORDER BY comments.comment_date DESC
    ");

    $results = array();
    while($result = $query->fetch())
    {
      $results[] = $result;
    }

    foreach ($results as $comment) {
      ?>

          <div class="commenterImage">
              <img src="user_profile/<?= $comment['userProfilePic']?>" width="50px" height="50px" class="commenterPicture">
              <p class="commenterName"><?=$comment['commenter_name']?> replied</p>
              <p class="commenteTime"><?=$comment['comment_date']?></p>
          </div>

          <div class="commentCore">
              <?=$comment['comment_core']?>
          </div>
    

      <?php
    }
 ?>
