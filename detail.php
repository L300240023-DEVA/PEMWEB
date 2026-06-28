<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("ID Anime tidak valid.");
}

$api = "https://api.jikan.moe/v4/anime/" . $id;

$response = @file_get_contents($api);

if ($response === false) {
    die("Gagal mengambil data dari API.");
}

$result = json_decode($response, true);

if (!isset($result['data'])) {
    die("Data anime tidak ditemukan.");
}

$anime = $result['data'];
?>
<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo htmlspecialchars($anime['title']); ?></title>

<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<style>

.detail-container{
    width:90%;
    max-width:1200px;
    margin:40px auto;
}

.detail-card{
    display:flex;
    flex-wrap:wrap;
    gap:30px;
    background:#1e1e1e;
    color:#fff;
    padding:30px;
    border-radius:15px;
    box-shadow:0 0 15px rgba(0,0,0,.3);
}

.poster{
    flex:1;
    min-width:280px;
}

.poster img{
    width:100%;
    border-radius:10px;
}

.info{
    flex:2;
}

.info h1{
    margin-top:0;
    color:#ffcc00;
}

.badge{
    display:inline-block;
    padding:6px 12px;
    background:#ff9800;
    border-radius:20px;
    margin:5px 5px 5px 0;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

table td{
    padding:10px;
    border-bottom:1px solid #444;
}

.synopsis{
    margin-top:25px;
    line-height:1.8;
    text-align:justify;
}

.buttons{
    margin-top:30px;
}

.btn{
    display:inline-block;
    padding:12px 20px;
    text-decoration:none;
    border-radius:8px;
    color:white;
    background:#ff9800;
    margin-right:10px;
}

.btn:hover{
    background:#ff6d00;
}

.trailer{
    margin-top:40px;
}

iframe{
    width:100%;
    height:500px;
    border:none;
    border-radius:10px;
}

@media(max-width:768px){

.detail-card{
flex-direction:column;
}

iframe{
height:250px;
}

}

</style>

</head>

<body>

<nav>

<div class="logo">
<i class="fa-solid fa-dragon"></i>
AnimeKu
</div>

<ul>

<li><a href="index.php">Home</a></li>
<li><a href="topanime.php">Top Anime</a></li>
<li><a href="genre.php">Genre</a></li>
<li><a href="about.php">About</a></li>

</ul>

</nav>

<div class="detail-container">

<div class="detail-card">

<div class="poster">

<img src="<?php echo $anime['images']['jpg']['large_image_url']; ?>">

</div>

<div class="info">

<h1><?php echo htmlspecialchars($anime['title']); ?></h1>

<span class="badge">
⭐ <?php echo $anime['score'] ?? '-'; ?>
</span>

<span class="badge">
Episode <?php echo $anime['episodes'] ?? '-'; ?>
</span>

<span class="badge">
<?php echo htmlspecialchars($anime['status']); ?>
</span>

<table>

<tr>
<td><strong>Judul Jepang</strong></td>
<td><?php echo htmlspecialchars($anime['title_japanese'] ?? '-'); ?></td>
</tr>

<tr>
<td><strong>Tipe</strong></td>
<td><?php echo htmlspecialchars($anime['type'] ?? '-'); ?></td>
</tr>

<tr>
<td><strong>Durasi</strong></td>
<td><?php echo htmlspecialchars($anime['duration'] ?? '-'); ?></td>
</tr>

<tr>
<td><strong>Rating</strong></td>
<td><?php echo htmlspecialchars($anime['rating'] ?? '-'); ?></td>
</tr>

<tr>
<td><strong>Musim</strong></td>
<td>
<?php
echo htmlspecialchars(($anime['season'] ?? '-') . " " . ($anime['year'] ?? ""));
?>
</td>
</tr>

<tr>
<td><strong>Studio</strong></td>
<td>
<?php
if(!empty($anime['studios'])){
foreach($anime['studios'] as $studio){
echo htmlspecialchars($studio['name'])." ";
}
}else{
echo "-";
}
?>
</td>
</tr>

<tr>
<td><strong>Genre</strong></td>
<td>
<?php
if(!empty($anime['genres'])){
foreach($anime['genres'] as $genre){
echo "<span class='badge'>".htmlspecialchars($genre['name'])."</span>";
}
}else{
echo "-";
}
?>
</td>
</tr>

</table>

<div class="synopsis">

<h2>Sinopsis</h2>

<p>

<?php
echo nl2br(htmlspecialchars($anime['synopsis'] ?? 'Sinopsis tidak tersedia.'));
?>

</p>

</div>

<div class="buttons">

<a class="btn" href="index.php">
<i class="fa-solid fa-arrow-left"></i>
Kembali
</a>

<?php if(!empty($anime['url'])){ ?>

<a class="btn"
href="<?php echo htmlspecialchars($anime['url']); ?>"
target="_blank">

<i class="fa-solid fa-up-right-from-square"></i>

Lihat di MyAnimeList

</a>

<?php } ?>

</div>

</div>

</div>

<?php
if(!empty($anime['trailer']['embed_url'])){
?>

<div class="trailer">

<h2>Trailer</h2>

<iframe
src="<?php echo htmlspecialchars($anime['trailer']['embed_url']); ?>"
allowfullscreen>
</iframe>

</div>

<?php
}
?>

</div>

<footer style="text-align:center;padding:20px;background:#111;color:white;margin-top:40px;">
© 2026 AnimeKu - Powered by Jikan API
</footer>

</body>
</html>