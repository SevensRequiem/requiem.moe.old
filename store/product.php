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
$post_product_id = $_GET['p'];

$verify_product_id = mysqli_query($conn, "SELECT * FROM website_products WHERE product_id='$post_product_id'");
while($row = mysqli_fetch_array($verify_product_id)){
$product_price = $row["price"];
$product_name = $row["name"];
$product_description = $row["description"];
$product_image = $row["image_url"];
$product_active = $row["active"];
$product_deleted = $row["deleted"];

$product_table_name = $post_product_id.'_stock';

if($product_active !== "yes") {
echo '<meta http-equiv="refresh" content="0; url=index.php">';
    echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><font color="red" class="alert no-select">No Vaild Product Found! Redirecting</font></center>';
    echo '<center><a href="index.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';

}//END IF PRODUCT IS NOT ACTIVE

if($product_deleted !== "no") {
echo '<meta http-equiv="refresh" content="0; url=index.php">';
    echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><font color="red" class="alert no-select">No Vaild Product Found! Redirecting</font></center>';
    echo '<center><a href="index.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
}//END IF PRODUCT IS DELETED

}//END WHILE VERIFY_PRODUCT_ID

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
</style>

<center>
<div class="container" style="padding-top: 60px; width: 50%;">
    
<div class="card">
<?php
$error_code = "if (this.src != 'assets/default-product.png') this.src = 'assets/default-product.png';";
?>
<img class="no-drag product-image" src="<?php echo $product_image; ?>" onerror="<?php echo $error_code; ?>">
<h1 style="font-size: 25px; padding-bottom: 10px; padding-top: 20px;"><?php echo $product_name; ?></h1>
<p><?php echo $product_description; ?></p><br>
<form action="purchase.php" method="POST">
    <label for="requested_quantity">Quantity</label><br>
    <input type="number" style="width: 125px;" class="form-control" name="requested_quantity" id="requested_quantity" min="1" max="<?php echo $total_product_stock; ?>" value="1"><br><br>
    <input type="hidden" name="post_product_id" id="post_product_id" value="<?php echo $post_product_id; ?>"/>
<p>There are currently <?php echo $total_product_stock; ?> in stock</p><br>
<?php
    if($total_product_stock == "0"){
echo '<button type="submit" name="submit" id="submit" disabled>Out of Stock</button>';
    }//END IF TOTAL STOCK IS 0
    
    else{
echo '<button type="submit" name="submit" id="submit">$'.$product_price.' each</button>';
    }//END ELSE
?>
</form>
</div>
</div></center>
<br class="hidden-br">
    
    </div>
    
    
    </form>
    
  </div>
    
</div>
</center>

<?php
include "footer.php";
?>