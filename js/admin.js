/**
 * Created by shikon on 30.03.17.
 */
$(document).ready(function () {
  $('.used_promo input, .used_promo button').click(function() {
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
  } );
});


function stdAjax(data, url, $object, err_cb) {
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
        } else {
          $icon
            .removeClass('spinning')
            .removeClass('glyphicon-repeat')
            .addClass('hell-orange')
            .addClass('glyphicon-thumbs-down');
          if(typeof err_cb == 'function') {
            err_cb(data, $object, $indicator);
          } else {
            stdErrorCb(data, $object, $indicator);
          }
        }
      } catch (e) {
        swal({
          title: "Ошибка! :(",
          text: "Некорректный ответ сервера",
          type: "warning",
          confirmButtonText: "OK",
          showCancelButton: false,
          allowOutsideClick : true
        });
        if(typeof err_cb == 'function') {
          err_cb(data, $object, $indicator);
        } else {
          stdErrorCb(data, $object, $indicator);
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
        err_cb(data, $object, $indicator);
      } else {
        stdErrorCb(data, $object, $indicator);
      }
      console.dir(ans);
      console.dir(err);
    }
  });

}

function stdErrorCb(data, $object, $indicator) {
  if(typeof $object != 'undefined') {
    $object = $($object);
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
