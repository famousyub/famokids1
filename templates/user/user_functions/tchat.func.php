<?php
  // function to change messages with the friend selected
    /*function insertMessages() {
        global $db;
        if(isset($_POST['submitM']))
        {
          $message = htmlspecialchars($_POST['my_message']);

          if(!empty($message)) {

              $quer = "INSERT INTO messages(s, r, m) VALUES (:s, :r, :m)
                      ";
              $query = $db->prepare($quer);
              $query->execute(array(
                "s" => $_SESSION['pseudo'],
                "r" => $_GET['name'],
                "m" => $message

              ));
          }else {
            echo "can't send an empty message";
          }

       }

     }*/ // end of function

     // create a new function to display the messages exchanged
    /* function displayMessages()
     {
       global $db;
       $query = $db->query("  SELECT * FROM messages
                              WHERE messages.s = '{$_SESSION['pseudo']}' AND messages.r = '{$_GET['name']}'
                              OR
                              messages.r = '{$_SESSION['pseudo']}' AND messages.s = '{$_GET['name']}'

                              ");

      $results = [];
      while($result = $query->fetch())
      {
        $results[] = $result;
      }

      return $results;



     }
*/



?>
