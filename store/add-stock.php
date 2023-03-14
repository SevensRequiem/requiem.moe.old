<?php
include "header.php";
include "assets/require_admin_logged_in.php";
?>

<style>
textarea {
  width: 100%;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 8px;
  font-size: 16px;
  background-color: white;
  background-position: 10px 10px; 
  background-repeat: no-repeat;
  padding: 12px 20px 12px 20px;
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
$product_description = $row["description"];

$product_table_name = $post_product_id.'_stock';

}//END WHILE VERIFY_PRODUCT_ID

if($product_price == "") {
echo '<meta http-equiv="refresh" content="0; url=add-stocks.php">';
    echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">Add Stock To '.$product_name.'</h2></center>';
    echo '<center><font color="red" class="alert no-select">No Vaild Product Selected! Redirecting...</font></center>';
    echo '<center><a href="view-stocks.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
exit();
}// PRODUCT IS NOT VALID
?>

<?php
if (isset($_POST['submit'])){
    
$hide_form = 'display: none;';
    
$post_product_id = $_POST['post_product_id'];
$product_table_name = $post_product_id.'_stock';
$new_product_stock_raw = $_POST['new_product_stock'];

$new_product_stock_exploded = explode("\n", $new_product_stock_raw);

foreach($new_product_stock_exploded as $key) {    

$add_new_individual_stock = "INSERT INTO $product_table_name (stock_product) VALUES ('$key')";
mysqli_query($conn, $add_new_individual_stock);

}//END FOR EACH

    echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">Add Stock To '.$product_name.'</h2></center>';
    echo '<center><font color="green" class="alert no-select">New Stock Successfully Added! Redirecting...</font></center>';
    echo '<center><a href="admin-panel.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
echo '<meta http-equiv="refresh" content="0; url=admin-panel.php">';



}//END IF FORM IS SUBMITTED

?>

<center>
<div class="container" style="padding-top: 110px; width: 40%; <?php echo $hide_form; ?>">
    
              <center><h2 style="padding-bottom: 20px; font-size: 25px;">Add Stock To <b><?php echo $product_name; ?></b></h2></center>
          <br>


<form action="" method="POST">
    
  <div class="form-group">
    <label for="new_product_stock">Accounts/Serials/Codes</label><br><br>
    <textarea required class="form-control" aria-describedby="stockHelp" id="new_product_stock" name="new_product_stock" rows="6" placeholder="ONLY ONE ACCOUNT/SERIAL/CODE PER LINE"></textarea><br><br>
        <small id="stock" class="form-text text-muted">ONLY ONE ACCOUNT/SERIAL/CODE PER LINE</small>
        <input type="hidden" name="post_product_id" id="post_product_id" value="<?php echo $post_product_id; ?>"/>
  </div>
  
    <center><button type="submit" name="submit" id="submit" class="btn btn-primary">Upload New Stock</button></center>

</form>

</div>
</center>

<?php
include "footer.php";
?>