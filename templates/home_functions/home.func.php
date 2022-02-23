<?php
  // function to insert data into the database
  function inserData($pseudo, $email, $password, $userProfilePic)
  {
    global $db;
    $query = "INSERT INTO users(pseudo, email, password, userProfilePic,  join_date) VALUES(:pseudo, :email, :password, :userProfilePic, NOW())";
    $preQuery = $db->prepare($query);
    $preQuery->execute(array(
        "pseudo" => $pseudo,
        "email" => $email,
        "password" => $password,
        "userProfilePic"=> $userProfilePic
    ));
  }

  //function to check the identity of a user and let it Login
  function checkUserExistance($email, $password)
  {
    global $db;
    $query = "SELECT id, pseudo, email, password FROM users WHERE email = :email AND password = :password";
    $preparedQuery = $db->prepare($query);
    $preparedQuery->execute(array(
      "email" => $email,
      "password" => $password
    ));
    // here we get the number of lines affected by the list call of execute
    $numOfRowsAffectedByLastExecutedQuery = $preparedQuery->rowCount($query);
    //we check that only one line is returned for the combination email, password given
    if($numOfRowsAffectedByLastExecutedQuery == 1)
    {
        // we read the last result and we save it in a variable $datas
        $datas = $preparedQuery->fetch();
        // we specefy some important session
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $datas['id'];
        $_SESSION['pseudo'] = $datas['pseudo'];
        // we redirect the user to the dashboard
        header('Location: user/user_index.php');
    }else{
      echo "The combination email, password doesn't exist";
    }

  }
?>
