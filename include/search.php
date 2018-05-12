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

 $search = strtolower(clear_string($_POST['text']));
 
 $result = mysqli_query($connect, "SELECT * FROM table_products WHERE title LIKE '%$search%' AND visible = '1'");
 
 if (mysqli_num_rows($result) > 0)
{
$result = mysqli_query($connect, "SELECT * FROM table_products WHERE title LIKE '%$search%'  AND visible = '1' LIMIT 10");
$row = mysqli_fetch_array($result);
do
{
echo '
<li><a href="search.php?q='.$row["title"].'">'.$row["title"].'</a></li>
';
}
 while ($row = mysqli_fetch_array($result));

}
}



?>