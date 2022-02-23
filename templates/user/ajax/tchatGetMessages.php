<?php
        session_start();
        include_once "connectDb.php";

        $query = $db->query("  SELECT * FROM messages
                               WHERE messages.s = '{$_SESSION['pseudo']}' AND messages.r = '{$_SESSION['name']}'
                               OR
                               messages.r = '{$_SESSION['pseudo']}' AND messages.s = '{$_SESSION['name']}'

                               ");

       $results = [];
       while($result = $query->fetch())
       {
         $results[] = $result;
       }

       $sender = $_SESSION['pseudo'];

       foreach ($results as $message) {
         if($message['s'] == $sender) {
             ?>
                 <div class="sendMessage">
                     <p><?= $message['m']?></p>
                 </div>
             <?php
         }else{
           ?>
               <div class="recieveMessage">
                   <p><?= $message['m']?></p>
               </div>
           <?php
         }
       }


  ?>
