<?php
include "header.php";

if (isset($_POST['submit'])){
$hide_form = "display: none;";
}//END IF FORM IS SUBMITTED
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
<div class="container" style="padding-top: 110px; width: 40%; <?php echo $hide_form; ?>">
          <center><h2 style="padding-bottom: 30px; font-size: 25px;">Access Your Order</h2></center>
          <br>
          
          <form action="" method="POST">
    
  <div class="form-group">
    <label class="label" for="paypal_email_1">PayPal Email Address</label><br><br>
    <input required type="email" class="form-control" id="paypal_email_1" name="paypal_email_1" autocomplete="off" placeholder="Enter Your PayPal Email">
  </div>
  
    <div class="form-group">
    <label for="order_code_1">Order Code</label><br><br>
    <input required type="text" class="form-control" id="order_code_1" name="order_code_1" autocomplete="off" aria-describedby="orderHelp" placeholder="Enter Your Order Code"><br><br>
        <small id="orderHelp" class="form-text text-muted">You receive your order code in your email after purchasing a product.</small>
  </div>

  <center><button type="submit" name="submit" id="submit" class="btn btn-primary">Access Order</button></center>
</form>
          
          </div>
          
<?php 
if (isset($_POST['submit'])){

$post_buyer_paypal_email = $_POST['paypal_email_1'];
$post_order_code = $_POST['order_code_1'];

$counter = "0";
$count_total_stock = mysqli_query($conn, "SELECT * FROM website_orders WHERE order_code='$post_order_code' AND buyer_paypal_email='$post_buyer_paypal_email' LIMIT 1");
while($row = mysqli_fetch_array($count_total_stock)){

$counter++;

}//END WHILE COUNT_TOTAL_STOCK

$total_order_match = $counter;

if($total_order_match == "0") {
echo '<div class="container" style="padding-top: 110px; width: 40%;">';
echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">Access Your Order</h2></center>';
echo '<center><font class="alert no-select" color="red">Invalid PayPal Email Or Order Code! Try Again...</font></center>';
echo '<center><a href="access-order.php"><button style="margin-top: 30px;">Try Again</button></a></center>';
echo '</div>';
}//END IF INVALID ORDER CODE OR PAYPAL EMAIL

if($total_order_match > "0") {
    
$get_more_order_info = mysqli_query($conn, "SELECT * FROM website_orders WHERE order_code='$post_order_code' AND buyer_paypal_email='$post_buyer_paypal_email' LIMIT 1");
while($row = mysqli_fetch_array($get_more_order_info)){
$order_product_id = $row["product_id"];
$req_stock_table_name = $order_product_id.'_stock';
}//END WHILE GET_MORE_ORDER_INFO   


echo '<div class="container" style="padding-top: 110px; width: 40%;">';
echo '              <center><h2 style="padding-bottom: 20px; font-size: 25px;">Order Code: '.$post_order_code.'</h2></center>';
echo '          <br>';
echo '      <div class="form-group">';
echo '    <label for="contact_message_1">Your Order Product(s)</label><br><br>';
echo '    <textarea class="form-control" id="" name="" rows="5" readonly="readonly">';    

$get_more_stock_info = mysqli_query($conn, "SELECT * FROM $req_stock_table_name WHERE transaction_id='$post_order_code'");
while($row = mysqli_fetch_array($get_more_stock_info)){
$stock_product = $row['stock_product'];
echo $stock_product.'&#13;&#10;';
}//END WHILE GET_MORE_STOCK_INFO
echo '</textarea>';
echo '</div>';
echo '  </div>';
echo '    </div>';
    
}//END IF ORDER CODE AND PAYPAL EMAIL ARE CORRECT




}//END IF FORM IS SUBMITTED

?>
</center>

<?php
include "footer.php";
?>
