<?php 
function cutFeatures($val1){
 $string = $val1;
 $string = strip_tags($string);
 $string = substr($string, 0, 120);
 $string = substr($string, 0, strrpos($string, ' '));
 $string .= "... ";
 return $string;
}
?>