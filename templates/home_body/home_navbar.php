<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <div class="container">

      <a class="navbar-brand" href="#">SO.NET</a>

      <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline my-2 my-lg-0" action="index.php?page=home" method="post">
          <input class="form-control mr-sm-2" type="email" name="login_email" placeholder="Email" aria-label="Email">
          <input class="form-control mr-sm-2" type="password" name="login_password" placeholder="Password" aria-label="Password">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="login">Login</button>
        </form>
    </div>
  </div>
</nav>



<!-- some CSS-->

<style media="screen">
  .navbar .navbar-brand
  {
    font-family: 'Titillium Web', sans-serif;
    font-size: 30px;
    color: #4e4e4e;
  }
  .navbar
  {

    border-bottom: 2px solid #e2e2e2;
  }
</style>
