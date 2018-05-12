<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
define('myshop', true);
include("../include/database.php");
    
function group_numerals($int){
    
       switch (strlen($int)) {

	    case '4':
        
        $price = substr($int,0,1).' '.substr($int,1,4);

	    break;

	    case '5':
        
        $price = substr($int,0,2).' '.substr($int,2,5);

	    break;

	    case '6':
        
        $price = substr($int,0,3).' '.substr($int,3,6);

	    break;

	    case '7':
        
        $price = substr($int,0,1).' '.substr($int,1,3).' '.substr($int,4,7);

	    break;
        
	    default:
        
        $price = $int;
        
	    break;

	}
    return $price; 
}


$result = mysqli_query($connect, "SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'");
if (mysqli_num_rows($result) > 0)
{
$row = mysqli_fetch_array($result);
  
do
{
    $int = $int + ($row["cart_price"] * $row["cart_count"]); 

} while($row = mysqli_fetch_array($result));


     echo group_numerals($int);

}
}
?>