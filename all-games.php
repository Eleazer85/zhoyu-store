<?php 
    $connect = mysqli_connect('localhost','root','','web-top-up');
    $query = mysqli_query($connect,"SELECT * FROM Games ORDER BY Likes LIMIT 12");
    while($row = mysqli_fetch_array($query)):
    ?>
    <div class="games" style="background-image:url(<?php echo $row['Gambar-game'] ?>)">
      <a href="shop?games=mobile-legend">
        <div class="redirect">
        </div>
      </a>
    </div>
    <?php endwhile; ?>