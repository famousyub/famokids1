<?php
    session_start();
    include_once"connectDb.php";

    $postText = htmlspecialchars($_POST['userPostText']);
    $image = $_POST['userPicBtn'];

    if(!empty($postText) isset($image) AND $image['error'] == 0 AND $image <= 9000000 AND $image['size'] >= 0)
    {

        $fileInfo = pathinfo($image['name']);
        $fileExtension = $fileInfo['extension'];
        $allowedExtensions = array('jpg','png', 'jpeg');
        // check if the extension of the file loaded belongs to the allowed extensions

        if(in_array($fileExtension, $allowedExtensions))
        {
            $originalNameFile = basename($image['name']);
            move_uploaded_file($image['tmp_name'], 'user_post_image/'.$originalNameFile);
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
          ?>
            <div class="postStatus">
              <p><?php echo "File extension is not supported!";?></p>
            </div>
          <?php

        }

    }else{
      ?>
      <div class="postStatus">
         <p><?php echo "Empty post cannot be published!";?></p>
      </div>
      <?php
    }


/*if(!empty($postText) AND isset($_FILES['addPostImageBtn']) AND $_FILES['addPostImageBtn']['error'] == 0 AND $_FILES['addPostImageBtn']['size'] <= 9000000 AND $_FILES['addPostImageBtn']['size'] >= 0 )
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
      ?>
        <div class="postStatus">
          <p><?php echo "File extension is not supported!";?></p>
        </div>
      <?php

    }

}else{
  ?>
  <div class="postStatus">
     <p><?php echo "Empty post cannot be published!";?></p>
  </div>
  <?php
}
*/


?>
