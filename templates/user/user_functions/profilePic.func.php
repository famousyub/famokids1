<?php
    // function to display profile picture
    function displayProfilePic()
    {
      global $db;
      $image = $db->query("SELECT userProfilePic FROM users WHERE id= '{$_SESSION['id']}' ") ;
      return $image;
    }

    // Function to Change the user profile picture
    function updateProfilePicture()
    {
      global $db;
      if(isset($_POST['ValideProfilePicture']))
      {
        if(isset($_FILES['loadProfilePicture']) AND $_FILES['loadProfilePicture']['error'] == 0 )
        {
            if ($_FILES['loadProfilePicture']['size'] <= 9000000) {

               $fileInfo = pathinfo($_FILES['loadProfilePicture']['name']);
               $fileExtension = $fileInfo['extension'];

               $allowedExtensions = array('jpg','png', 'jpeg');
               // check if the extension of the file loaded belongs to the allowed extensions
               if(in_array($fileExtension, $allowedExtensions))
               {
                 $originalNameFile = basename($_FILES['loadProfilePicture']['name']);

                  move_uploaded_file($_FILES['loadProfilePicture']['tmp_name'], 'user_profile/'.$originalNameFile);
                  $fileNameGoten = $fileInfo['filename'].'.'.$fileExtension;


                  $query = "UPDATE users SET
                                userProfilePic = :userProfilePic
                                WHERE id = '{$_SESSION['id']}'
                            ";
                  $preparedQuery = $db->prepare($query);
                  $preparedQuery->execute(array(
                      "userProfilePic" => $fileNameGoten
                  ));
               }else{
                 echo "file extension is not supported ";
               }
            }else{
              echo "Max size accepted is 1MO";
            }
        }else{
          echo "no file chosen";
        }
      }
    }

 ?>
