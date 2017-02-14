<?php
session_start();
require_once 'functions.php';
$user = loginCheck();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="css/input.css">
  <script src="js/jquery-3.1.1.min.js"></script>
  <script>
    $(function() {

      $('#step1 form').on('submit', function() {
        var f = $(this).parent();
        var q = $.trim($(this).find('input[name="q"]').val());
        if (q !== '') {
          var ul = f.find('ul').empty();
          var option = {
            url: 'https://www.googleapis.com/books/v1/volumes?q=' + encodeURIComponent(q),
            dataType: 'jsonp'
          };
          $.ajax(option).done(function(result) {
            $.each(result.items, function() {
              var title = $('<div>').addClass('title').text(this.volumeInfo.title);
              var thumbnail = $('<img>').attr({src: this.volumeInfo.imageLinks.thumbnail})
              var li = $('<li>')
                  .data(this)
                  .append(title)
                  .append(thumbnail)
                  .on('click', function() {
                      var book = $(this).data();
                      var thumbnail = $('<img>').attr({src: book.volumeInfo.imageLinks.thumbnail});
                      $('#step2')
                          .find('form').data(book).end()
                          .find('.title').text(book.volumeInfo.title).end()
                          .find('.thumbnail').append(thumbnail).end()
                          .show();
                      $('#step1').hide();
                  });
              ul.append(li);
            });
          });
        }
        return false;
      });

      $('#step2 form').on('submit', function() {
        var book = $(this).data();
        $(this).find('input[name="id"]').val(book.id);
        $(this).find('input[name="name"]').val(book.volumeInfo.title);
        $(this).find('input[name="thumbnail"]').val(book.volumeInfo.imageLinks.thumbnail);
      });

    });
  </script>
</head>
<body>

<?php if (!is_null($user)): ?>
  <header>
    <?= h($user['name']); ?>さんでログイン中
    <a href="logout.php">ログアウト</a>
  </header>
<?php endif; ?>

  <div id="step1">
    <form method="post">
    <input type="text" name="q"placeholder="あいまい検索">
      <button><img src="./img/search.png" alt="" class="s-img"></button>
    </form>
    <ul></ul>
  </div>

  <div id="step2">


    <form method="post" action="bookmark.php">
      <dl>
        <dt>書籍名</dt>
        <dd class="title"></dd>
        <dt>書籍画像</dt>
        <dd class="thumbnail"></dd>
        <dt>コメント</dt>
        <dd><textarea name="comment" rows="5"></textarea></dd>
        <dt>評価</dt>
        <dd>
          <select name="star">
            <option value="0" >☆☆☆☆☆</option>
            <option value="1" >★☆☆☆☆</option>
            <option value="2" >★★☆☆☆</option>
            <option value="3" >★★★☆☆</option>
            <option value="4" >★★★★☆</option>
            <option value="5" >★★★★★</option>
          </select>
        </dd>
      </dl>
      <button style="cursor:pointer">送信</button>
      <input type="hidden" name="id" value="">
      <input type="hidden" name="name" value="">
      <input type="hidden" name="thumbnail" value="">

      <div class="sample">
        <img src="img/tw.png" alt="">
        <input type="radio" name="s2" id="on" value="1" checked="">
        <label for="on" class="switch-on">share</label>
        <input type="radio" name="s2" id="off" value="0">
        <label for="off" class="switch-off">OFF</label>
      </div>
    </form>
  </div>
  
</body>
</html>

