<?php 
$connect = mysqli_connect("localhost", "root", "", "web-top-up");

$search = mysqli_real_escape_string($connect, $_GET["search"]); // Escape input safely

$query = "SELECT * FROM `Games` WHERE `Nama-game` REGEXP '$search'";

$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_array($result)):
?>
<div class="searched-item">
    <a href="shop?games=<?php echo $row['Game_terkait'];?>"><img src="<?php echo $row['Gambar-game']?>" class="searched-images"></a>
    <div class="searched-description">
        <a href="shop?games=<?php echo $row['Game_terkait'];?>" class="text-decoration-none"><h1 class="game-title"><?php echo $row["Nama-game"];?></h1></a>
        <p><?php echo $row["Description"] ?></p>
    </div>
</div>
<?php endwhile; ?>