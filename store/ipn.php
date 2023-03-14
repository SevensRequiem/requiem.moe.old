<?php
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



// Assign payment notification values to local variables
  $item_name        = $_POST['item_name'];
  $item_number      = $_POST['item_number'];
  $payment_status   = $_POST['payment_status'];
  $payment_amount   = $_POST['mc_gross'];
  $payment_currency = $_POST['mc_currency'];
  $txn_id           = $_POST['txn_id'];
  $receiver_email   = $_POST['receiver_email'];
  $payer_email      = $_POST['payer_email'];
  $quantity         = $_POST['quantity'];
//custom
  $custom      = $_POST['custom'];

$post_product_id = $item_number;

$get_product_info = mysqli_query($conn, "SELECT * FROM website_products WHERE product_id='$post_product_id'");
while($row = mysqli_fetch_array($get_product_info)){
$product_price = $row["price"];
$product_name = $row["name"];
$product_description = $row["description"];

$product_table_name = $post_product_id.'_stock';


}//END WHILE GET_PRODUCT_INFO



$trans_id = rand(10000000000,99999999999);

$legit_price_raw = $product_price * $quantity;
$legit_price_raw_2 = round($legit_price_raw, 2);
$legit_price = number_format((float)$legit_price_raw_2, 2, '.', '');

if($payment_amount == $legit_price AND $payment_status == "Completed"){
    

$select_new_stock = mysqli_query($conn, "SELECT * FROM $product_table_name WHERE available='yes' ORDER BY stock_id ASC LIMIT $quantity");
while($row = mysqli_fetch_array($select_new_stock)){
    $stock_id = $row["stock_id"];
    
$update_stock_info_sql = "UPDATE $product_table_name SET available='no', transaction_id='$trans_id' WHERE stock_id='$stock_id'";
mysqli_query($conn, $update_stock_info_sql);

}//END WHILE SELECT_NEW_STOCK

$add_new_order_row = "INSERT INTO website_orders (product_id, order_code, buyer_paypal_email, order_total) VALUES ('$post_product_id', '$trans_id', '$payer_email', '$payment_amount')";
mysqli_query($conn, $add_new_order_row);

$default_website_url = "auto-buy.ml";
//SEND EMAIL
$to = $payer_email;
$subject = $website_name.' - Order Code';
$txt = 'Thank you for purchasing! You can access your product with the order code and link below.<br><br>Order Code: '.$trans_id.'<br><br>http://'.$website_url.'/access-order.php';
$headers .= "From: orders@".$default_website_url."\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

mail($to,$subject,$txt,$headers);

}//END IF PAYMENT PRICE IS CORRECT AND PAYMENT STATUS IS COMPLETED



?>
