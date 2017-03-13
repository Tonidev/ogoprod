<html>
<head>
    <title>OGO-Prod.</title>
<link rel="stylesheet" href="css/style.css">
    <script src="js/jq.js"></script>
    <script>
        var backgi=1;
        setInterval(function(){backg()},8000);
        function backg()
        {
            backgi=backgi%5+1;
            $("#start").animate({'opacity':'0'},800,function(){
            $("#start").attr('src', 'backgrounds/'+backgi+'.jpg');
            $("#start").animate({'opacity':'1'},800);});
        }
    </script>
    <link rel="stylesheet" href="css/sweetalert.css">
    <script src="js/sweetalert.min.js"></script>
</head>
<body background="backgrounds/0.jpg">

<a href="" onclik="join()" id="but" class="button"/>oGo Production</a>
<div id="logotmp">
    <img id="startlogo" src="img/logo.png" >
</div>
<img id="start" src="backgrounds/1.jpg" width="2000" height="1200" >
</body>
</html>