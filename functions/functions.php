<?php  
    defined('myshop') or die ('Доступ запрещен');

include("include/database.php");

function clear_string($cl_str){
    
    global $connect;
    
      $cl_str = strip_tags($cl_str);   
      $cl_str = mysqli_real_escape_string($connect, $cl_str);   
      $cl_str = trim($cl_str); 
    
    return $cl_str;
}

// Грууппировка цен по разрядам
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
?>