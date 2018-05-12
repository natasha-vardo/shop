<?php 
    define('MYSQL_SERVER', 'localhost');
    define('MYSQL_USER', 'root');
    define('MYSQL_PASSWORD', '');
    define('MYSQL_DB', 'brandshop');


        $connect = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or die("Error: ".mysqli_error($connect));
        mysqli_query($connect,'SET NAMES UTF8'); 
    
//Проверка соединения
 
    if($connect == true) 
{ 
    echo "" ; 
} 
    else 
{ 
    exit("Ошибка подключения к БД!") ; 
}  
?>