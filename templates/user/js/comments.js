$(document).ready(function() {

  getComments();

  $('.commentForm').submit(function() {
    var comment = $('.replayCommentArea').val();

    $.post('ajax/commentInsert.php', {replayCommentArea: comment}, function(data) {
      $('.statusDisplay').html(data);
      $('.replayCommentArea').val('');
      getComments();
    });
      return false;
  });

    setInterval(getComments, 1000);

  function getComments() {
    $.post('ajax/commentsDisplay.php', function(data) {
        $('.commentsContainer').html(data);
    });
  }




});
