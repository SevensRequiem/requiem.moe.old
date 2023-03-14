<?php
include "header.php";
include "assets/require_admin_logged_in.php";
?>

<style>

.separate-panel-buttons {
background-color: #FFFFFF;
padding-top: 8px;
padding-bottom: 8px;
padding-right: 14px;
padding-left: 14px;
border-radius: 12px;
max-width: 400px;
box-shadow: 0 10px 10px 0 rgba(0, 0, 0, 0.2);
}

a:link {
    text-decoration: none;
    color: black;
}

a:visited {
    text-decoration: none;
    color: black;
}

a:hover {
    text-decoration: none;
    color: black;
}

a:active {
    text-decoration: none;
    color: black;
}

</style>

<center>
<div class="container" style="padding-top: 110px; width: 40%;">
          <center><h2 style="padding-bottom: 20px; font-size: 25px;">Admin Panel</h2></center>
          <br>

    <center>
    <div class="separate-panel-buttons"><a class="admin-panel-button" href="website-info.php"><i class="fas fa-pen"></i> Edit Webite Info</a></div>
    <br>
    <div class="separate-panel-buttons"><a class="admin-panel-button" href="add-product.php"><i class="fas fa-plus"></i> Add Product</a></div>
    <br>
    <div class="separate-panel-buttons"><a class="admin-panel-button" href="edit-products.php"><i class="fas fa-cut"></i> Edit Products</a></div>
    <br>
    <div class="separate-panel-buttons"><a class="admin-panel-button" href="delete-product.php"><i class="fas fa-trash-alt"></i> Delete Product</a></div>
    <br>
    <div class="separate-panel-buttons"><a class="admin-panel-button" href="view-stocks.php"><i class="fas fa-eye"></i> View Product Stock</a></div>
    <br>
    <div class="separate-panel-buttons"><a class="admin-panel-button" href="add-stocks.php"><i class="fas fa-cart-plus"></i> Add Product Stock</a></div>
        <br>
    <div class="separate-panel-buttons"><a class="admin-panel-button" href="orders.php"><i class="far fa-money-bill-alt"></i> View Orders</a></div>
    </center>
    
    <?php
include "footer.php";
?>