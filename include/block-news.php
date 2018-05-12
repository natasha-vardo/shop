<?php 
    defined('myshop') or die ('Доступ запрещен');
    include("functions/newsfunction.php"); ?>
  <div id="block-news">
   <center><img id="news-prev" src="/images/img-prev.png"></center>
    <div id="newsticker">
        <ul>
           <?php 
                $result = mysqli_query($connect,"SELECT * FROM news ORDER BY id DESC");
    
                if (mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_array($result);
                do
                {
                    echo 
                    '<li>
                        <span>'.$row["date"].'</span>
                        <a href="">'.$row["title"].'</a>
                        <p>'.cutFeatures($row["text"]).'</p>
                    </li>';
                }
                while($row = mysqli_fetch_array($result)); 
                }
            ?>
        </ul>
    </div>
   <center><img id="news-next" src="/images/img-next.png"></center>
</div>