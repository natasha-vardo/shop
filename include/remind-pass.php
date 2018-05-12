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
    
function fungenpass(){
        $number = 7;

    $arr = array('a','b','c','d','e','f',

                 'g','h','i','j','k','l',

                 'm','n','o','p','r','s',

                 't','u','v','x','y','z',

                 '1','2','3','4','5','6',

                 '7','8','9','0');

    // Генерируем пароль

    $pass = "";

    for($i = 0; $i < $number; $i++)

    {

      // Вычисляем случайный индекс массива

      $index = rand(0, count($arr) - 1);

      $pass .= $arr[$index];

    }


  return $pass;
    }
    
    function send_mail($from,$to,$subject,$body)
{
	$charset = 'utf-8';
	mb_language("ru");
	$headers  = "MIME-Version: 1.0 \n" ;
	$headers .= "From: <".$from."> \n";
	$headers .= "Reply-To: <".$from."> \n";
	$headers .= "Content-Type: text/html; charset=$charset \n";
	
	$subject = '=?'.$charset.'?B?'.base64_encode($subject).'?=';

	mail($to,$subject,$body,$headers);
}

$email = clear_string($_POST["email"]);

if ($email != "")
{
    
   $result = mysqli_query($connect, "SELECT email FROM reg_user WHERE email='$email'");
If (mysqli_num_rows($result) > 0)
{

// Генерация пароля
    $newpass = fungenpass();
    
// Шифрование пароля
    $pass   = md5($newpass);
    $pass   = strrev($pass);
    $pass   = strtolower("9nm2rv8q".$pass."2yo6z");    
 
// Обновление пароля на новый
$update = mysqli_query ($connect, "UPDATE reg_user SET pass='$pass' WHERE email='$email'");

    
// Отправка нового пароля
   
	         send_mail( 'noreply@shop.ru',
			             $email,
						'Новый пароль для сайта MyShop.ru',
						'Ваш пароль: '.$newpass);   
   
   echo 'yes';
    
}else
{
    echo 'Данный E-mail не найден!';
}

}
else
{
    echo 'Укажите свой E-mail';
}

}



?>