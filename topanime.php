<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.jikan.moe/v4/top/anime?page=1",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 30
]);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    die("cURL Error : " . curl_error($curl));
}

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

if ($status != 200) {
    die("HTTP Error : " . $status);
}

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON Error : " . json_last_error_msg());
}

if (!isset($data['data'])) {
    echo "<pre>";
    print_r($data);
    exit;
}

$animeList = $data['data'];

?>



<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Top Anime | AnimeKu</title>

<link rel="stylesheet" href="style.css">

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav>

<div class="logo">

<i class="fa-solid fa-dragon"></i>

AnimeKu

</div>

<ul>

<li>

<a href="index.php">

Home

</a>

</li>

<li>

<a href="topanime.php">

Top Anime

</a>

</li>

<li>

<a href="genre.php">

Genre

</a>

</li>

<li>

<a href="about.php">

About

</a>

</li>

<li>

<a href="contact.php">

Contact

</a>

</li>

</ul>

</nav>

<!-- ================= HEADER ================= -->

<section class="hero">

<div class="hero-text">

<h1>

🔥 Top Anime

</h1>

<p>

Daftar anime dengan rating tertinggi
berdasarkan data dari
Jikan API.

</p>

</div>

</section>

<!-- ================= CONTENT ================= -->

<div class="container">

<h2 class="page-title">

Top 24 Anime Terpopuler

</h2>

<div class="grid">

<?php foreach($animeList as $anime){ ?>

<div class="card">

<img
src="<?php echo $anime['images']['jpg']['large_image_url']; ?>"
alt="<?php echo htmlspecialchars($anime['title']); ?>">

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

<div class="badge">

<span>

<?php echo htmlspecialchars($anime['status']); ?>

</span>

<span>

<?php echo htmlspecialchars($anime['type']); ?>

</span>

<span>

<?php echo htmlspecialchars($anime['year'] ?? "-"); ?>

</span>

</div>

<p>

<?php

$text = $anime['synopsis'] ?? "";

if(strlen($text)>150){

$text = substr($text,0,150)."....";

}

echo htmlspecialchars($text);

?>

</p>
<a
class="btn-detail"
href="detail.php?id=<?php echo $anime['mal_id']; ?>">

<i class="fa-solid fa-circle-info"></i>

Lihat Detail

</a>

<a
class="btn-mal"
href="<?php echo $anime['url']; ?>"
target="_blank">

<i class="fa-solid fa-arrow-up-right-from-square"></i>

MyAnimeList

</a>

</div>

</div>

<?php } ?>

</div>

</div>

<!-- ================= FOOTER ================= -->

<footer>

<div class="footer-content">

<div>

<h3>

AnimeKu

</h3>

<p>

Website pencarian anime menggunakan
Jikan API.

</p>

</div>

<div>

<h3>

Menu

</h3>

<ul>

<li>

<a href="index.php">

Home

</a>

</li>

<li>

<a href="topanime.php">

Top Anime

</a>

</li>

<li>

<a href="genre.php">

Genre

</a>

</li>

<li>

<a href="about.php">

About

</a>

</li>

<li>

<a href="contact.php">

Contact

</a>

</li>

</ul>

</div>

<div>

<h3>

Developer

</h3>

<p>

Deva Yohand Pangestu

</p>

<p>

Universitas Muhammadiyah Surakarta

</p>

</div>

</div>

<hr>

<p class="copyright">

© 2026 AnimeKu

Powered by Jikan API

</p>

</footer>

<script>

window.addEventListener("load",function(){

console.log("Top Anime Loaded");

});

</script>

</body>

</html>

