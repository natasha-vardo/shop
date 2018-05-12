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

$login = clear_string($_POST['reg_login']);

$result = mysqli_query($connect,"SELECT login FROM reg_user WHERE login = '$login'");
if (mysqli_num_rows($result) > 0)
{
   echo 'false';
}
else
{
   echo 'true'; 
}
}
?>