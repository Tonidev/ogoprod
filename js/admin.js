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

  initButtons();

});

function initButtons() {

  $('.albums-form button').off('click').on('click' , function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var $panel = $this.parents('.albums-form');
    var $form = $this.parents('form');
    var data = $form.serializeArray();
    data.push({name : 'ajax', value :'ajax'});
    if($this.hasClass('add')) {
      stdAjax(data, null, $this, null, function (data) {
        var $clone  = $panel.clone();
        $clone.find('input[name=id]').val(data.id);
        $clone.find('.panel-heading').children().toggleClass('hidden');
        $clone.find('input[name=func]').val('edit');
        $clone.find('button.add').removeClass('add').addClass('edit').text('Зберегти');
        $clone.appendTo($('.album-list-panel'));
        initButtons();
      });
    } else {
      stdAjax(data, null, $this, null, function (data) {
        $panel.find('.panel-title').text(data.name);
      });
    }
  });


  $('.toggle_next').off('click').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $this.next().toggle();
  } );

  $('.toggle_siblings').off('click').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $this.prev().toggle();
    $this.next().toggle();
  } );


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

function stdAjax(data, url, $object, err_cb, success_cb) {
  if(typeof data == 'undefined') {
    data = {ajax : 'ajax'};
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
  $.ajax({
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
  });

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
