<?php

// ==============================
// ANIMEKU - GENRE
// ==============================

// Ambil daftar genre
$genreApi = "https://api.jikan.moe/v4/genres/anime";

$genreResponse = @file_get_contents($genreApi);

if ($genreResponse === false) {
    die("Gagal mengambil daftar genre.");
}

$genreData = json_decode($genreResponse, true);

$genres = $genreData['data'] ?? [];

// Genre yang dipilih
$selectedGenre = isset($_GET['genre']) ? intval($_GET['genre']) : 1;

// Ambil anime berdasarkan genre
$animeApi = "https://api.jikan.moe/v4/anime?genres=".$selectedGenre."&limit=24";

$animeResponse = @file_get_contents($animeApi);

$animeList = [];

if($animeResponse){

    $animeData = json_decode($animeResponse,true);

    if(isset($animeData['data'])){

        $animeList = $animeData['data'];

    }

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Genre Anime | AnimeKu</title>

<link rel="stylesheet"
href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">


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

<li><a href="contact.php">Contact</a></li>

</ul>

</nav>

<div class="container">

<h1>

🎌 Anime Berdasarkan Genre

</h1>

<div class="genre-list">

<?php foreach($genres as $genre){ ?>

<a href="?genre=<?php echo $genre['mal_id']; ?>">

<?php echo htmlspecialchars($genre['name']); ?>

</a>

<?php } ?>

</div>

<div class="grid">

<?php

if(empty($animeList)){

echo "<h2 style='color:white'>Tidak ada anime.</h2>";

}

foreach($animeList as $anime){

?>

<div class="card">

<img
src="<?php echo $anime['images']['jpg']['large_image_url']; ?>">

<div class="card-body">

<h3>

<?php echo htmlspecialchars($anime['title']); ?>

</h3>

<div class="info">

<span>

⭐

<?php echo $anime['score'] ?? "-"; ?>

</span>

<span>

🎬

<?php echo $anime['episodes'] ?? "-"; ?>

Episode

</span>

</div>

<span class="badge">

<?php echo htmlspecialchars($anime['status']); ?>

</span>

<span class="badge">

<?php echo htmlspecialchars($anime['type']); ?>

</span>

<p>

<?php

$text=$anime['synopsis'] ?? "";

echo htmlspecialchars(substr($text,0,120));

?>

...

</p>

<a
class="btn"
href="detail.php?id=<?php echo $anime['mal_id']; ?>">

Lihat Detail

</a>

</div>

</div>

<?php

}

?>

</div>

</div>

<footer>

© 2026 AnimeKu

Powered by Jikan API

</footer>

</body>

</html>