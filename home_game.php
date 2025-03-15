<?php 
    $game_perPage = 8;
    $connect = mysqli_connect('localhost','root','','web-top-up');
    $query = mysqli_query($connect,"SELECT * FROM Games LIMIT ".$game_perPage);
    while($row = mysqli_fetch_array($query)):
    ?>
    <div class="games" style="background-image:url(<?php echo $row['Gambar-game'] ?>)">
      <a href="shop?games=<?php echo $row["Game_terkait"]?>">
        <div class="redirect">
        </div>
      </a>
    </div>
    <?php endwhile; ?>