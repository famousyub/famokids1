<?php

    // function to display the post to comment on
    function getPost()
    {
      global $db;

      $query = $db->query("SELECT  users.id,
                                   users.userProfilePic,
                                   posts.post_id,
                                   posts.poster_id,
                                   posts.poster_name,
                                   posts.post_core,
                                   posts.post_image,
                                   posts.post_date
                            FROM posts
                            INNER JOIN users ON users.id = posts.poster_id
                            WHERE posts.post_id='{$_GET['postId']}'
                           ");

              $results = array();
              while($result = $query->fetch())
              {
                $results[] = $result;
              }
              return $results;
    }

    // function to insert comments to the database
    /*function insertComments()
    {
      global $db;
      if(isset($_POST['commentReplyBtn']))
      {
        $commentReplyField = htmlspecialchars(trim($_POST['commentReply']));
        if(!empty($commentReplyField))
        {
          $query = "INSERT INTO comments(commentPost_id, commenter_name, comment_core, comment_date)
                    VALUES(:commentPost_id, :commenter_name, :comment_core, now()
          )";
          $quer = $db->prepare($query);
          $quer->execute(array(
                "commentPost_id" => $_GET['postId'],
                "commenter_name" => $_SESSION['pseudo'],
                "comment_core" => $commentReplyField
          ));

        }else{
          echo "you cannot leave an empty comment ";
        }
      }

    }*/

    // function to display the comments
    /*function displayComments()
    {
      global $db;
      $query = $db->query("SELECT  comments.comment_id,
                                   comments.commentPost_id,
                                   comments.commenter_name,
                                   comments.comment_core,
                                   comments.comment_date,
                                   users.pseudo,
                                   users.userProfilePic
                           FROM comments
                           INNER JOIN users ON comments.commenter_name = users.pseudo
                           WHERE comments.commentPost_id = '{$_GET['postId']}'
                           ORDER BY comments.comment_date DESC
      ");

      $results = array();
      while($result = $query->fetch())
      {
        $results[] = $result;
      }
      return $results;
    }*/


    // function to display the total number in a selected post
    function displayTotalNumCommentsOnSelectedPost()
    {
      global $db;

      $query = "SELECT comments.commentPost_id
                FROM comments
                WHERE comments.commentPost_id = '{$_GET['postId']}'
                ";

      $quer = $db->prepare($query);
      $quer->execute();

      $numComments = $quer->rowCount();

      return $numComments;
    }



























 ?>
