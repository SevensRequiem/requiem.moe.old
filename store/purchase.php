<?php
include "header.php";

?>

<style>
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
$post_product_id = $_POST['post_product_id'];
$requested_quantity = $_POST['requested_quantity'];

$verify_product_id = mysqli_query($conn, "SELECT * FROM website_products WHERE product_id='$post_product_id'");
while($row = mysqli_fetch_array($verify_product_id)){
$product_price = $row["price"];
$product_name = $row["name"];
$product_description = $row["description"];
$product_active = $row["active"];
$product_deleted = $row["deleted"];

$product_table_name = $post_product_id.'_stock';

}//END WHILE VERIFY_PRODUCT_ID

if($product_active !== "yes") {
echo '<meta http-equiv="refresh" content="0; url=index.php">';
    echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><font color="red" class="alert no-select">No Vaild Product Found! Redirecting</font></center>';
    echo '<center><a href="index.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
exit();    
}//END PRODUCT IS NOT ACTVE

if($product_deleted !== "no") {
echo '<meta http-equiv="refresh" content="0; url=index.php">';
    echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><font color="red" class="alert no-select">No Vaild Product Found! Redirecting</font></center>';
    echo '<center><a href="index.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
exit();    
}//END PRODUCT IS DELETED

if($product_price == "") {
echo '<meta http-equiv="refresh" content="0; url=index.php">';
    echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><font color="red" class="alert no-select">No Vaild Product Found! Redirecting</font></center>';
    echo '<center><a href="index.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
exit();
}// PRODUCT IS NOT VALID


$counter = "0";
$count_total_stock = mysqli_query($conn, "SELECT * FROM $product_table_name WHERE available='yes'");
while($row = mysqli_fetch_array($count_total_stock)){

$counter++;

}//END WHILE COUNT_TOTAL_STOCK

$total_product_stock = $counter;

if($total_product_stock < $requested_quantity){

echo    '<center><font color="red">We Do Not Have Enough Product In Stock! Redirecting</font></center>';
echo '<meta http-equiv="refresh" content="0; url=product.php?p='.$post_product_id.'">';
    
}//END IF NOT ENOUGH STOCK

?>

<style>
    
.no-drag{
user-drag: none; 
user-select: none;
-moz-user-select: none;
-webkit-user-drag: none;
-webkit-user-select: none;
-ms-user-select: none;
}

.card {
  box-shadow: 0 10px 10px 0 rgba(0, 0, 0, 0.4);
  margin: auto;
  text-align: center;
  font-family: arial;
  border-radius: 15px;
  background-color: #ffffff;
  height: auto;
}

.price {
  color: grey;
  font-size: 20px;
}

.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: <?php echo $website_button_color; ?>;
  text-align: center;
  cursor: pointer;
  width: 50%;
  font-size: 18px;
  border-radius: 15px;
  padding-bottom: 15px;
  margin-bottom: 25px;
}

.card button:hover {
  opacity: 0.7;
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

.not-allowed {cursor: not-allowed;}

.product-image{
max-width: 60%;
border-radius: 9px;
margin-top: 25px;
}

input[type="number"] {
  width: 40%;
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

.paypal-button {
    margin-bottom: 25px;
}

.product-title {
    padding-top: 25px;
}

.back-button {
  border: none;
  outline: 0;
  padding: 10px;
  color: white;
  background-color: <?php echo $website_button_color; ?>;
  text-align: center;
  cursor: pointer;
  font-size: 18px;
  border-radius: 10px;
  padding: 3px 3px 3px 3px;
}

.important-info {
  border-radius: 5px;
  border-style: solid;
  border-width: 2px;
  padding: 4px 4px 4px 4px;
  width: 40%;
  text-align: center;
}
</style>


<center>
<div class="container" style="padding-top: 110px; width: 40%;">
    
    
<div class="card">
              <center><h2 class="product-title" style="padding-bottom: 20px; font-size: 20px;">Purchase <b><?php echo $product_name; ?></b></h2></center>
              
<a href="product.php?p=<?php echo $post_product_id; ?>"><input class="back-button" disabled value="Go Back"></a>
          <br><br><br>

<center>
<div class="important-info">
<center><b>Quantity:</b> <?php echo $requested_quantity; ?></center>
<center><b>Price Each:</b> $<?php echo $product_price; ?></center>
<?php
$total_price_raw = $requested_quantity * $product_price;
$total_price_raw_2 = round($total_price_raw, 2);
$total_price = number_format((float)$total_price_raw_2, 2, '.', '');
?>
<center><b>Total Price:</b> $<?php echo $total_price; ?></center>
</div>
</center>

<center>
    
<form class="container-buy" name="_xclick" id="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input name="cmd" value="_xclick" type="hidden">
<input name="business" value="<?php echo $website_paypal_email; ?>" type="hidden">
<input name="currency_code" value="USD" type="hidden">
<input name="item_name" value="<?php echo $product_name; ?>" type="hidden">
<input name="item_number" value="<?php echo $post_product_id; ?>" type="hidden">
<input name="amount" value="<?php echo $product_price; ?>" type="hidden">
<input type="hidden" name="quantity" value="<?php echo $requested_quantity; ?>">
<input name="return" value="http://<?php echo $website_url; ?>/purchase-success.php" type="hidden">
<input name="cancel_return" value="http://<?php echo $website_url; ?>/purchase-failure.php" type="hidden">
<input name="notify_url" value="http://<?php echo $website_url; ?>/ipn.php" type="hidden">
<br><br>
 <input type="image" name="submit" src="assets/paypal-button.png" alt="PayPal - The safer, easier way to pay online" class="paypal-button">
</form>

</center>



</div>

</div>
</center>

<?php
include "footer.php";
?>
