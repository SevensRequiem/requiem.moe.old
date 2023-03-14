<?php
include "header.php";
?>

<style>
input[type=text], input[type="email"], textarea {
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

$contact_email_1 = $_POST['contact_email_1'];
$contact_subject_1 = $_POST['contact_subject_1'];
$contact_message_1 = $_POST['contact_message_1'];

//SEND EMAIL
$to = $website_admin_email;
$subject = "Contact Form";
$txt = 'User Email: '.$contact_email_1.'<br><br> Subject: '.$contact_subject_1.'<br><br> Message: '.$contact_message_1;
$headers .= "From: admin@autosell.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

mail($to,$subject,$txt,$headers);

    echo '<div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">Contact Us</h2></center>';
    echo '<center><font color="green" class="alert no-select">Your Message Has Been Successfully Sent!</font></center>';
    echo '<center><a href="index.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div>';


}//END IF FORM IS SUBMITTED

?>   

<div class="container" style="padding-top: 110px; width: 40%; <?php echo $hide_form; ?>">
    
 
              <center><h2 style="padding-bottom: 30px; font-size: 25px;">Contact Us</h2></center>
      <br>
<form action="" method="POST">
    
  <div class="form-group">
    <label for="contact_email_1">Email Address</label><br><br>
    <input required type="email" class="form-control" id="contact_email_1" name="contact_email_1" aria-describedby="emailHelp" placeholder="Enter Your Email"><br>
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  
    <div class="form-group">
    <label for="contact_subject_1">Mesasge Subject</label><br><br>
    <input required type="text" class="form-control" id="contact_subject_1" name="contact_subject_1" placeholder="Enter The Message Subject"><br><br>
  </div>

  <div class="form-group">
    <label for="contact_message_1">Message</label><br><br>
    <textarea required class="form-control" id="contact_message_1" name="contact_message_1" rows="4" placeholder="Write Your Message Here"></textarea>
  </div>

  <center><button type="submit" name="submit" id="submit" class="btn btn-primary">Send Message</button></center>
</form>

</center>
</div>

<?php
include "footer.php";
?>
