<?php
include "header.php";
include "assets/require_admin_logged_in.php";

$post_product_id = $_GET['selected_product'];

$verify_product_id = mysqli_query($conn, "SELECT * FROM website_products WHERE product_id='$post_product_id'");
while($row = mysqli_fetch_array($verify_product_id)){
$product_price = $row["price"];
$product_name = $row["name"];
$product_description = $row["description"];

$product_table_name = $post_product_id.'_stock';

}//END WHILE VERIFY_PRODUCT_ID

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




.red-button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #ed4b39;
  text-align: center;
  cursor: pointer;
  font-size: 16px;
  border-radius: 10px;
  padding: 4px 4px 4px 4px;
  margin-left: 8px;
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

<?php

if($product_price == "") {
    $hide_form = 'display: none;';
    echo '<center><div class="container" style="padding-top: 110px; width: 100%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">View Stock For '.$product_name.'</h2></center>';
    echo '<center><font color="red" class="alert no-select">No Vaild Product Selected! Redirecting</font></center>';
    echo '<center><a href="view-stocks.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
echo '<meta http-equiv="refresh" content="0; url=view-stocks.php">';
exit();
}// PRODUCT IS NOT VALID


if (isset($_POST['submit'])) {
$hide_form = 'display: none;';
    
$stock_delete_id = $_POST['stock_delete_id'];
$post_product_id = $_POST['post_product_id'];
    
    $delete_selected_stock = "DELETE FROM $product_table_name WHERE stock_id='$stock_delete_id'";
    mysqli_query($conn, $delete_selected_stock);
    echo '<meta http-equiv="refresh" content="0; url=view-stock.php?selected_product='.$post_product_id.'">';
        echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">View Stock For '.$product_name.'</h2></center>';
    echo '<center><font color="green" class="alert no-select">Selected Stock Successfully Deleted! Redirecting</font></center>';
    echo '<center><a href="view-stock.php?selected_product='.$post_product_id.'"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
    
}//END IF SUBMITTED

?>


<center>
<div class="container" style="padding-top: 110px; width: 80%; <?php echo $hide_form; ?>">
    
          <center><h2 style="padding-bottom: 20px; font-size: 25px;">Available Stock For <b><?php echo $product_name; ?></b></h2></center>
          <br>


<table class="table">
 <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Product Contents</th>
     <th scope="col">Availability</th>
     <th scope="col">Delete</th>
    </tr>
 </thead>
 
<?php
$get_product_stock_info = mysqli_query($conn, "SELECT * FROM $product_table_name WHERE available='yes'");
while($row = mysqli_fetch_array($get_product_stock_info)){
$stock_id = $row["stock_id"];
$stock_product = $row["stock_product"];
$stock_availability = $row["stock_availability"];


echo '  <tbody>';
echo '    <tr>';
echo '      <td>'.$stock_id.'</td>';
echo '      <td>'.$stock_product.'</td>';
echo '      <td>YES</td>';
echo '      <td><form action="" method="POST"><input type="hidden" value="'.$post_product_id.'" name="post_product_id" id="post_product_id"><input type="hidden" value="'.$stock_id.'" name="stock_delete_id" id="stock_delete_id"><input required class="form-check-input" type="checkbox" value="true" id="defaultCheck1" name="defaultCheck1"> <label class="form-check-label" for="defaultCheck1">Confirm</label> <button type="submit" name="submit" id="submit" class="red-button">Delete</button></form></td>';
echo '    </tr>';

          
}//END GET_PRODUCT_STOCK_INFO

?>

</tbody>
</table>


</div>
</center>

<?php
include "footer.php";
?>