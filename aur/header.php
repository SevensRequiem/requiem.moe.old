<div class="header-block">
<?php
if(session('access_token')) {
    $user = apiRequest($apiURLBase);
    $av = "https://cdn.discordapp.com/avatars/" . $user->id . "/" . $user->avatar . ".png";
    $userid = $user->id;
    $json_options = [
      "http" => [
        "method" => "GET",
        "header" => "Authorization: Bot NjU4ODUyMzkxMTQ3NTM2Mzg0.XgFyNg.Wpc7PUpKeE5CRpZWjqbl9xFcRBs"
      ]
    ];
    
    $json_context = stream_context_create($json_options);
    
    $json_get     = file_get_contents('https://discordapp.com/api/guilds/509327631313928193/members?limit=1000', true, $json_context);
    
    $json_decode  = json_decode($json_get, true);
    

    echo '<div class="welcome">';
    echo '<h4>Welcome, ' . $user->username . ' Members: ' . count($json_decode) . '</h4>';
    echo '</div>';
    echo '<ul class="dd-menu">';
    echo '<li><a class="hlink2" href="?action=logout" data-target="logout" id="p5">Logout</a></li>';
    echo '</div>';
    echo '<ul class="dd-menu">';
    echo '<li><a id="hlink" href="#" data-target="info" id="p4">INFO</a></li>';
    echo '<hr>';
    echo '<li><a class="hlink2" href="https://discord.gg/jcYUwP5"  data-target="discord" target="_blank" id="p1">Discord</a></li>';
    echo '<li><a id="hlink" href="#" data-target="servers" id="p2">Servers</a></li>';
    echo '<li><a id="hlink" href="#" data-target="patreon" id="p3">Patreon</a></li>';
    $staffid = array("222915863387308034", "410115099634696192", '349100871755235328', '470180449163935744', '332355765220147200', '633019646676566027', '208443814661062657', '253638392300961793', '435931277384744971', '395786928697638922', '186255367770996736', '409474205848174593');
        if (in_array($userid, $staffid)) {
          echo '<li><a id="hlink"href="#" data-target="panels/csgo/rcon" id="p10">AP</a></li>';
        }
 } else {
  $json_options = [
    "http" => [
      "method" => "GET",
      "header" => "Authorization: Bot NjU4ODUyMzkxMTQ3NTM2Mzg0.XgFyNg.Wpc7PUpKeE5CRpZWjqbl9xFcRBs"
    ]
  ];
  
  $json_context = stream_context_create($json_options);
  
  $json_get     = file_get_contents('https://discordapp.com/api/guilds/509327631313928193/members?limit=1000', true, $json_context);
  
  $json_decode  = json_decode($json_get, true);
  

    echo '<div class="welcome">';
    echo '<h4>Welcome User: Guest! Members: ' . count($json_decode) . '</h4>';
    echo '</div>';
    echo '<ul class="dd-menu">';
    echo '<li><a class="hlink2" href="?action=login" data-target="login" id="p5">Login</a></li>';
    echo '<li><a id="hlink" href="#" data-target="info" id="p4">INFO</a></li>';
    echo '<hr>';
    echo '<li><a class="hlink2" href="https://discord.gg/jcYUwP5"  data-target="discord" target="_blank" id="p1">Discord</a></li>';
    echo '<li><a id="hlink" href="#" data-target="servers" id="p2">Servers</a></li>';
    echo '<li><a id="hlink" href="#" data-target="patreon" id="p3">Patreon</a></li>';
}
?>
</ul>
</div>