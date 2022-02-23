<?php
session_start();
include_once "connectDb.php";


        $commentReplyField = htmlspecialchars(trim($_POST['replayCommentArea']));

        if(!empty($commentReplyField))
        {
          $query = "INSERT INTO comments(commentPost_id, commenter_name, comment_core, comment_date)
                    VALUES(:commentPost_id, :commenter_name, :comment_core, now()
          )";
          $quer = $db->prepare($query);
          $quer->execute(array(
                "commentPost_id" => $_SESSION['post_id'],
                "commenter_name" => $_SESSION['pseudo'],
                "comment_core" => $commentReplyField
          ));

        }else{
          ?>
          <div class="statusDisplay">
              <p><?php echo "Empty comment cannot be accepted!";?></p>
          </div>

          <?php
        }

 ?>
