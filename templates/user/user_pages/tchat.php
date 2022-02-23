<?php
  session_start();
  if(!$_SESSION['id']) {
    header('Location: ../index.php');
  }
  $receiverSession = $_GET['name'];
  $_SESSION['name'] = $receiverSession;
?>

      <div class="container">

            <!-- Diplay the right content -->
            <div class="displayTchatCore">
                <div class="FriendTchatName">
                    <p><?= $_SESSION['name']?></p>
                </div>
                <div class="slideMessagesCore">

                      <div class="sendMessage">

                      </div>

                      <div class="recieveMessage">

                      </div>


                </div>

                <div class="sendMessageForm">
                    <form  method="post" class="myForm">
                      <div class="FlieldsContainer">
                        <textarea class="messageTextField" name="my_message"></textarea>

                        <button class="btn waves-effect waves-light" type="submit" name="submitM">Send
                            <i class="material-icons right">send</i>
                        </button>


                      </div>

                    </form>

                </div>




            </div>
          </div>


      </div>

      <div class="status">

      </div>


<script src="js/tchat.js"></script>
<style>
    .displayTchatCore
    {
      position: relative;
      top: 70px;
    }

    .messengerTchatBody {
      display: flex;
    }

    /* Style the right content ------------------------------------------------------------------- */
    .displayTchatCore {
      background-color: #2e2e2e;
      width: 956px;
      overflow: hidden;
    }

    .displayTchatCore .FriendTchatName {
      background-color: #F2F2F2;
      position: relative;
      top: -20px;
      height: 60px;
      line-height: 55px;
      text-align: center;
      color: #4e4e4e;
      font-family:'Titillium Web', sans-serif;
      font-size: 20px;
      margin-bottom: 10px;
    }
    .displayTchatCore .sendMessage{
        position: relative;
        left: 500px;
    }

    .displayTchatCore .sendMessage p {

        background-color: #F4F4F4;
        padding: 10px 10px;
        text-align: left;
        border-radius: 20px 20px;
        width: 400px;
        font-family:'Titillium Web', sans-serif;
        color: #0E2A2C;
    }

    .displayTchatCore .recieveMessage{
        position: relative;
        left: 70px;
    }

    .displayTchatCore .recieveMessage p {

        background-color: #EDDD65;
        padding: 10px 10px;
        text-align: left;
        border-radius: 20px 20px;
        width: 400px;

        font-family:'Titillium Web', sans-serif;
        color: #0E2A2C;

    }

    .displayTchatCore .slideMessagesCore {

      background-color: #473E0A;
      height: 462px;
      overflow-y: auto;
      overflow-x:hidden;
      position: relative;
      top: -29px;
    }
    .sendMessageForm {
      height: 30px;
    }
    .sendMessageForm .messageTextField
    {
      width: 100%;
      height: 40px;
      position: relative;
      border-radius: 20px 20px;
      width: 800px;
      background-color: #F4F4F4;
      border: 1px solid #B5AE84;
      padding: 10px 20px;
      font-family:'Titillium Web', sans-serif;
      margin-right: 10px;
    }

    .FlieldsContainer
    {
      display: flex;
      padding-bottom: 20px;
      position: relative;
      top: -20px;
      left: 5px;
    }
    .sendMessageForm .btn {
        background-color:#F4F4F4;
        height: 40px;
        border-radius: 20px 20px;
        color: #2e2e2e;

    }




</style>
