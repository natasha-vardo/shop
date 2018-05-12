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
    
    $login = clear_string($_POST["login"]);
    
    $pass   = md5(clear_string($_POST["pass"]));
    $pass   = strrev($pass);
    $pass   = strtolower("9nm2rv8q".$pass."2yo6z");
    
    if ($_POST["rememberme"] == "yes")
    {
        setcookie('rememberme',$login.'+'.$pass,time()+3600*24*31, "/");
    }
    
   $result = mysqli_query($connect, "SELECT * FROM reg_user WHERE (login = '$login' OR email = '$login') AND pass = '$pass'");
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        session_start();
        $_SESSION['auth'] = 'yes_auth'; 
        $_SESSION['auth_pass'] = $row["pass"];
        $_SESSION['auth_login'] = $row["login"];
        $_SESSION['auth_surname'] = $row["surname"];
        $_SESSION['auth_name'] = $row["name"];
        $_SESSION['auth_patronymic'] = $row["patronymic"];
        $_SESSION['auth_address'] = $row["address"];
        $_SESSION['auth_phone'] = $row["phone"];
        $_SESSION['auth_email'] = $row["email"];
        echo 'yes_auth';
    }
    else{
        echo 'no_auth';
    }  
} 

?>