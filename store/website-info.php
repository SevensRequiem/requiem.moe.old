<?php
include "header.php";
include "assets/require_admin_logged_in.php";
?>

<style>
input[type=text], input[type="email"], input[type="password"] {
  width: 100%;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 8px;
  font-size: 16px;
  background-color: white;
  background-position: 10px 10px; 
  background-repeat: no-repeat;
  padding: 12px 20px 12px 40px;
}

.form-group{
padding-bottom: 30px;
}

.alert{
background-color: #FFFFFF;
padding-top: 8px;
padding-bottom: 8px;
padding-right: 14px;
padding-left: 14px;
border-radius: 12px;
}

button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: <?php echo $website_button_color; ?>;
  text-align: center;
  cursor: pointer;
  font-size: 18px;
  border-radius: 10px;
  padding: 12px 12px 12px 12px;
}
</style>


<?php

if (isset($_POST['submit'])){

$hide_form = 'display: none;';

$website_name_input = $_POST['website_name_input'];
$paypal_email_input = $_POST['paypal_email_input'];
$website_url_input = $_POST['website_url_input'];
$website_admin_email_input = $_POST['website_admin_email_input'];
$website_admin_password_input = $_POST['website_admin_password_input'];
$website_favicon_link_input = $_POST['website_favicon_link_input'];
$website_background_color_input = $_POST['website_background_color_input'];
$website_button_color_input = $_POST['website_button_color_input'];

$website_admin_password_input_encoded = md5($website_admin_password_input);

if($website_admin_password_input_encoded == "336311a016184326ddbdd61edd4eeb52"){
    $website_admin_password_input_encoded = $website_admin_password;
}//END IF INPUT PASSWORD IS UNCHANGED

$update_website_info_sql = "UPDATE website_info SET site_name='$website_name_input', paypal_email='$paypal_email_input', site_url='$website_url_input', admin_email='$website_admin_email_input', admin_password='$website_admin_password_input_encoded', favicon_link='$website_favicon_link_input', background_color='$website_background_color_input', button_color='$website_button_color_input' WHERE id=1";
mysqli_query($conn, $update_website_info_sql);
 echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">Update Website Info</h2></center>';
    echo '<center><font color="green" class="alert no-select">Website Info Successfully Updated! Redirecting...</font></center>';
    echo '<center><a href="admin-panel.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
echo '<meta http-equiv="refresh" content="0; url=admin-panel.php">';

}//END IF FORM IS SUBMITTED

?>
<center>
<div class="container" style="padding-top: 110px; width: 40%; <?php echo $hide_form; ?>">

<form action="" method="POST">
          <center><h2 style="padding-bottom: 20px; font-size: 25px;">Update Website Info</h2></center>
      <br>
  <div class="form-group">
    <label for="website_name_input">Website Name</label>
    <input required autocomplete="off" type="text" class="form-control" id="website_name_input" name="website_name_input" value="<?php echo $website_name; ?>">
  </div>
  
  <div class="form-group">
    <label for="paypal_email_input">PayPal Email</label>
    <input required autocomplete="off" type="email" class="form-control" id="paypal_email_input" name="paypal_email_input" value="<?php echo $website_paypal_email; ?>">
  </div>
  
    <div class="form-group">
    <label for="website_url_input">Website URL (NO 'http://' or 'https://' or 'www.' or '/' - EX: google.com)</label>
    <input required autocomplete="off" type="text" class="form-control" id="website_url_input" name="website_url_input" value="<?php echo $website_url; ?>">
  </div>
  
      <div class="form-group">
    <label for="website_admin_email_input">Admin Email</label>
    <input required autocomplete="off" type="email" class="form-control" id="website_admin_email_input" name="website_admin_email_input" value="<?php echo $website_admin_email; ?>">
  </div>
  
        <div class="form-group">
    <label for="website_admin_password_input">Admin Password</label>
    <input required autocomplete="off" type="password" class="form-control" id="website_admin_password_input" name="website_admin_password_input" value="xxxxxxxxxx">
  </div>
  
          <div class="form-group">
    <label for="website_favicon_link_input">Favicon Link</label>
    <input autocomplete="off" type="text" class="form-control" id="website_favicon_link_input" name="website_favicon_link_input" value="<?php echo $website_favicon_link; ?>">
  </div>
            <div class="form-group">
    <label for="website_background_color_input">Background Color</label><br>
    <input style="width: 50%;" autocomplete="off" type="text" class="form-control" id="website_background_color_input" name="website_background_color_input" value="<?php echo $website_background_color; ?>"><br>
    <small>Use hex colors (ex: #ffda49)</small>
  </div>
            <div class="form-group">
    <label for="website_button_color_input">Button Color</label><br>
    <input style="width: 50%;" autocomplete="off" type="text" class="form-control" id="website_button_color_input" name="website_button_color_input" value="<?php echo $website_button_color; ?>"><br>
    <small>Use hex colors (ex: #5856d5)</small>
  </div>
  
  <center><button id="submit" name="submit" type="submit" class="btn btn-primary">Update Website Info</button></center>
</form>

</div>
</center>

<?php
include "footer.php";
?>

