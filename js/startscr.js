$(document).ready(function () {

  $('.port_album').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $('.port-popup[data-status=' + $this.data('status') + ']').show();
  });


  $('.port_popup_close').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $('.port-popup').hide();
  });

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

  $('.photo:not(.gallery-photo) img, .albumini .mini-img, .port1 img').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var src = $this.attr('href');
    $('#photo_popup_img').attr('src', src);
    $('#photo_popup_comments').css('opacity', 0);
    $photo_popup = $('#photo_popup');
    var  id_photo = $this.data('id');
    $photo_popup.data('id_photo', id_photo);
    $photo_popup.find('.comment').hide();
    $photo_popup.find('.comment[data-id_photo=' + id_photo + ']').show();
    $photo_popup.show();
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
                      showCancelButton: false,
                      allowOutsideClick : true

                    });
                  } else {
                    var $newComment = $(data);
                    $newComment.appendTo("#photo_popup_comments_list");
                    $('#add_comment textarea').val('');
                  }
                },
                error : function (data, err) {
                  swal({
                    title: "Ошибка! :(",
                    text: "Не удалось получить данные.",
                    type: "warning",
                    confirmButtonText: "OK",
                    showCancelButton: false,
                    allowOutsideClick : true
                  });
                  console.dir(data);
                }
              });
          }
        });
      }
    });

  });

  $('select').dropdown();

  $('.main #vvod .send').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var data = {
      ajax : 'ajax',
      func : 'add_order'
    };
    $('#vvod input, #vvod select').each(function (i, el) {
      var $el = $(el);
      data[$el.attr('name')] = $el.val()
    });
    add_order_ajax(data);
  });

  $('.main #vvod .send2').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var data = {
      ajax : 'ajax',
      func : 'add_order'
    };
    $('#vvod input, #vvod select').each(function (i, el) {
      var $el = $(el);
      data[$el.attr('name')] = $el.val()
    });
    VK.Auth.login(function (vk_session) {
      if(vk_session.session) {
        var user = vk_session.session.user;
        data.name = user.first_name + ' ' + user.last_name;
        data.vk_id = user.id;
        add_order_ajax(data);
      }
    });

  });

  $('.main #vvod input[name=code]').change(function(e) {
    var $this = $(this);
    var $select = $('#vvod select');
    if($this.val().length < 4) {
      $select.parent().show();
      $select.find('option').show();
      $('#service_text').text('');
      $('#discount_text').text('');
    } else {
      var data = {
        ajax : 'ajax',
        func : 'checkCodeServices',
        code : $this.val()
      };
      $.ajax({
        url : '/add_order.php',
        type : 'post',
        data : data,
        success : function (data) {
          try {
            data = JSON.parse(data);
            if(typeof data.success != 'undefined' &&
                data.success
            ) {
              if(typeof data.data != 'undefined') {
                if(typeof data.data.all != 'undefined' && data.data.all) {
                  $select.parent().show();
                  $select.find('option').show();
                  $('#service_text').text('');
                  $('#discount_text').text('');
                } else {
                  $.each(data.data.services, function (i, el) {
                    $select.val(el.id);
                    $('#discount_text').text(el.discount);
                    $select.dropdown("update");
                    $select.parent().hide();
                    $('#service_text').text(el.name);
                  });
                }
              }
            } else {
              $select.parent().show();
              $select.find('option').show();
              $('#service_text').text('');
              $('#discount_text').text('');
            }
          } catch (e) {
            $select.parent().show();
            $select.find('option').show();
            $('#service_text').text('');
            $('#discount_text').text('');

          }
        },
        error : function (data, err) {
          $select.show();
          $select.find('option').show();
        }
      });
    }
  });
});

function proverka(tel) {
  tel.value = tel.value.replace(/[^\d,]/g, '');
}

function add_order_ajax(data) {
  $.ajax({
    url : '/add_order.php',
    data : data,
    type : 'post',
    success : function (data) {
      try {
        data = JSON.parse(data);
        if(data.success) {
          var msg = (typeof data.msg == 'undefined')
            ? "Заявка успешно отправлена."
            : data.msg;
          swal({
            title: "Успех!",
            text: msg,
            type: "success",
            confirmButtonText: "OK",
            showCancelButton: false,
            allowOutsideClick : true
          });
        } else {
          var msg = (typeof data.msg == 'undefined')
            ? "Заявка не отправлена."
            : data.text;
          swal({
            title: "Ошибка! :(",
            text: msg,
            type: "warning",
            confirmButtonText: "OK",
            allowOutsideClick : true,
            showCancelButton: false
          });
        }
      } catch (e) {
        swal({
          title: "Ошибка! :(",
          text: "Не удалось получить данные.",
          type: "warning",
          confirmButtonText: "OK",
          allowOutsideClick : true,
          showCancelButton: false
        });
      }
    },
    error : function (data, err) {
      swal({
        title: "Ошибка! :(",
        text: "Не удалось получить данные.",
        type: "warning",
        confirmButtonText: "OK",
        allowOutsideClick : true,
        showCancelButton: false
      });
      console.dir(data);
    }
  });

}

