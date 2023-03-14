<!DOCTYPE html>
<?php include 'xsc.php';?>
<head>
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> <meta http-equiv="Pragma" content="no-cache" /> <meta http-equiv="Expires" content="0" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>requiem</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="css/wow.min.js.download"></script>
    <link href="css/font-awesome.css" type="text/css" rel="stylesheet" />
    <link href="css/glitch.css" type="text/css" rel="stylesheet" />
</head>
 <!-- audio -->
 <audio id="audioplayer"> <!-- Remove the "Controls" Attribute if you don't want the visual controls -->
 </audio>
 <script>
  var lastSong = null;
  var selection = null;
  var playlist = ["assets/main/angeldust.mp3", "assets/main/october.mp3", "assets/main/flannel.mp3"]; // List of Songs
  var player = document.getElementById("audioplayer"); // Get Audio Element
  
  player.volume = 0.1;
  player.autoplay=true;
  player.addEventListener("ended", selectRandom); // Run function when song ends

  function selectRandom(){
      while(selection == lastSong){ // Repeat until different song is selected
          selection = Math.floor(Math.random() * playlist.length);
      }
      lastSong = selection; // Remember last song
      player.src = playlist[selection]; // Tell HTML the location of the new Song
  }
  selectRandom(); // Select initial song
  player.play(); // Start Song
</script>

<body oncontextmenu="return false" onselectstart="return false" onselect="return false" oncopy="return false" ondragstart="return false" ondrag="return false">
  <div class="video-container">
    <video autoplay="autoplay" loop="loop" muted>
      <source src="assets/vid/lightning2.mp4" type="video/mp4">
    </video>
  </div>
  <canvas id="canvas" width="800" height="350"></canvas>

<div id="clockDisplay" class="clockStyle"></div>
<div id="version">site version 0.3</div>
  <script>
  function renderTime() {
  var currentTime = new Date();
  var diem = "am";
  var h = currentTime.getHours();
  var m = currentTime.getMinutes();
  var s = currentTime.getSeconds();
  setTimeout('renderTime()',1000);
  if (h == 0) {
    h = 12;
  } else if (h > 12) { 
    h = h - 12;
    diem="pm";
  }
  if (h < 10) {
    h = "0" + h;
  }
  if (m < 10) {
    m = "0" + m;
  }
  if (s < 10) {
    s = "0" + s;
  }
  var myClock = document.getElementById('clockDisplay');
  myClock.textContent = h + ":" + m + ":" + s + " " + diem;
  myClock.innerText = h + ":" + m + ":" + s + " " + diem;
  }
  renderTime();
  </script>		
  <div id="center_wrap">
    <div id="byt">
    <a href="https://www.youtube.com/channel/UCWCLrljiADMzumB21isaMbg" target="_blank">youtube</a>
    </div>
        <div id="bst">
        <a href="https://steamcommunity.com/id/SevensRequiem/" target="_blank">steam</a>
        </div>
            <div id="bds">
            <a href="#" onclick="toggle_visibility('discord');">discord</a>
            </div>
                <div id="bml">
                <a href="mailto:requiem@sevens.gq" target="_blank">email</a>
                </div>
                    <div id="hub">
                    <a href="./hub">hub</a>
                    </div>
    <div id="t1">requiem</div>
    <div id="discord" hidden="true">!#0666</div>
  </div>
  <script type="text/javascript">
    <!--
        function toggle_visibility(id) {
           var e = document.getElementById(id);
           if(e.style.display == 'block')
              e.style.display = 'none';
           else
              e.style.display = 'block';
        }
    //-->
    </script>
</body>
</html>
    <!--made by requiem!#0666-->
    <!--I hate modern web design-->
    <!--If you steal code/my site(s), you a bitch-->