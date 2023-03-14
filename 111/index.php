<!DOCTYPE html>
<html>
    <!--HEAD-->
<head>
    <!--META-->
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=0.7">
<meta property="og:title" content="XaTuring">
<meta property="og:description" content="XaTuring Lives!">
<title>XaTuring.live</title>
    <!--CSS-->
<link rel="stylesheet" href="assets/css/reset.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" type="text/css" href="assets/css/starfield.css">
    <!--SCRIPTS-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/howler.min.js"></script>
<script src="assets/js/gl-matrix.js"></script>
<script src="assets/js/starfield.js"></script>
    <!--AUDIO-->
    <audio autoplay loop id="g">  
        <source src="assets/g.mp3" type="audio/mp3">  
</audio>  
<audio autoplay loop id="p">  
        <source src="assets/p.mp3" type="audio/mp3">  
</audio>  
<audio autoplay id="r">  
        <source src="assets/r.mp3" type="audio/mp3">  
</audio>  
<script>
  var audio = document.getElementById("g");
  audio.volume = 0.8;
</script>
<script>
  var audio = document.getElementById("p");
  audio.volume = 0.05;
</script>
<script>
  var audio = document.getElementById("r");
  audio.volume = 0.7;
</script>
</head>
    <!--BODY-->
<body>
<canvas id="starfield" width="1171" height="941"></canvas>
<div id="static"></div>
<div class="overlay2"></div>
<?php require 'header.php';?>
</div>
</body></html>
    <!--made by requiem#0666-->