<?php 
define('myshop', true);
    include("include/database.php");
    include("functions/functions.php");
    session_start();
    include("include/auth_cookie.php");

    $cat = clear_string($_GET['cat']);
    $type = clear_string($_GET['type']);
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css">
    
    <script src="js/jquery-1.8.2.min.js"></script>
    <script src="js/jcarousellite_1.0.1.js"></script>
    <script src="js/shop-script.js"></script>
    <script src="js/jquery.cookie.min.js"></script> 
    <script src="trackbar/jquery.trackbar.js"></script> 
    <script src="/js/TextChange.js"></script> 
    
    
    <title>Поиск по параметрам</title>
</head>
    <body>
        <div id="block-body">
            <?php 
                include("include/block-header.php");
            ?>
            
        <div id="block-right">
            <?php 
                include("include/block-category.php");
                include("include/block-parametr.php");
                include("include/block-news.php");
            ?>
        </div>
       
        <div class="block-content">

             <div id="products">

             
<?php 
                /*Вывод товара*/
       
        if ($_GET["brand"]){
            $check_brand = implode(',',$_GET["brand"]);
        }
            $start_price = (int)$_GET["start_price"];
            $end_price = (int)$_GET["end_price"];
                
        if(!empty($check_brand) OR !empty($end_price)) 
        {
            if(!empty($check_brand)) $query_brand = " AND brand_id IN($check_brand)";
            
            if(!empty($end_price)) $query_price = " AND price BETWEEN $start_price AND $end_price";
            
        }
                 
        
        $result = mysqli_query($connect,"SELECT * FROM table_products WHERE visible='1' $query_brand $query_price ORDER BY products_id");
    
        if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_array($result);
    
            echo'<div class="block-content">
            <div id="block-sorting">
            <p id="nav-breadcrums"><a href="index.php">Главная страница </a><span>\ Все товары</span></p>
            <ul id="option-list">
                <li>Вид: </li>
                <li><img id="style-grid" src="/images/icon-grid.png"></li>
                <li><img id="style-list" src="/images/icon-list.png"></li>
                
                <li>Сортировать: </li>
                <li><a id="select-sort">'.$sort_name.'</a>
                <ul id="sorting-list">
                    <li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=price-asc">От дешевых к дорогим</a></li>
                    <li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=price-desc">От дорогих к дешевым</a></li>
                    <li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=popular">Популярное</a></li>
                    <li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=news">Новинки</a></li>
                    <li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=brand">От А до Я</a></li>
                </ul>
                </li>
                </ul>
            </div> 
            </div> 
            <ul id="block-tovar-grid"> ';
    do
    {
        if($row["image"] != "" && file_exists("./upload_images/".$row["image"]))
        {
            $img_path = './upload_images/'.$row["image"];
            $max_width = 180;
            $max_height = 180;
            list($width, $height) = getimagesize($img_path);
            $ratioh = $max_height/$height;
            $ratiow = $max_width/$width;
            $ratio = min($ratioh, $ratiow);
            $width = intval($ratio*$width);
            $height = intval($ratio*$height);
        }
        else
        {
            $img_path = "../images/no-images.png";
            $width = 180;
            $height = 180;
        }
        
         $query_reviews = mysqli_query($connect, "SELECT * FROM table_reviews WHERE products_id = '{$row["products_id"]}' AND moderat='1'");  
        $count_reviews = mysqli_num_rows($query_reviews);
        
        echo '
        <li>
        <div class="block-images-grid">
        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
        </div>
        
        <p class="style-title-grid"><a href="view_content.php?id='.$row["products_id"].'" ><strong>'.$row["title"].'</strong></a></p>
        
        <ul class="reviews-and-counts-grid">
        <li><img src="../images/eye-icon.png"><p>'.$row["count"].'</p></li>
        <li><img src="../images/comment-icon.png"><p>'.$count_reviews.'</p><li>
        </ul>
        
        <a class="add-cart-style-grid" tid="'.$row["products_id"].'"></a>
        
        <p class="style-price-grid"><strong>'.group_numerals($row["price"])." ".'</strong>руб.</p>
        <div class="mini-features">'.$row["mini_features"].'</div>
        </li>';
    }
    while($row = mysqli_fetch_array($result)); 
            
?>
</ul> 

<ul id="block-tovar-list">
                
<?php 
                /*Вывод товара*/
                
        $result = mysqli_query($connect,"SELECT * FROM table_products WHERE visible='1' $query_brand $query_price ORDER BY products_id");
    
        if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_array($result);
    
    do
    {
        if($row["image"] != "" && file_exists("./upload_images/".$row["image"]))
        {
            $img_path = './upload_images/'.$row["image"];
            $max_width = 150;
            $max_height = 150;
            list($width, $height) = getimagesize($img_path);
            $ratioh = $max_height/$height;
            $ratiow = $max_width/$width;
            $ratio = min($ratioh, $ratiow);
            $width = intval($ratio*$width);
            $height = intval($ratio*$height);
        }
        else
        {
            $img_path = "../images/no-images.png";
            $width = 150;
            $height = 150;
        }
        
         $query_reviews = mysqli_query($connect, "SELECT * FROM table_reviews WHERE products_id = '{$row["products_id"]}' AND moderat='1'");  
        $count_reviews = mysqli_num_rows($query_reviews);
        
        echo '
        <li>
        <div class="block-images-list">
        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
        </div>
                
        <p class="style-title-list"><a href="view_content.php?id='.$row["products_id"].'" ><strong>'.$row["title"].'</strong></a></p>
                         
        <ul class="reviews-and-counts-list">
        <li><img src="../images/eye-icon.png"><p>'.$row["count"].'</p></li>
        <li><img src="../images/comment-icon.png"><p>'.$count_reviews.'</p><li>
        </ul>
        <br/>
         <br/>
        <a class="add-cart-style-grid" tid="'.$row["products_id"].'"></a>
        
        <p class="style-price-list"><strong>'.group_numerals($row["price"])." ".'</strong>руб.</p>
        <div class="style-text-list">'.$row["mini_description"].'</div>
        </li>';
    }
    while($row = mysqli_fetch_array($result)); 
}
}else {
            echo '<h3>Категория не доступна или не создана!</h3>';
        }
    
    /*Конец вывода товара*/
?>
</ul> 
           </div> 
        </div>
            <?php 
                include("include/block-random.php");
                include("include/block-footer.php");
            ?>
            

    </body>
</html>