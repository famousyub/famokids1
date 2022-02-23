<?php
    // function to display profile picture
    function displayProfilePic()
    {
      global $db;
      $image = $db->query("SELECT userProfilePic FROM users WHERE id= '{$_SESSION['id']}' ") ;
      return $image;
    }
    // function to publish a post
    function publishPost()
    {
      global $db;
      if(isset($_POST['publishPostBtn']))
      {
        $postText = $_POST['addPostTextCore'];
        if(!empty($postText) AND isset($_FILES['addPostImageBtn']) AND $_FILES['addPostImageBtn']['error'] == 0 AND $_FILES['addPostImageBtn']['size'] <= 9000000 AND $_FILES['addPostImageBtn']['size'] >= 0 )
        {

            $fileInfo = pathinfo($_FILES['addPostImageBtn']['name']);
            $fileExtension = $fileInfo['extension'];
            $allowedExtensions = array('jpg','png', 'jpeg');
            // check if the extension of the file loaded belongs to the allowed extensions
            if(in_array($fileExtension, $allowedExtensions))
            {
                $originalNameFile = basename($_FILES['addPostImageBtn']['name']);
                move_uploaded_file($_FILES['addPostImageBtn']['tmp_name'], 'user_post_image/'.$originalNameFile);
                $fileNameGoten = $fileInfo['filename'].'.'.$fileExtension;
                // insert the information loaded by the user into the data base
                $query = "INSERT INTO      posts(poster_id, poster_name, post_core, post_image, post_date)
                          VALUES           (:poster_id, :poster_name, :post_core, :post_image, NOW())
                           ";
                $pre_query = $db->prepare($query);
                $pre_query->execute(array(
                    "poster_id" => $_SESSION['id'],
                    "poster_name" =>$_SESSION['pseudo'],
                    "post_core" => $postText,
                    "post_image" => $fileNameGoten
                ));


            }else{
              echo "file extension is not supported";
            }

        }else{
          echo "you cannot share an empty post";
        }
      }
    }

    function sharePostDisplayData()
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
                            ORDER BY posts.post_date DESC
                           ");
                $results = array();
          while($result = $query->fetch())
          {
            $results[] = $result;

          }
          return $results;

    }






    function displayFriends() {
        global $db;

        $query = $db->query("SELECT * FROM users WHERE users.id != '{$_SESSION['id']}'");

        $results = array();
        while($result = $query->fetch()) {
          $results[] = $result;
        }

        return $results;
    }














 ?>
