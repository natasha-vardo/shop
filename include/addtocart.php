<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
define('myshop', true);
include("../include/database.php");
    
 function clear_string($cl_str){
    
    global $connect;
    
      $cl_str = strip_tags($cl_str);   
      $cl_str = mysqli_real_escape_string($connect, $cl_str);   
      $cl_str = trim($cl_str); 
    
    return $cl_str;
}
        
$id = clear_string($_POST["id"]);

$result = mysqli_query($connect, "SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND cart_id_products = '$id'");
    
if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_array($result);    
    $new_count = $row["cart_count"] + 1;
    
    $update = mysqli_query($connect, "UPDATE cart SET cart_count='$new_count' WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND cart_id_products ='$id'");   
}
else
{
    $result = mysqli_query($connect, "SELECT * FROM table_products WHERE products_id = '$id'");
    $row = mysqli_fetch_array($result);
    
    mysqli_query($connect, "INSERT INTO cart(cart_id_products,cart_price,cart_datetime,cart_ip)
						VALUES(	
                            '".$row['products_id']."',
                            '".$row['price']."',					
							NOW(),
                            '".$_SERVER['REMOTE_ADDR']."'                                                                        
						    )");	
}
}
?>