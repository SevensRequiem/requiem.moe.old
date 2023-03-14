
<!DOCTYPE html>
<html>
  <head>
  <?php require 'discordauth.php';?>
    <!--AUDIO-->
<audio autoplay loop id="end">  
    <source src="assets/audio/end.mp3" type="audio/mp3">  
</audio>  
<script>
  var audio = document.getElementById("end");
  audio.volume = 0.1;
</script>
  <!--title/scripts/reflinks-->
  <title>Aurora Servers</title>
  <link rel="stylesheet" href="assets\css\style.css">
  <style>
    #wrapper {
    position: fixed;
    text-align:center;
    font-size:0;
        }
    #wrapper>div{
    display:inline-block;
    text-align:left;
    vertical-align:top;
    font-size:16px;
}
    #content {
    font-family: pixel;
    position: relative;
    background-color: rgba(0, 0, 0, 0.8);
    display: inline-block;
    padding-top: 56.25%;
	top: 50%;
	left: 35%;
	transform: translate(-50%, -50%);
	text-shadow: 0px 0px 16px #AAF;
	opacity: 0.8;
	mix-blend-mode: lighten;
	padding: 0.5em;
    height: 90%;
	box-shadow: 0px 0px 32px #AAF;
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
  <body class="bg" ;="" oncontextmenu="return false" ;="">
  <canvas id="canvas"></canvas>
  <script src="assets\js\canvas.js"></script>
  <?php require 'header.php';?>
  <div id="content">
    </div>
</div>
</body>
</html>