<?php
include "header.php";
include "assets/require_admin_logged_in.php";
?>


<style>
table {
  border-collapse: collapse;
  width: 80%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
  color: white;
}

thead{
  background-color: <?php echo $website_button_color; ?>;
}
</style>

<center>
<div class="container" style="padding-top: 85px; width: 100%;">
<h2 style="padding-bottom: 20px; font-size: 25px;">Orders</h2>

<table class="table">
 <thead>
    <tr>
      <th scope="col">ID</th>
     <th scope="col">Product ID</th>
     <th scope="col">Order Code</th>
     <th scope="col">Order Total</th>
     <th scope="col">PayPal Email</th>
     <th scope="col">Timestamp</th>
    </tr>
 </thead>
 
<?php
$get_order_info = mysqli_query($conn, "SELECT * FROM website_orders ORDER BY id DESC LIMIT 100");
while($row = mysqli_fetch_array($get_order_info)){
$order_id = $row["id"];
$order_total_raw = $row["order_total"];
$order_total_raw_2 = round($order_total_raw, 2);
$order_total = number_format((float)$order_total_raw_2, 2, '.', '');

$order_timestamp = $row["timestamp"];
$order_product_id = $row["product_id"];
$order_code = $row["order_code"];
$buyer_paypal_email = $row["buyer_paypal_email"];

echo '  <tbody>';
echo '    <tr>';
echo '      <td scope="row">'.$order_id.'</td>';
echo '      <td>'.$order_product_id.'</td>';
echo '      <td>'.$order_code.'</td>';
echo '      <td>$'.$order_total.'</td>';
echo '      <td>'.$buyer_paypal_email.'</td>';
echo '      <td>'.$order_timestamp.'</td>';

          
}//END GET_ORDER_INFO


?>

</tr>
</tbody>
</table>


</div>
</center>

<?php
include "footer.php";
?>
