<?php
include "header.php";
include "assets/require_admin_logged_in.php";
?>

<style>
select {
  width: 70%;
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
if (isset($_POST['submit'])){

$hide_form = 'display: none;';
    
$delete_product_id = $_POST['selected_product'];

$delete_selected_product = "UPDATE website_products SET deleted='yes', active='no' WHERE product_id='$delete_product_id'";
mysqli_query($conn, $delete_selected_product);


$product_table_name = $delete_product_id.'_stock';

echo '<center><div class="container" style="padding-top: 110px; width: 40%;">';
    echo '<center><h2 style="padding-bottom: 30px; font-size: 25px;">Delete Product</h2></center>';
    echo '<center><font color="green" class="alert no-select">Product Successfully Deleted Redirecting...</font></center>';
    echo '<center><a href="admin-panel.php"><button style="margin-top: 30px;">Continue</button></a></center>';
    echo '</div></center>';
echo '<meta http-equiv="refresh" content="0; url=admin-panel.php">';
    
}//END IF FORM IS SUBMITTED
?>

<center>
<div class="container" style="padding-top: 110px; width: 40%; <?php echo $hide_form; ?>">
    
    <form action="" method="POST">
          <center><h2 style="padding-bottom: 20px; font-size: 25px;">Delete Product</h2></center>
      <br>
      
      <div class="form-group">
    <label for="selected_product">Choose The Product You Want To Edit</label><br><br>
    <select required class="form-control" id="selected_product" name="selected_product">
        <?php
$get_all_products = mysqli_query($conn, "SELECT * FROM website_products WHERE deleted='no' ORDER BY creation_timestamp DESC");
while($row = mysqli_fetch_array($get_all_products)){
$product_name = $row["name"];
$product_id = $row["product_id"];
echo '<option value="'.$product_id.'">'.$product_name.'</option>';
}//END WHILE GET_ALL_PRODUCTS    
      ?>
    </select>
  </div>
  
     
    <div class="form-check">
        <center>
  <input required class="form-check-input" type="checkbox" value="true" id="defaultCheck1" name="defaultCheck1">
  <label class="form-check-label" for="defaultCheck1">
    Confirm Deletion
  </label>
  </center>
</div>

 <br>
  <center><button id="submit" name="submit" type="submit">Delete</button></center>
</form>
<br>
    
    
</div>
</center>

<?php
include "footer.php";
?>