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

<center>
<div class="container" style="padding-top: 110px; width: 40%;">

<center><h2 style="padding-bottom: 20px; font-size: 25px;">View Stock</h2></center>
<br>
<form action="view-stock.php" method="GET">

<div class="form-group">
<label for="selected_product">Choose The Product You Want To View The Current Stock For</label><br><br>
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

<center><button id="submit" type="submit" class="btn btn-primary">Continue</button></center>
</form>



</div>
</center>

<?php
    include "footer.php";
    ?>
