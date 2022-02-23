<?php
    session_start();
// here is to let the user create an account
    if(isset($_POST['join']))
    {
      //variable declaration
      $pseudo = htmlspecialchars(trim($_POST['pseudo']));
      $email = htmlspecialchars(trim($_POST['email']));
      $password = sha1(htmlspecialchars(trim($_POST['password'])));
      $confirmPassword = sha1(htmlspecialchars(trim($_POST['confirmPassword'])));
      $userProfilePic = "defaultProfilePic.jpg";
      if(!empty($pseudo) && !empty($email) && !empty($password) && !empty($confirmPassword))
      {
        if($password == $confirmPassword)
        {
          //Isert data into database
          inserData($pseudo, $email, $password, $userProfilePic);
        }else{
          echo "password are not identical ";
        }

      }else{
        echo "fill all the gaps";
      }
    }

// Here is to validate the user Login
  if(isset($_POST['login']))
  {
    $email = htmlspecialchars(trim($_POST['login_email']));
    $password = sha1(htmlspecialchars(trim($_POST['login_password'])));
      if(!empty($email) && !empty($password))
      {
        checkUserExistance($email, $password);
      }else{
        echo"fill all the gaps";
      }
  }



 ?>

<body class="myHomePage">


    <div class="container">
      <div class="row justify-content-center">
        <div class="col-4">
          <form method="post" action="index.php?page=home"class="myJoinForm">
            <div class="form-group">
              <label for="pseudoField">Pseudo</label>
              <input type="text" name="pseudo" class="form-control" id="pseudoField" placeholder="Enter Pseudo">
            </div>

            <div class="form-group">
              <label for="emailField">Email </label>
              <input type="email" name="email" class="form-control" id="emailField" aria-describedby="emailHelp" placeholder="Enter email">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>

            <div class="form-group">
              <label for="passwordField">Password</label>
              <input type="password" name="password" class="form-control" id="passwordField" placeholder="Password">
            </div>

            <div class="form-group">
              <label for="repeatPasswordField">Confirm Password</label>
              <input type="password" name="confirmPassword" class="form-control" id="repeatPasswordField" placeholder="Confirm Password">
            </div>

            <button type="submit" name="join" class="btn btn-primary col-12">Submit</button>
          </form>
        </div>
      </div>

    </div>
</body>
