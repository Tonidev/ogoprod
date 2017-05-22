/**
 * Created by shikon on 30.03.17.
 */
$(document).ready(function () {
  $('.used_promo button').click(editPromoHandler);
  $('.used_promo input').change(editPromoHandler);

  $('.add_promo button').click(function() {
    var $this = $(this);
    var $input = $this.parents('tr').find('input[name=code]');
    var data = {
      ajax : 'ajax',
      func : 'addPromo',
      code : $input.val()
    };
    stdAjax(data, null, $input);
  });

  $('.mark_comment').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var data = {
      ajax : 'ajax',
      func : 'markComment',
      id : $this.data('id'),
      status : $this.data('status')
    };
    stdAjax(data, null, $this, null, function () {
      $this.parents('.comment').remove();
    });
  });

  $(window).on('mouseup', function(e) {
    if(typeof window.position_increase_interval != 'undefined') {
      clearInterval(window.position_increase_interval);
      delete window.position_increase_interval;
      e.preventDefault();
      e.stopPropagation();
    }
    if(typeof window.position_decrease_interval != 'undefined') {
      clearInterval(window.position_decrease_interval);
      delete window.position_decrease_interval;
      e.preventDefault();
      e.stopPropagation();
    }

    if(typeof window.positioned_panel == 'undefined') {
      return;
    }
    var $panel = window.positioned_panel;
    delete window.positioned_panel;
    var $album = $panel.parents('.album-list');
    var indexes = [];
    $album.find('.album-item').each(function (i, el) {
      var $el = $(el);
      indexes.push({
        id : $el.find('input[name=id]').val(),
        position : $el.index()
      });
    });
    var data = {
      ajax : 'ajax',
      func : 'updatePositions',
      indexes : indexes
    };
    stdAjax(data, null, $panel);
    initButtons();
  });

  $('#ajax_image_upload_form').submit(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var data = new FormData($this[0]);
    stdAjax(data, $this.attr('action'), $this.find('button'), null, function (res) {
      var $popup = $('#ajax_image_upload_popup');
      if(!$popup.length) {
        $popup = $('<div id="ajax_image_upload_popup"></div>');
        $popup.appendTo('#ajax_image_upload_form');
      }
      var $id_pre = $popup.find('#ajax_image_upload_id_pre');
      if(!$id_pre.length) {
        $id_pre = $('<div id="ajax_image_upload_id_pre">ID фото</div>');
        $id_pre.appendTo($popup);
      }
      var $id = $popup.find('#ajax_image_upload_id');
      if(!$id.length) {
        $id = $('<div id="ajax_image_upload_id"></div>');
        $id.appendTo($popup);
      }

      var $url_pre = $popup.find('#ajax_image_upload_url_pre');
      if(!$url_pre.length) {
        $url_pre = $('<div id="ajax_image_upload_url_pre">Фото повного розміру</div>');
        $url_pre.appendTo($popup);
      }
      var $url = $popup.find('#ajax_image_upload_url');
      if(!$url.length) {
        $url = $('<div id="ajax_image_upload_url"></div>');
        $url.appendTo($popup);
      }
      var $url_mini_pre = $popup.find('#ajax_image_upload_url_mini_pre');
      if(!$url_mini_pre.length) {
        $url_mini_pre = $('<div id="ajax_image_upload_url_mini_pre">Мініатюра</div>');
        $url_mini_pre.appendTo($popup);
      }
      var $url_mini = $popup.find('#ajax_image_upload_url_mini');
      if(!$url_mini.length) {
        $url_mini = $('<div id="ajax_image_upload_url_mini"></div>');
        $url_mini.appendTo($popup);
      }

      var $msg = $popup.find('#ajax_image_upload_msg');
      if(!$msg.length) {
        $msg = $('<div id="ajax_image_upload_msg"></div>');
        $msg.appendTo($popup);
      }

      $id.text(res.id);
      $url.text(res.url);
      $url_mini.text(res.url_mini);

      // selectText($url);
      // try {
      //   var successful = document.execCommand('copy');
      //   $msg.text(successful ? 'URL фото сбережено у буфері обміну' : 'Ви можете скопіювати URL фото для додавання його до тексту');
      // } catch (err) {
      //   console.log('Oops, unable to copy');
      // }

      var urlClickHandler = function(e) {
        var $this = $(this);
        selectText($this);
        try {
          var successful = document.execCommand('copy');
          $msg.text(successful ? 'URL фото сбережено у буфері обміну' : 'Ви можете скопіювати URL фото для додавання його до тексту');
        } catch (err) {
          console.log('Oops, unable to copy');
        }
      };

      $($url).off('click').on('click', urlClickHandler );
      $($url_mini).off('click').on('click', urlClickHandler );

      $url.click();

    }, true);
  } );

  $('.translit').each(function (i, el) {
    var $el = $(el);
    var $source = $el.find('[data-target]');
    var $target = $el.find('[data-source]');
    var target = $source.data('target');
    var source = $target.data('source');
    $source.liTranslit({
      elAlias: $target,
      reg: '"ё"="yo"'
    });
  });

  $('.post_photo').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $this.toggleClass('opened');
  } );

  $('.post.panel .delete').click(function(e) {
    e.preventDefault(); e.stopPropagation(); var $this = $(this);
    var $post = $this.parents('.post');
    stdAjax({
      func : 'delete',
      id : $post.data('id'),
      ajax : 'ajax'
    },null, $this, null, function () {
      $post.remove();
    });
  } );

  initButtons();

});

function initButtons() {

  $('.albums-form button').off('click').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var $panel = $this.parents('.albums-form');
    var $form = $this.parents('form');
    var data = $form.serializeArray();
    data.push({name: 'ajax', value: 'ajax'});
    data.push({name: $this.attr('name'), value: $this.val()});
    if ($this.hasClass('add')) {
      stdAjax(data, null, $this, null, function (data) {
        var $clone = $panel.clone();
        $clone.find('input[name=id]').val(data.id);
        $clone.find('.panel-heading').children().toggleClass('hidden');
        $clone.find('input[name=func]').val('edit');
        $clone.find('button.add').removeClass('add').addClass('edit').text('Зберегти');
        $clone.appendTo($('.album-list-panel'));
        initButtons();
      });
    } else if ($this.val() == 'edit') {
      stdAjax(data, null, $this, null, function (data) {
        $panel.find('.badge.date').text(data.date);
        $panel.find('.panel-title').text(data.name);
      });
    } else if ($this.val() == 'delete') {
      stdAjax(data, null, $this, null, function (data) {
        $panel.remove();
      });
    }
  });


  $('.toggle_next').off('click').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $this.next().toggle();
  });

  $('.toggle_siblings').off('click').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $this.prev().toggle();
    $this.next().toggle();
  });
  $('.toggle_parent_siblings').off('click').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $this.parent().prev().toggle();
    $this.parent().next().toggle();
  });

  $('.position-increase, .position-decrease').off('mousedown').on('mousedown', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var $panel = $this.parents('.album-item');
    var $album = $this.parents('.album-list');
    window.positioned_panel = $panel;
    if ($this.hasClass('position-increase')) {
      $panel.insertAfter($panel.next());
      window.position_increase_interval = setInterval(function () {
        $panel.insertAfter($panel.next());
      }, 300);
    } else {
      $panel.insertBefore($panel.prev());
      window.position_decrease_interval = setInterval(function () {
        $panel.insertBefore($panel.prev());
      }, 300);
    }
  });

  $('.album-item .actions button').off('click').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var $form = $this.parents('form');
    var $panel = $this.parents('.album-item');
    var data = $form.serializeArray();
    data.push({name: 'ajax', value: 'ajax'});
    data.push({name: $this.attr('name'), value: $this.val()});
    stdAjax(data, null, $this, null, function (ans) {
      if ($this.val() == 'delete') {
        $panel.remove();
      }
    });
  });

  $('.albums-form').each(function (i, el) {
    $(el).find('input[name=name]').liTranslit({
      elAlias: $(el).find('input[name=chpu]'),
      reg: '"ё"="yo"'
    });
  });

}

function editPromoHandler() {
  var $this = $(this);
  if($this.is(':checkbox')) {
    var value = $this.is(':checked');
  } else {
    value = $this.val();
  }
  var name = $this.attr('name');
  var id = $this.parents('tr').data('id');
  var data = {
    ajax : 'ajax',
    func : 'editPromo',
    id : id,
    param : name,
    value : value
  };
  stdAjax(data, null, $this);
}

function stdAjax(data, url, $object, err_cb, success_cb, filetransfer) {
  if(typeof data == 'undefined') {
    data = {ajax : 'ajax'};
  }
  if(typeof filetransfer == 'undefined') {
    filetransfer = false;
  }
  if(typeof url == 'undefined' || !url || !url.length) {
    url = null;
  }
  if(typeof $object == 'undefined') {
    $object = $(':focus');
  }

  var $indicator = $('<li></li>');
  var $icon = $('<a class="glyphicon glyphicon-repeat spinning"></a>');
  $icon.prependTo($indicator);
  $indicator.prependTo('#navbar ul');
  var ajaxParams = {
    url : url,
    data : data,
    type : 'post',
    success : function (ans) {
      try {
        ans = JSON.parse(ans);
        if(ans.success) {
          $icon
            .removeClass('spinning')
            .removeClass('glyphicon-repeat')
            .addClass('aquamarine')
            .addClass('glyphicon-thumbs-up');
          setTimeout(function () {
            $indicator.remove();
          }, 2000);

          if(typeof success_cb == 'function') {
            if(typeof ans.data == 'undefined') {
              ans.data = null;
            }
            success_cb(ans.data);
          }

        } else {
          $icon
            .removeClass('spinning')
            .removeClass('glyphicon-repeat')
            .addClass('hell-orange')
            .addClass('glyphicon-thumbs-down');
          if(typeof err_cb == 'function') {
            err_cb(data, $object, $indicator, ans);
          } else {
            stdErrorCb(data, $object, $indicator, ans);
          }
        }
      } catch (e) {
        $icon
          .removeClass('spinning')
          .removeClass('glyphicon-repeat')
          .addClass('hell-orange')
          .addClass('glyphicon-thumbs-down');
        swal({
          title: "Ошибка! :(",
          text: "Некорректный ответ сервера",
          type: "warning",
          confirmButtonText: "OK",
          showCancelButton: false,
          allowOutsideClick : true
        });
        if(typeof err_cb == 'function') {
          err_cb(data, $object, $indicator, ans);
        } else {
          stdErrorCb(data, $object, $indicator, ans);
        }
      }
    },
    error : function (ans, err) {
      swal({
        title: "Ошибка! :(",
        text: "Не удалось получить данные.",
        type: "warning",
        confirmButtonText: "OK",
        showCancelButton: false,
        allowOutsideClick : true
      });
      if(typeof err_cb == 'function') {
        err_cb(data, $object, $indicator, ans);
      } else {
        stdErrorCb(data, $object, $indicator, ans);
      }
      console.dir(ans);
      console.dir(err);
    }
  };
  if(filetransfer) {
    ajaxParams.contentType = false;
    ajaxParams.processData = false;
  }
  $.ajax(ajaxParams);
}

function stdErrorCb(data, $object, $indicator, ans) {
  if(typeof $object != 'undefined') {
    $object = $($object);
    if(typeof ans != 'undefined' &&
      typeof ans.text != 'undefined') {
      $indicator.attr('title', ans.text);
    }
    $indicator.hover(
      function () {
        $object.addClass('error-grow');
      },
      function () {
        $object.removeClass('error-grow');
      }
    );
    $indicator.click(function() {
      var $this = $(this);
      $object.removeClass('error-grow');
      $this.remove();
    });
  } else {
    $indicator.click(function() {
      var $this = $(this);
      $this.remove();
    });
  }
}

function selectText($element) {
  var doc = document
    , text = $element[0]
    , range, selection
    ;
  if (doc.body.createTextRange) {
    range = document.body.createTextRange();
    range.moveToElementText(text);
    range.select();
  } else if (window.getSelection) {
    selection = window.getSelection();
    range = document.createRange();
    range.selectNodeContents(text);
    selection.removeAllRanges();
    selection.addRange(range);
  }
}
