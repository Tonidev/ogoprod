<div id="photo_popup" data-image="">
  <div id="photo_popup_container">
    <div id="photo_popup_image">
      <span id="photo_popup_close">&times;</span>
      <img id="photo_popup_img" src="/backgrounds/3.jpg">
      <div id="photo_popup_menu">
        <? if(false) { ?>
  <div id="photo_popup_menu_btn">Комментарии</div>
<? } ?>
</div>
<div id="photo_popup_comments">
  <div id="photo_popup_comments_header">Это не мнение, я просто правду говорю</div>
  <div id="photo_popup_comments_list">
    <? foreach( $comments as $comment) { ?>
      <div class="comment" data-id_photo="<?= $comment['id_photo'] ?>">
        <div class="avatar" style="background-image: url('<?= $comment['avatar']?>')"></div>
        <div class="author"><?= $comment['author']?></div>
        <div class="text"><?= $comment['text']?></div>
      </div>
    <? } ?>
  </div>
  <div id="add_comment">
    <textarea name="comment"></textarea>
    <button class="button1" type="button">Отправить комментарий</button>
  </div>
</div>
</div>
</div>
</div>
