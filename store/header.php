<?php
error_reporting(0);
session_start();
include "connect.php";

$get_website_info = mysqli_query($conn, "SELECT * FROM website_info WHERE id='1' LIMIT 1");
while($row = mysqli_fetch_array($get_website_info)){
$website_id = $row["id"];
$website_name = $row["site_name"];
$website_paypal_email = $row["paypal_email"];
$website_url = $row["site_url"];
$website_admin_email = $row["admin_email"];
$website_admin_password = $row["admin_password"];
$website_favicon_link = $row["favicon_link"];
$website_background_color = $row["background_color"];
$website_button_color = $row["button_color"];

}//END WHILE FETCH GET_WEBSITE_INFO

?>

<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title><?php echo $website_name; ?></title>
  
    <link rel="icon" type="image/png" href="<?php echo $website_favicon_link; ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lato'>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<style>
html,
body {
  height: auto;
}

body {
  font-family: "Lato", sans-serif;
  background-color: <?php echo $website_background_color; ?>;
  background-size: cover;
}

.navbar li {
  display: inline-block;
  padding: 15px 18px;
}
.navbar li a {
  color: #e8f1f2;
  text-decoration: none;
  font-size: 16px;
}
.navbar li a span.menu {
  display: block;
  width: 25px;
  height: 3px;
  background: #e8f1f2;
  position: relative;
  top: 7px;
}

.navbar li a span.menu::before, .navbar li a span.menu::after {
  content: "";
  display: block;
  width: 25px;
  height: 3px;
  background: #e8f1f2;
  position: absolute;
  left: 0;
  right: auto;
  bottom: auto;
}
.navbar li a span.menu::before {
  top: -8px;
}
.navbar li a span.menu::after {
  top: 8px;
}

.no-select {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}


@font-face {
   font-family: logo-font;
   src: url(assets/logo-font-m.otf);
   src: url(assets/logo-font-m.eot);
   src: url(assets/logo-font-m.ttf);
}


.logo-font {
   font-family: logo-font;
   color: <?php echo $website_button_color; ?>;
   text-shadow: -1px -1px 0 #FFFFFF, 1px -1px 0 #FFFFFF, -1px 1px 0 #FFFFFF, 1px 1px 0 #FFFFFF;
}
</style>


  
</head>

<body>
    
<center>
<div style="padding-top: 25px;">
<font size="10" class="logo-font no-select"><?php echo $website_name; ?></font>
</div>
</center>

  <ul class="navbar">
  <li>
    <a href="index.php"><i class="fas fa-home"></i> Home</a>
  </li>
  <li>
    <a href="contact-us.php"><i class="fas fa-info"></i> Contact Us</a>
  </li>
  <li>
    <a href="access-order.php"><i class="fas fa-eye"></i> Access Order</a>
  </li>

<?php 
if ($_SESSION['admin_logged_in'] == "true"){
  echo '<li><a href="admin-panel.php"><i class="fas fa-lock"></i> Admin Panel</a></li>';
  echo '<li><a href="admin-logout.php"><i class="fas fa-sign-out-alt"></i> Admin Logout</a></li>';
}
?>
  
  

</body>

</html>
