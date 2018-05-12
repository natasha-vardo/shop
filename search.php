<?php 
define('myshop', true);
    include("include/database.php");
    include("functions/functions.php");
    session_start();
    include("include/auth_cookie.php");
   
    $search = clear_string($_GET["q"]);

    $sorting = $_GET["sort"];

switch($sorting)
{
    case 'price-asc';
    $sorting = 'price ASC';
    $sort_name = 'От дешевых к дорогим';
    break;

    case 'price-desc';
    $sorting = 'price DESC';
    $sort_name = 'От дорогих к дешевым';
    break;

    case 'popular';
    $sorting = 'count DESC';
    $sort_name = 'Популярное';
    break;

    case 'news';
    $sorting = 'datetime DESC';
    $sort_name = 'Новинки';
    break;

    case 'brand';
    $sorting = 'brand';
    $sort_name = 'От А до Я';
    break;
        
    default:
    $sorting = 'products_id DESC';
    $sort_name = 'Нет сортировки';
    break;
}    
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
    
    <title>Поиск - <?php echo $search; ?></title>
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
       
        <div id="block-content">
   <?php        	
  if (strlen($search) >= 2 && strlen($search) < 100) 
  {    
      
    //Вывод номеров страниц
    $num = 6; // Указываем сколько хотим выводить товаров
    $page = (int)$_GET['page'];              
    
	$count = mysqli_query($connect,"SELECT COUNT(*) FROM table_products WHERE title LIKE '%$search%' AND visible = '1'");
    $temp = mysqli_fetch_array($count);

	if ($temp[0] > 0)
	{  
	$tempcount = $temp[0];

	// Находим общее число страниц
	$total = (($tempcount - 1) / $num) + 1;
	$total =  intval($total);

	$page = intval($page);

	if(empty($page) or $page < 0) $page = 1;  
       
	if($page > $total) $page = $total;
	 
	// Вычисляем начиная с какого номера
    // следует вводить товары
	$start = $page * $num - $num;

	$query_start_num = " LIMIT $start, $num"; 
	}
                /*Вывод товара*/
   
      	if ($temp[0] > 0)
	{     
            echo '
             <div id="block-sorting">
            <p id="nav-breadcrums"><a href="index.php">Главная страница </a><span>\ Поиск</span></p>
            <ul id="option-list">
                <li>Вид: </li>
                <li><img id="style-grid" src="/images/icon-grid.png"></li>
                <li><img id="style-list" src="/images/icon-list.png"></li>
                
                <li>Сортировать: </li>
                <li><a id="select-sort">'.$sort_name.'</a>
                <ul id="sorting-list">
                    <li><a href="index.php?sort=price-asc">От дешевых к дорогим</a></li>
                    <li><a href="index.php?sort=price-desc">От дорогих к дешевым</a></li>
                    <li><a href="index.php?sort=popular">Популярное</a></li>
                    <li><a href="index.php?sort=news">Новинки</a></li>
                    <li><a href="index.php?sort=brand">От А до Я</a></li>
                </ul>
                </li>
                </ul>
            </div>
             <ul id="block-tovar-grid">
            ';
      
        $result = mysqli_query($connect,"SELECT * FROM table_products WHERE title LIKE '%$search%' AND visible='1' ORDER BY $sorting $query_start_num");
    
        if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_array($result);
    
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
        
        <p class="style-title-grid"><a href="view_content.php?id='.$row["products_id"].'" >'.$row["title"].'</a></p>
        
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
}

?>
</ul> 

<ul id="block-tovar-list">
                
<?php 
                /*Вывод товара*/
                
        $result = mysqli_query($connect,"SELECT * FROM table_products WHERE title LIKE '%$search%' AND visible='1' ORDER BY $sorting $query_start_num");
    
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
                
        <p class="style-title-list"><a href="view_content.php?id='.$row["products_id"].'" >'.$row["title"].'</a></p>
                         
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
   echo '</ul>';
    
    /*Конец вывода товара*/
    
if ($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="search.php?q='.$search.'&page='.($page - 1).'">&lt;</a></li>';}
if ($page != $total){ $pstr_next = '<li><a class="pstr-next" href="search.php?q='.$search.'&page='.($page + 1).'">&gt;</a></li>';}


// Формируем ссылки на страницы
if($page - 5 > 0) $page5left = '<li><a href="search.php?q='.$search.'&page='.($page - 5).'">'.($page - 5).'</a></li>';
if($page - 4 > 0) $page4left = '<li><a href="search.php?q='.$search.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="search.php?q='.$search.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="search.php?q='.$search.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="search.php?q='.$search.'&page='.($page - 1).'">'.($page - 1).'</a></li>';

if($page + 5 <= $total) $page5right = '<li><a href="search.php?q='.$search.'&page='.($page + 5).'">'.($page + 5).'</a></li>';
if($page + 4 <= $total) $page4right = '<li><a href="search.php?q='.$search.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="search.php?q='.$search.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="search.php?q='.$search.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="search.php?q='.$search.'&page='.($page + 1).'">'.($page + 1).'</a></li>';

    if ($page+5 < $total)
{
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="search.php?q='.$search.'&page='.$total.'">'.$total.'</a></li>';
}else
{
    $strtotal = ""; 
}

if ($total > 1)
{
    echo '
    <div class="pstrnav">
    <ul>
    ';
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='search.php?q=".$search."&page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '
    </ul>
    </div>
    ';
}
            
}else{
    echo "<p>Ничего не найдено!</p>";           
}  
}
else{
    echo "<p>Поисковое значение должно быть от 2 до 100 символов!</p>";
                
}
?> 
        </div>
            <?php 
                include("include/block-random.php");
                include("include/block-footer.php");
            ?>
        </div>
    </body>
</html>