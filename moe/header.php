<div class="header-block">
<?php
if(session('access_token')) {
    $user = apiRequest($apiURLBase);
    $av = "https://cdn.discordapp.com/avatars/" . $user->id . "/" . $user->avatar . ".png";
    $userid = $user->id;
    
    echo '<header class="header-user-dropdown">';
    echo '	<div class="header-limiter">';
    echo '		<h1><a href="#">requiem<span>.MOE</span></a></h1>';
    echo '		<nav>';
    echo '			<a href="#">temp1</a>';
    echo '			<a href="#">temp2</a>';
    echo '			<a href="#">temp3</a>';
    echo '			<a href="#">temp4<span class="header-new-feature">new</span></a>';
    echo '		</nav>';
    echo '<h4>Welcome, ' . $user->username . '</h4>';
    echo '		<div class="header-user-menu">';
    echo '			<img src="assets/2.jpg" alt="User Image"/>';
    echo '			<ul>';
    echo '				<li><a href="#">Settings</a></li>';
    echo '				<li><a href="#">Payments</a></li>';
    echo '				<li><a <a href="?action=logout" data-target="logout" id="p9" class="highlight">Logout</a></li>';
    echo '			</ul>';
    echo '		</div>';
    echo '	</div>';
    echo '</header>';
    $staffid = array("222915863387308034", "410115099634696192", '349100871755235328', '470180449163935744', '332355765220147200', '633019646676566027', '208443814661062657', '253638392300961793', '435931277384744971', '395786928697638922', '186255367770996736', '409474205848174593');
        if (in_array($userid, $staffid)) {
          echo '<li><a id="hlink"href="#" data-target="a" id="p10">AP</a></li>';
        }
 } else {
  
    echo '    <header class="header-login-signup">';
    echo '        <div class="header-limiter">';
    echo '            <h1><a href="./index">requiem<span>.MOE</span></a></h1>';
    echo '            <nav>';
    echo '                <a href="./hub" class="btn">Hub</a>';
    echo '                <a href="#" class="btn">Store</a>';
    echo '                <a href="./scripts" class="btn">Scripts</a>';
    echo '                <a href="https://steamcommunity.com/id/SevensRequiem/" target="_blank" class="btn">Steam</a>';
    echo '                <a href="#" target="_blank" class="btn">Discord</a>';
    echo '                <a href="https://www.patreon.com/AuroraServers" target="_blank" class="btn">Patreon</a>';
    echo '                <a href="https://auroraservers.net" target="_blank" class="btn">Aurora</a>';
    echo '                <a href="./about" class="btn">About</a>';
    echo '                <a href="mailto:sevens@requiem.moe" class="btn">Contact</a>';
    echo '            </nav>';
    echo '            <ul>';
    echo '                <li><a href="?action=login" data-target="login">Login with Discord</a></li>';
    echo '            </ul>';
    echo '        </div>';
    echo '    </header>';
}
?>