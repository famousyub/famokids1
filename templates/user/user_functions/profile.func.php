<?php
  // function to update the user pseudo
  function updateUserPseudo($updatePseudo)
  {
    global $db;

    $query = "UPDATE users
              SET pseudo = :updatePseudo
              WHERE id = '{$_SESSION['id']}'
              " ;
    $preparedUpdateQuery = $db->prepare($query);
    $preparedUpdateQuery->execute(array(
      "updatePseudo" => $updatePseudo
    ));
  }
  // function to update the user email
  function updateUserEmail($updateEmail)
  {
    global $db;

    $query = "UPDATE users
              SET email = :updateEmail
              WHERE id = '{$_SESSION['id']}'
              " ;
    $preparedUpdateQuery = $db->prepare($query);
    $preparedUpdateQuery->execute(array(
      "updateEmail" => $updateEmail
    ));
  }
 ?>
