<?php 
    defined('myshop') or die ('Доступ запрещен');
?>
   <div id="block-category">
    <p class="header-title">Категории товаров</p>
    <ul>
        <li><a><img src="/images/mobile-icon.gif" id="mobile-image">Мобильные телефоны</a>
        <ul class="category-section">
            <li><a href="view_cat.php?type=mobile"><strong>Все модели</strong></a></li>
            <?php 
                $result = mysqli_query($connect,"SELECT * FROM category WHERE type='mobile'");
            
                if (mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
    
                do{
                    echo '<li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>';
                }
                    while($row = mysqli_fetch_array($result));
                }
            ?>
        </ul>
    
        </li>
        
        <li><a><img src="/images/book-icon.gif" id="book-image">Ноутбуки</a>
        <ul class="category-section">
            <li><a href="view_cat.php?type=notebook"><strong>Все модели</strong></a></li>
            <?php 
                $result = mysqli_query($connect,"SELECT * FROM category WHERE type='notebook'");
            
                if (mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
    
                do{
                    echo '<li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>';
                }
                    while($row = mysqli_fetch_array($result));
                }
            ?>
        </ul>
        <div class="line-line"></div>
        </li>
        <li><a><img src="/images/table-icon.gif" id="table-image">Планшеты</a>
        <ul class="category-section">
            <li><a href="view_cat.php?type=notepad"><strong>Все модели</strong></a></li>
            <?php 
                $result = mysqli_query($connect,"SELECT * FROM category WHERE type='notepad'");
            
                if (mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
    
                do{
                    echo '<li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>';
                }
                    while($row = mysqli_fetch_array($result));
                }
            ?>
        </ul>
        <div class="line-line"></div>
        </li>
        
    </ul>
</div>