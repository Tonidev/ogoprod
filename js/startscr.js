$(document).ready(function () {

  $('#photo_popup').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    if(!$('#photo_popup_image').find(e.target).length) {
      $this.hide();
      $('#photo_popup_menu').removeClass('opened');
    }
  });

  $('#photo_popup_close').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $('#photo_popup').hide();
    $('#photo_popup_menu').removeClass('opened');
  });

  $('.photo img').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $('#photo_popup_comments').css('opacity', 0);
    $('#photo_popup').data('id_photo', $this.data('id'));
    $('#photo_popup').show();
  });

  $('#photo_popup_menu').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $this.toggleClass('opened');
    var $comments_block = $('#photo_popup_comments');
    // $comments_block.show();
    // $comments_block.toggleClass('opened');
    if($this.hasClass('opened') ) {
      var opacity = 1;
    } else {
      opacity = 0;
    }
    $comments_block.animate({opacity : opacity});
  });

  $('#add_comment .button1').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var data = {};
    VK.Auth.login(function (vk_session) {
      if(vk_session.session) {
        var user = vk_session.session.user;
        data.author = user.first_name + ' ' + user.last_name;
        data.vk_id = user.id;
        data.text = $('#add_comment textarea').val();
        data.id_photo = $('#photo_popup').data('id_photo');
        var uid = user.id;
        VK.Api.call('users.get', {user_ids: uid, fields : 'photo_50'}, function (r) {
          if(r.response) {
            data.avatar = r.response[0].photo_50;
            $.ajax(
              {
                url : '/add_comment.php',
                data : data,
                success : function (data) {
                  if(data == 'error') {
                    swal({
                      title: "Ошибка! :(",
                      text: "Не удалось получить данные.",
                      type: "warning",
                      confirmButtonText: "OK",
                      showCancelButton: false
                    });
                  } else {
                    var $newComment = $(data);
                    $newComment.appendTo("#photo_popup_comments_list");
                  }
                },
                error : function (data, err) {
                  console.dir(data);
                }
              });
          }
        });
      }
    });

  } );

  $('select').dropdown();


});

function proverka(tel) {
  tel.value = tel.value.replace(/[^\d,]/g, '');
}

