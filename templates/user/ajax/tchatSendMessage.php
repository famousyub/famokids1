<?php

    session_start();

      include_once "connectDb.php";
      $message = htmlspecialchars($_POST['messageTextField']);
      if(!empty($message)) {


         $quer = "INSERT INTO messages(s, r, m) VALUES (:s, :r, :m)";
          $query = $db->prepare($quer);
          $query->execute(array(
            "s" => $_SESSION['pseudo'],
            "r" => $_SESSION['name'],
            "m" => $message
          ));
          
      }else {
         ?>
          <div class="status">
              <?php echo "empty message not accepted"; ?>
          </div>
         <?php
      }





  ?>
