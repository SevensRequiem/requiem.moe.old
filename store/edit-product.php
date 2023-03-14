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

<?php

$post_product_id = $_GET['selected_product'];

$verify_product_id = mysqli_query($conn, "SELECT * FROM website_products WHERE product_id='$post_product_id'");
while($row = mysqli_fetch_array($verify_product_id)){
$product_price = $row["price"];
$product_name = $row["name"];
$product_img_url = $row["image_url"];
$product_description = $row["description"];
$product_active = $row["active"];

if($product_active == "yes") {
    $active_checked = "checked";
}//END IF PRODUCT IS ACTIVE

}//END WHILE VERIFY_PRODUCT_ID

if($product_price == "") {
echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">Contact Us</h2></center>';
    echo '<center><font color="red" class="alert no-select">No Vaild Product Selected! Redirecting</font></center>';
    echo '<center><a href="admin-panel.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
echo '<meta http-equiv="refresh" content="0; url=edit-products.php">';
exit();
}// PRODUCT IS NOT VALID
?>

<?php
if (isset($_POST['submit'])){

$hide_form = 'display: none;';

$post_product_id = $_POST['post_product_id'];

$product_active_edit = $_POST['defaultCheck1'];
$product_name_edit = $_POST['product_name_edit'];
$product_description_edit = $_POST['product_description_edit'];
$product_img_edit = $_POST['product_img_edit'];
$product_price_edit_raw = $_POST['product_price_edit'];
$product_price_edit_raw_2 = round($product_price_edit_raw, 2);
$product_price_edit = number_format((float)$product_price_edit_raw_2, 2, '.', '');

if($product_active_edit !== "yes") {
    $product_active_edit = "no";
}//END 

$edit_selected_product = "UPDATE website_products SET name='$product_name_edit', description='$product_description_edit', price='$product_price_edit', active='$product_active_edit', image_url='$product_img_edit' WHERE product_id='$post_product_id'";
mysqli_query($conn, $edit_selected_product);

echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">Contact Us</h2></center>';
    echo '<center><font color="green" class="alert no-select">Product Successfully Updated! Redirecting...</font></center>';
    echo '<center><a href="admin-panel.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
echo '<meta http-equiv="refresh" content="0; url=admin-panel.php">';

}//END IF FORM IS SUBMITTED
?>

<center>
<div class="container" style="padding-top: 110px; width: 40%; <?php echo $hide_form; ?>">
    
<form action="" method="POST">
          <center><h2 style="padding-bottom: 20px; font-size: 25px;">Edit Product</h2></center>
      <br>
  <div class="form-group">
    <label for="product_name_edit">Product Name</label><br>
    <input required autocomplete="off" type="text" class="form-control" id="product_name_edit" name="product_name_edit" value="<?php echo $product_name; ?>">
  </div>
  
    <div class="form-group">
    <label for="product_description_edit">Product Description</label><br>
    <textarea autocomplete="off" required class="form-control" id="product_description_edit" name="product_description_edit" rows="4"><?php echo $product_description; ?></textarea>
  </div>

    <div class="form-group">
    <label for="product_img_edit">Product Image URL</label><br>
    <input required autocomplete="off" type="text" class="form-control" id="product_img_edit" name="product_img_edit" value="<?php echo $product_img_url; ?>"><br>
    <small id="pricelHelp" class="form-text text-muted">Upload image to imgur.com or postimages.org, and paste link here (ex: https://i.imgur.com/V4kfJkS.png)</small>
  </div>
  
  <div class="form-group">
          <label for="product_price_edit">Product Price</label><br>
  <div class="input-group" style="width: 150px;">
  <span class="input-group-addon">$</span>
    <input autocomplete="off" required type="text" onkeypress="return isNumberKey(event)" name="product_price_edit" id="product_price_edit" aria-describedby="priceHelp" class="price-input" value="<?php echo $product_price; ?>"/>
</div>
    <small id="pricelHelp" class="form-text text-muted">We only allow prices to contain 2 decimals (ex: $5.78)</small>
</div>

<input class="form-check-input" type="checkbox" value="yes" id="defaultCheck1" name="defaultCheck1" <?php echo $active_checked; ?>> <label class="form-check-label" for="defaultCheck1">Active Product (If checked, product will be active and displayed.)</label>

<input type="hidden" name="post_product_id" id="post_product_id" value="<?php echo $post_product_id; ?>"/>

  <br><br>
  <center><button id="submit" name="submit" type="submit" class="btn btn-primary">Confirm Edit</button></center>
</form>
<br>

</center>

<?php
include "footer.php";
?>
