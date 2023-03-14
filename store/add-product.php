<?php
include "header.php";
include "assets/require_admin_logged_in.php";
?>

<style>
input[type=text], input[type="email"], textarea {
  width: 70%;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 8px;
  font-size: 16px;
  background-color: white;
  background-position: 10px 10px; 
  background-repeat: no-repeat;
}

.form-control {
  padding: 12px 20px 12px 30px;
}

.price-input {
  width: 70%;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 8px;
  font-size: 16px;
  background-color: white;
  background-position: 10px 10px; 
  background-repeat: no-repeat;
  padding: 12px 20px 12px 4px;
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

<script>
    
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       
</script>

<?php
if (isset($_POST['submit'])){
$hide_form = 'display: none;';

$product_name_input = $_POST['product_name_input'];
$product_description_input = $_POST['product_description_input'];
$product_image_input = $_POST['product_img_input'];
$product_price_input_raw = $_POST['product_price_input'];
$product_price_input_raw_2 = round($product_price_input_raw, 2);
$product_price_input = number_format((float)$product_price_input_raw_2, 2, '.', '');
$random_product_id = rand(1000000,9999999);


$add_new_product = "INSERT INTO website_products (product_id, name, description, price, image_url) VALUES ('$random_product_id', '$product_name_input', '$product_description_input', '$product_price_input', '$product_image_input')";
mysqli_query($conn, $add_new_product);

$new_product_table_name = $random_product_id.'_stock';
$create_new_product_table = "CREATE TABLE $new_product_table_name (stock_id int(10) AUTO_INCREMENT PRIMARY KEY, stock_product varchar(500), available varchar(65) DEFAULT 'yes', transaction_id varchar(100))";
mysqli_query($conn, $create_new_product_table);

    echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">Contact Us</h2></center>';
    echo '<center><font color="green" class="alert no-select">New Product Successfully Added! Redirecting...</font></center>';
    echo '<center><a href="admin-panel.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
echo '<meta http-equiv="refresh" content="0; url=admin-panel.php">';

}//END IF FORM IS SUBMITTED

?>

<center>
<div class="container" style="padding-top: 110px; width: 40%; <?php echo $hide_form; ?>">

<form action="" method="POST">
          <center><h2 style="padding-bottom: 20px; font-size: 25px;">Add Product</h2></center>
      <br>
  <div class="form-group">
    <label for="product_name_input">Product Name</label><br>
    <input required autocomplete="off" type="text" class="form-control" id="product_name_input" name="product_name_input" placeholder="Enter Product Name">
  </div>
  
    <div class="form-group">
    <label for="product_description_input">Product Description</label><br>
    <textarea autocomplete="off" required class="form-control" id="product_description_input" name="product_description_input" rows="4" placeholder="Write Your Description Here"></textarea>
  </div>

  <div class="form-group">
    <label for="product_img_input">Product Image URL</label><br>
    <input required autocomplete="off" type="text" class="form-control" id="product_img_input" name="product_img_input" placeholder="Enter Product Image URL"><br>
    <small id="pricelHelp" class="form-text text-muted">Upload image to imgur.com or postimages.org, and paste link here (ex: https://i.imgur.com/V4kfJkS.png)</small>
  </div>
  
  <div class="form-group">
          <label for="product_price_input">Product Price</label><br>
  <div class="input-group" style="width: 150px;">
  <span class="input-group-addon">$</span>
    <input required type="text" onkeypress="return isNumberKey(event)" name="product_price_input" id="product_price_input" aria-describedby="priceHelp" autocomplete="off" class="form-control price-input" placeholder="Price"/>
</div>
    <small id="pricelHelp" class="form-text text-muted">We only allow prices to contain 2 decimals (ex: $5.78)</small>
</div>

  <br>
  <center><button id="submit" name="submit" type="submit" class="btn btn-primary">Add Product</button></center>
</form>
<br>

</div>
</center>

<?php
include "footer.php";
?>