<?php
include "header.php";

if($_SESSION['admin_logged_in'] == "true"){
 echo '<meta http-equiv="refresh" content="0; url=admin-panel.php">';
    //USER IS ADMIN AND LOGGED IN
}
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

.alert{
background-color: #FFFFFF;
padding-top: 8px;
padding-bottom: 8px;
padding-right: 14px;
padding-left: 14px;
border-radius: 12px;
}
</style>

<center>

<?php

if (isset($_POST['submit'])){
$hide_form = 'display: none;';

$attempted_admin_email = $_POST['exampleInputEmail1'];
$attempted_admin_password = $_POST['exampleInputPassword1'];
$attempted_admin_password_encoded = md5($attempted_admin_password);


if($attempted_admin_email == $website_admin_email AND $attempted_admin_password_encoded == $website_admin_password){
        echo '<div class="container"  style="padding-top: 110px; width: 40%; ">';
        echo '<center><h2 style="padding-bottom: 20px; font-size: 25px;">Admin Login</h2></center>';
        echo '<center><font color="green" class="alert no-select">Admin Login Successful! Redirecting...</font></center>';
        echo '<center><a href="admin-panel.php"><button style="margin-top: 30px;">Not Loading? Click Here</button></a></center>';
        echo '</div>';
    echo '<meta http-equiv="refresh" content="0; url=admin-panel.php">';
    $_SESSION['admin_logged_in'] = "true";
}

else{
        echo '<div class="container"  style="padding-top: 110px; width: 40%; ">';
        echo '<center><h2 style="padding-bottom: 20px; font-size: 25px;">Admin Login</h2></center>';
        echo '<center><font color="red" class="alert no-select">Incorrect Admin Login Info! Try Again...</font></center>';
        echo '<center><a href="admin.php"><button style="margin-top: 30px;">Try Again</button></a></center>';
        echo '</div>';
}

}//END IF FORM IS SUBMITTED

?>

<div class="container"  style="padding-top: 110px; width: 40%; <?php echo $hide_form; ?>">

<form action="" method="POST">
  <div class="form-group">
      <center><h2 style="padding-bottom: 20px; font-size: 25px;">Admin Login</h2></center>
      <br>
    <label for="exampleInputEmail1">Email address</label><br><br>
    <input autocomplete="off" type="email" class="form-control" id="exampleInputEmail1" name="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Admin Email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label><br><br>
    <input autocomplete="off" type="password" class="form-control" id="exampleInputPassword1" name="exampleInputPassword1" placeholder="Enter Admin Password">
  </div>
  <center><button id="submit" name="submit" type="submit" class="btn btn-primary">Login</button></center>
</form>


</div>
</center>

<?php
include "footer.php";
?>