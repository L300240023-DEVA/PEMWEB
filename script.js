// ======================================
// AnimeKu - script.js
// Menggunakan Jikan API v4
// ======================================

const api = "https://api.jikan.moe/v4/anime?q=";

const container = document.getElementById("anime-container");
const loading = document.getElementById("loading");

// ===============================
// SEARCH ANIME
// ===============================

async function searchAnime() {

    let keyword = document.getElementById("search").value.trim();

    if (keyword == "") {

        alert("Masukkan judul anime terlebih dahulu.");

        return;

    }

    showLoading();

    try {

        const response = await fetch(api + encodeURIComponent(keyword) + "&limit=12");

        const result = await response.json();

        hideLoading();

        if (result.data.length == 0) {

            container.innerHTML = `
            <div class="not-found">

                <h2>Anime Tidak Ditemukan</h2>

                <p>

                Coba gunakan kata kunci lain.

                </p>

            </div>
            `;

            return;

        }

        tampilkanAnime(result.data);

    }

    catch(error){

        hideLoading();

        container.innerHTML=`

        <div class="error">

        <h2>Terjadi Kesalahan</h2>

        <p>

        Tidak dapat mengambil data API.

        </p>

        </div>

        `;

        console.log(error);

    }

}

// =======================================
// TAMPILKAN DATA
// =======================================

function tampilkanAnime(list){

let html="";

list.forEach(item=>{

let score=item.score ?? "-";

let episode=item.episodes ?? "?";

let status=item.status ?? "-";

let type=item.type ?? "-";

let year="-";

if(item.year){

year=item.year;

}

let synopsis=item.synopsis ?? "";

if(synopsis.length>180){

synopsis=synopsis.substring(0,180)+"...";

}

html+=`

<div class="anime-card">

<div class="anime-image">

<img
src="${item.images.jpg.large_image_url}"
alt="${item.title}">

</div>

<div class="anime-body">

<h2>

${item.title}

</h2>

<div class="rating">

⭐ ${score}

</div>

<div class="info">

<span>

🎬 ${episode} Episode

</span>

<span>

📅 ${year}

</span>

</div>

<div class="badge">

<span>${type}</span>

<span>${status}</span>

</div>

<p>

${synopsis}

</p>

<div class="button-group">

<a
href="detail.php?id=${item.mal_id}"
class="btn-detail">

Lihat Detail

</a>

<a
href="${item.url}"
target="_blank"
class="btn-mal">

MyAnimeList

</a>

</div>

</div>

</div>

`;

});

container.innerHTML=html;

}

// ====================================
// LOADING
// ====================================

function showLoading(){

loading.style.display="block";

container.innerHTML="";

}

function hideLoading(){

loading.style.display="none";

}

// ====================================
// QUICK SEARCH
// ====================================

function quickSearch(keyword){

document.getElementById("search").value=keyword;

searchAnime();

}

// ====================================
// ENTER SEARCH
// ====================================

const input=document.getElementById("search");

if(input){

input.addEventListener("keypress",function(e){

if(e.key==="Enter"){

searchAnime();

}

});

}

// ====================================
// AUTO LOAD
// ====================================

window.onload=function(){

quickSearch("Naruto");

};
// ======================================
// RANDOM ANIME
// ======================================

async function randomAnime(){

showLoading();

try{

const response = await fetch("https://api.jikan.moe/v4/random/anime");

const result = await response.json();

hideLoading();

tampilkanAnime([result.data]);

}
catch(error){

hideLoading();

console.log(error);

}

}

// ======================================
// TOP ANIME
// ======================================

async function topAnime(){

showLoading();

try{

const response = await fetch("https://api.jikan.moe/v4/top/anime?limit=12");

const result = await response.json();

hideLoading();

tampilkanAnime(result.data);

}
catch(error){

hideLoading();

console.log(error);

}

}

// ======================================
// FILTER BERDASARKAN SCORE
// ======================================

function filterScore(minScore){

const cards=document.querySelectorAll(".anime-card");

cards.forEach(card=>{

let rating=card.querySelector(".rating").innerText;

rating=parseFloat(rating.replace("⭐",""));

if(rating>=minScore){

card.style.display="block";

}else{

card.style.display="none";

}

});

}

// ======================================
// SCROLL KE ATAS
// ======================================

const scrollBtn=document.createElement("button");

scrollBtn.innerHTML="⬆";

scrollBtn.id="scrollTop";

document.body.appendChild(scrollBtn);

scrollBtn.style.position="fixed";
scrollBtn.style.right="20px";
scrollBtn.style.bottom="20px";
scrollBtn.style.width="50px";
scrollBtn.style.height="50px";
scrollBtn.style.borderRadius="50%";
scrollBtn.style.border="none";
scrollBtn.style.background="#ff9800";
scrollBtn.style.color="#fff";
scrollBtn.style.cursor="pointer";
scrollBtn.style.display="none";
scrollBtn.style.fontSize="20px";

window.addEventListener("scroll",()=>{

if(window.scrollY>300){

scrollBtn.style.display="block";

}else{

scrollBtn.style.display="none";

}

});

scrollBtn.onclick=function(){

window.scrollTo({

top:0,

behavior:"smooth"

});

};

// ======================================
// TOAST NOTIFICATION
// ======================================

function toast(text){

const toast=document.createElement("div");

toast.innerHTML=text;

toast.style.position="fixed";
toast.style.bottom="90px";
toast.style.right="20px";
toast.style.background="#333";
toast.style.color="white";
toast.style.padding="15px";
toast.style.borderRadius="10px";
toast.style.zIndex="9999";

document.body.appendChild(toast);

setTimeout(()=>{

toast.remove();

},3000);

}

// ======================================
// FAVORITE
// ======================================

let favorite=[];

function addFavorite(id,title){

favorite.push({

id:id,

title:title

});

toast(title+" ditambahkan ke Favorite");

console.log(favorite);

}

// ======================================
// COPY LINK
// ======================================

function copyURL(){

navigator.clipboard.writeText(window.location.href);

toast("Link berhasil disalin");

}

// ======================================
// SHARE
// ======================================

function shareAnime(title){

if(navigator.share){

navigator.share({

title:title,

text:"Lihat anime ini",

url:window.location.href

});

}else{

copyURL();

}

}

// ======================================
// SEARCH DENGAN DELAY
// ======================================

let typingTimer;

const delay=700;

if(input){

input.addEventListener("keyup",()=>{

clearTimeout(typingTimer);

typingTimer=setTimeout(()=>{

if(input.value!=""){

searchAnime();

}

},delay);

});

}

// ======================================
// PREVIEW GAMBAR
// ======================================

document.addEventListener("mouseover",function(e){

if(e.target.tagName=="IMG"){

e.target.style.transform="scale(1.05)";
e.target.style.transition=".3s";

}

});

document.addEventListener("mouseout",function(e){

if(e.target.tagName=="IMG"){

e.target.style.transform="scale(1)";

}

});

// ======================================
// HITUNG HASIL
// ======================================

function jumlahAnime(){

let jumlah=document.querySelectorAll(".anime-card").length;

console.log("Total Anime :",jumlah);

}

// ======================================
// REFRESH
// ======================================

function refreshData(){

searchAnime();

toast("Data diperbarui");

}

// ======================================
// MODE GRID / LIST
// ======================================

function modeGrid(){

container.classList.remove("list-mode");

}

function modeList(){

container.classList.add("list-mode");

}

// ======================================
// CEK KONEKSI
// ======================================

window.addEventListener("offline",()=>{

alert("Tidak ada koneksi internet");

});

window.addEventListener("online",()=>{

toast("Koneksi kembali");

});