<h2 class="mt-5 ms-5">Searched For: <?php echo $_GET["search"];?></h2>
<?php 
$connect = mysqli_connect("localhost", "root", "", "web-top-up");

$search = mysqli_real_escape_string($connect, $_GET["search"]); // Escape input safely

$query = "SELECT * FROM `Games` WHERE `Nama-game` REGEXP '$search'";

$result = mysqli_query($connect, $query);

$max_length = 120; // Set character limit for description
while($row = mysqli_fetch_array($result)):
?>
<div class="searched-item">
    <a href="shop?games=<?php echo $row['Game_terkait'];?>"><img src="<?php echo $row['Gambar-game']?>" class="searched-images mt-3 mb-3"></a>
    <div class="searched-description">
        <a href="shop?games=<?php echo $row['Game_terkait'];?>" class="text-decoration-none"><h1 class="game-title"><?php echo $row["Nama-game"];?></h1></a>
        <p class="games-description"><?php

        $description = $row["Description"]; // Get the description from the database
        
        if (strlen($description) > $max_length) {
            $description = substr($description, 0, $max_length) . "...";
        }
        
        echo $description;

        ?></p>
        <p class="rating">
            Likes <?php echo $row["Likes"]; ?>
        </p>
    </div>
</div>
<?php endwhile; ?>