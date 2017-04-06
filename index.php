<html>
<? include ('header.php'); ?>
<body  oncontextmenu="return false;">

<a href="" onclick="swal({
  html : true,
  title : getSocTitle(),
  allowOutsideClick : true,
  showConfirmButton: false
}); return false;" id="but" class="button">oGo Production</a>
<DIV id="logobg">
    <div id="logotmp">
        <img id="startlogo" src="img/logo.png" alt="" oncontextmenu="return false;" >
    </div>
</DIV>
<div id="start"  width="2000" height="1200" ></div>
<script>
  function getSocTitle() {
    return '<img class="social" src="img/soc-vk.png"/><img class="social" src="img/soc-facebook.png"/><img class="social" src="img/soc-instagram.png"/><div><a href="main.php" class="button1" style="margin-right: 19%;">ВХОД</a></div>';
  }

  var backgi=1;
  setInterval(function(){backg()},8000);
  function backg()
  {
    backgi=backgi%3+1;
    var $start = $("#start");
    $start.animate({'opacity':'0'},800,function(){
      $start.css('background-image', 'url(/backgrounds/'+backgi+'.jpg)');
      $start.css('background-size', 'contain');
      $start.css('background-position', 'center');
      $start.animate({'opacity':'1'},800);});
  }
</script>
</body>
</html>
