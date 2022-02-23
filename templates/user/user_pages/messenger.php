<?php session_start();  ?>

<div class="container">

    <div class="messengerTchatBody">
      <!-- Display the left content-->
      <div class="displayFriendsSide">
          <!-- Display the messenger title-->
          <div class="MessengerHeader">
              <p> Messenger</p>
          </div>
          <!-- Display the messenger friends-->
          <div class="slider">
              <?php
                foreach (displayFriends() as $friend) {
                  ?>
                  <div class="MessengerFriendDisplay">
                      <div class="MessengerFriendPicture">
                          <img src="user_profile/<?= $friend['userProfilePic']?>" width="50px" height="50px" alt="imageProfile">
                      </div>

                      <div class="MessengerFriendName">
                          <p><?= $friend['pseudo']?></p>
                      </div>
                  </div>
                  <?php
                }
              ?>


          </div>
      </div>

      <!-- Diplay the right content -->
      <div class="displayTchatCore">
          <div class="FriendTchatName">
              <p>Ouakouak Ilyes</p>
          </div>
          <div class="slideMessagesCore">
                <div class="sendMessage">
                    <p>i send a message and i will check if it will be displayed correctly </p>
                </div>

                <div class="recieveMessage">
                    <p>i send a message and i will check if it will be displayed correctly</p>
                </div>

                <div class="sendMessage">
                    <p>i send a message and i will check if it will be displayed correctly </p>
                </div>

                <div class="recieveMessage">
                    <p>i send a message and i will check if it will be displayed correctly</p>
                </div>

                <div class="sendMessage">
                    <p>i send a message and i will check if it will be displayed correctly </p>
                </div>

                <div class="recieveMessage">
                    <p>i send a message and i will check if it will be displayed correctly</p>
                </div>


          </div>

          <div class="sendMessageForm">
              <form action="#" method="post">
                  <textarea class="messageTextField" name="message"></textarea>
                  <div class="buttonsContainer">
                      <button class="fileBtn" type="file" name="file">FILE</button>
                      <button class="sendBtn"type="submit" name="submit">SEND</button>
                  </div>
              </form>
          </div>




      </div>
    </div>


</div>






<style>

    .messengerTchatBody {
      display: flex;
    }
    /*Style the left content ------------------------------------------------------------------*/
    .displayFriendsSide {
      background-color: #F2C28C;
      width: 300px;
    }

    .displayFriendsSide .slider
    {
      overflow: auto;
      position: relative;
      top: -20px;
      height: 410px;
    }
    .displayFriendsSide .MessengerHeader
    {
      background-color: #FA7921;
      height: 60px;
      position: relative;
      top: -20px;
      line-height: 55px;
      text-align: center;
      color: #ffffff;
      font-family:'Titillium Web', sans-serif;
      font-size: 20px;
    }

    .MessengerFriendDisplay
    {
      display: flex;
      padding: 0px 10px;
      height: 62px;
      line-height: 30px;
      position: relative;
    }
    .MessengerFriendDisplay:hover
    {
      background-color: #94BC35;
    }


    .MessengerFriendDisplay .MessengerFriendPicture img
    {
      border-radius: 50px 50px;
      margin-right: 10px;
      border: 1px solid #4e4e4e;
      position: relative;
      top: 5px;
    }

    /* Style the right content ------------------------------------------------------------------- */
    .displayTchatCore {
      background-color: #E7ECEF;
      width: 596px;
      overflow: hidden;
    }

    .displayTchatCore .FriendTchatName {
      background-color: #F9B81F;
      position: relative;
      top: -20px;
      height: 60px;
      line-height: 55px;
      text-align: center;
      color: #ffffff;
      font-family:'Titillium Web', sans-serif;
      font-size: 20px;
      margin-bottom: 10px;
    }
    .displayTchatCore .sendMessage{
        position: relative;
        left: 300px;
    }

    .displayTchatCore .sendMessage p {

        background-color: #94BC35;
        padding: 1px 4px;
        text-align: left;
        border-radius: 2px 2px 2px 2px;
        width: 280px;
        font-family:'Titillium Web', sans-serif;
        color: #0E2A2C;
    }

    .displayTchatCore .recieveMessage{
        position: relative;
        left: 7px;
    }

    .displayTchatCore .recieveMessage p {

        background-color: #EDDD65;
        padding: 1px 4px;
        text-align: left;
        border-radius: 2px 2px 2px 2px;
        width: 280px;
        font-family:'Titillium Web', sans-serif;
        color: #0E2A2C;

    }

    .displayTchatCore .slideMessagesCore {
      background-color: #FFAE68;
      height: 310px;
      overflow-y: auto;
      overflow-x:hidden;
      position: relative;
      top: -29px;
    }

    .sendMessageForm .messageTextField
    {
      width: 100%;
      height: 82px;
      position: relative;
      top: -27px;
      background-color: #DCF2F0;
      border: 1px solid #B5AE84;
      padding: 10px 10px;
      font-family:'Titillium Web', sans-serif;
    }

    .sendMessageForm .buttonsContainer
    {
      width: 100%;
      height: 32px;
      background-color: #4e4e4e;
      display: flex;
      position: relative;
      top: -32px;
    }
    .sendMessageForm .sendBtn
    {
      background-color: #EC6E45;
      color: #ffffff;
      border: 1px solid #EC6E45;
      width: 100px;
      position: relative;
      left: 98px;
      font-family:'Titillium Web', sans-serif;
    }

    .sendMessageForm .fileBtn
    {
      background-color: #94BC35;
      color: #ffffff;
      border: 1px solid #94BC35;
      width: 100px;
      position: relative;
      left: 300px;
      font-family:'Titillium Web', sans-serif;
    }



</style>
