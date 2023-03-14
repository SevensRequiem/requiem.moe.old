<?php
include "header.php";
?>

<style>

/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 25%;
  height: 475px; /* Should be removed. Only for demonstration */
  padding: 4%;
}

.hidden-br {
      display:none;
  }

@media only screen and (max-width: 600px) {
  .column {
    width: 90vw;
    padding-top: 5%;
    padding-left: 3%;
    padding-bottom: 15%;
  }
  .hidden-br {
      display:block;
  }
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

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
  height: 475px;
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
  width: 80%;
  font-size: 18px;
  border-radius: 15px;
  padding-bottom: 15px;
}

.card button:hover {
  opacity: 0.7;
}

.zoom {
    transition: transform .4s;
}

.zoom:hover {
    -ms-transform: scale(1.1); /* IE 9 */
    -webkit-transform: scale(1.1); /* Safari 3-8 */
    transform: scale(1.1); 
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
max-width: 80%;
border-radius: 9px;
}
</style>

<div class="row">

<?php
$get_home_products = mysqli_query($conn, "SELECT * FROM website_products WHERE active='yes' AND deleted='no' ORDER BY creation_timestamp DESC");
while($row = mysqli_fetch_array($get_home_products)){
$product_id = $row["product_id"];
$product_name = $row["name"];
$product_price = $row["price"];
$product_image = $row["image_url"];

echo '<div class="column">';
echo '<div class="card zoom">';
echo '<br>';
//if($product_image != ""){
$error_code = "if (this.src != 'assets/default-product.png') this.src = 'assets/default-product.png';";
echo '<a href="product.php?p='.$product_id.'"><img class="no-drag product-image" src="'.$product_image.'" onerror="'.$error_code.'"></a>';
//}//END IF THERE IS AN IMAGE
echo '  <h1 style="font-size: 25px; padding-bottom: 10px; padding-top: 20px;">'.$product_name.'</h1>';
echo '  <p style="padding-bottom: 16px;" class="price">$'.$product_price.'</p>';
echo '<a href="product.php?p='.$product_id.'"><button>More Info</button></a>';
echo '<br>';
echo '</div>';
echo '  </div></center>';
echo '<br class="hidden-br">';
}//END FOR EACH

?>
  
</div>

<?php
include "footer.php";
?>
