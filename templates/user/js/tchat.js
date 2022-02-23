$(document).ready(function() {
//---------------------------------------call to the functions declared below-------------------------------------
    getMessages();

//-------------------------------------actions mada by buttons clicked--------------------------------------------
    // when we submit a message in a tchat form
    $('.myForm').submit(function() {
      var message = $('.messageTextField').val();

        $.post('ajax/tchatSendMessage.php',{messageTextField:message}, function(data) {
            $('.status').html(data);
            $('.messageTextField').val('');

            getMessages();
        });
        return false;
    });
//---------------------------------------------set some intervals for executions--------------------------------------
    setInterval(getMessages, 1000);

    // declared functions
    function getMessages() {
      $.post('ajax/tchatGetMessages.php', function(data) {
          $('.slideMessagesCore').html(data);
      });
    }



});
