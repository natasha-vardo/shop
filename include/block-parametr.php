<?php 
    defined('myshop') or die ('Доступ запрещен');
?>
   <script>
    $(document).ready(function(){
       $('#block-trackbar').trackbar({
           onMove : function(){
               document.getElementById("start-price").value = this.leftValue;
               document.getElementById("end-price").value = this.rightValue;
           },
           width : 160,
           leftLimit : 0,
           leftValue : <?php 
           if((int)$_GET["start_price"] >=0 AND (int)$_GET["start_price"] <=10000){
               echo (int)$_GET["start_price"];
           } else{
               echo "0";
           }
           ?>,
           rightLimit : 10000,
           rightValue : <?php 
           if((int)$_GET["end_price"] >=0 AND (int)$_GET["end_price"] <=10000){
               echo (int)$_GET["end_price"];
           } else{
               echo "10000";
           }
           ?>,
           roundUp : 10
       }); 
    });
</script>
  

  <div id="block-parametr">
   
    <p class="header-title">Поиск по параметрам</p>
    
    <p class="title-filter">Стоимость</p>
    
    <form action="search_filter.php" method="get">
       
        <div id="block-input-price">
            <ul>
                <li><p>от</p></li>
                <li><input type="text" id="start-price" name="start_price" value="0"></li>
                <li><p>до</p></li>
                <li><input type="text" id="end-price" name="end_price" value="10000"></li>
                <li><p>руб.</p></li>
            </ul>
        </div>
        
        <div id="block-trackbar"></div>
        
        <p class="title-filter">Производитель</p>
        
        <ul class="checkbox-brand">
           <?php 
                 $result = mysqli_query($connect,"SELECT * FROM category WHERE type='mobile'");
    
                if (mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_array($result);

                do
                {
                    $checked_brand = "";
                        
                    if($_GET["brand"])
                    {
                        if(in_array($row["id"],$_GET["brand"]))
                        {
                            $checked_brand = "checked";
                        }
                    }
                    
                    
                echo'
                    <li><input '.$checked_brand.' type="checkbox" name="brand[]" value="'.$row["id"].'" id="checkbrand'.$row["id"].'"><label for="checkbrand'.$row["id"].'">'.$row["brand"].'</label></li>
                ';
                }

                while($row = mysqli_fetch_array($result)); 
                }
            ?>
        </ul>
        
       <center><input type="submit" name="submit" id="button-param-search" value="Найти"></center>
    </form>
</div>