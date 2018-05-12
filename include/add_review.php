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


 $id = clear_string($_POST['id']);
 $name = clear_string($_POST['name']);
 $good = clear_string($_POST['good']);
 $bad =  clear_string($_POST['bad']);
 $comment = clear_string($_POST['comment']);

    		mysqli_query($connect, "INSERT INTO table_reviews(products_id,name,good_reviews,bad_reviews,comment,date) VALUES(						
                            '".$id."',
                            '".$name."',
                            '".$good."',
                            '".$bad."',
                            '".$comment."',
                             NOW()							
						)");	

echo 'yes';
}
?>