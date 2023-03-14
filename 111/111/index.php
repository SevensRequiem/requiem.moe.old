<!DOCTYPE html>
<html>
    <!--HEAD-->
<head>
<?php require 'discordauth.php';?>
<?php require 'scripts.php';?>
    <!--META-->
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=0.7">
<meta property="og:title" content="Aurora">
<meta property="og:description" content="Aurora Network - Coming Soon">
<meta property="og:image" content="111/assets/img/a.png">
<title>Aurora Servers</title>
    <!--CSS-->
<link rel="stylesheet" href="111/assets/css/reset.css">
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" type="text/css" href="111/assets/css/starfield.css">
    <!--SCRIPTS-->
<script src="111/assets/js/jquery.min.js"></script>
<script src="111/assets/js/howler.min.js"></script>
<script src="111/assets/js/gl-matrix.js"></script>
<script src="111/assets/js/starfield.js"></script>
    <!--AUDIO-->
<audio autoplay loop>  
        <source src="111/assets/g.mp3" type="audio/mp3">  
</audio>  
    <!--AJAX-->
<style>
    #content {
	color: #AAF;
	background-color: rgba(0, 0, 0, 0.8);
	position: relative;
	top: 12em;
	left: 50%;
	transform: translate(-50%, -50%);
	text-shadow: 0px 0px 16px #AAF;
	text-color: #AAF;
	opacity: 0.8;
	mix-blend-mode: lighten;
	padding: 0.5em;
	height: 50%;
	width: 99%;
      }
</style>
    <script>
      $(document).ready(function(){
        // Set trigger and container variables
        var trigger = $('a'),
            container = $('#content');
        
        // Fire on click
        trigger.on('click', function(){
          // Set $this for re-use. Set target from data attribute
          var $this = $(this),
            target = $this.data('target');       
          
          // Load target page into container
          container.load(target + '.php');
          
          // Stop normal link behavior
          return false;
        });
      });
    </script>
</head>
    <!--BODY-->
<body>
<canvas id="starfield" width="1171" height="941"></canvas>
<div id="static"></div>
<div class="overlay2"></div>
<?php require 'footer.php';?>
<?php require 'header.php';?>
<div id="content"></div>
</body></html>
    <!--made by requiem#0666-->