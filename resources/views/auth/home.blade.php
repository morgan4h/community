<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>TMK 4H Community</title>


<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}


body{

    background:#050505;

    color:white;

}



/* NAVBAR */


.navbar{

    position:fixed;

    top:0;

    width:100%;

    height:75px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:0 45px;

    background:linear-gradient(
        rgba(0,0,0,.9),
        transparent
    );

    z-index:10;

}



.logo{

    color:#168cff;

    font-size:32px;

    font-weight:900;

}



.logo span{

    display:block;

    color:#aaa;

    font-size:11px;

    letter-spacing:3px;

}



.nav-links a{

    color:white;

    text-decoration:none;

    margin-left:25px;

    font-size:15px;

}



.nav-links a:hover{

    color:#168cff;

}





/* HERO */


.hero{

    height:90vh;

    padding:130px 60px 50px;

    background:

    linear-gradient(
        to right,
        #000,
        transparent
    ),

    radial-gradient(
        circle at center,
        #333,
        #050505
    );



    display:flex;

    align-items:center;

}



.hero-content{

    max-width:600px;

}



.hero h1{

    font-size:55px;

    margin-bottom:20px;

}



.hero p{

    color:#bbb;

    line-height:1.6;

}



.buttons{

    margin-top:30px;

}



.btn{

    padding:14px 30px;

    border:none;

    border-radius:5px;

    margin-right:15px;

    cursor:pointer;

    font-weight:bold;

}



.watch{

    background:#168cff;

    color:white;

}



.info{

    background:#333;

    color:white;

}





/* FEATURE CARDS */


.features{

    padding:40px 60px;

}



.title{

    font-size:30px;

    margin-bottom:25px;

}



.cards{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:20px;

}



.card{

    height:230px;

    background:#181818;

    border-radius:10px;

    padding:25px;

    display:flex;

    flex-direction:column;

    justify-content:end;

    box-shadow:0 10px 30px #000;

}



.card h2{

    margin-bottom:10px;

}



.live{

    border:2px solid #168cff;

}





/* CATEGORY */


.categories{

    padding:50px 60px;

}



.category-buttons{

    display:flex;

    flex-wrap:wrap;

    gap:15px;

}



.category-buttons button{

    padding:13px 25px;

    background:#222;

    color:white;

    border:1px solid #333;

    border-radius:20px;

    cursor:pointer;

}



.category-buttons button:hover{

    background:#168cff;

}




.results{

    margin-top:30px;

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

}



.item{

    background:#181818;

    padding:20px;

    border-radius:8px;

}





/* FOOTER */


footer{

    margin-top:60px;

    padding:40px;

    text-align:center;

    background:#111;

    color:#777;

}





/* RESPONSIVE */


@media(max-width:800px){


.navbar{

    padding:0 20px;

}


.nav-links{

    display:none;

}


.hero{

    padding:120px 25px 40px;

    height:80vh;

}


.hero h1{

    font-size:38px;

}


.features,
.categories{

    padding:35px 25px;

}


.cards{

    grid-template-columns:1fr;

}


.results{

    grid-template-columns:1fr;

}


}



</style>

</head>



<body>



<nav class="navbar">


<div class="logo">

<span>community</span>

TMK 4H

</div>



<div class="nav-links">

<a href="#">Home</a>

<a href="#">Movies</a>

<a href="#">Sport</a>

<a href="#">Anime</a>

<a href="/pr">Profile</a>

</div>


</nav>





<section class="hero">
<div class="hero-content">

<h1>
{{ $notification['notification_name'] ?? 'Default Title' }}
</h1>

<p>
{{ $notification['notification_description'] ?? 'Default Description' }}
</p>

<div class="buttons">
    <a href="{{ $notification['notification_attr'] ?? '#' }}" class="btn watch" style="text-decoration: none; display: inline-block;">
        ▶ Watch Now
    </a>

    <button class="btn info">
        More Info
    </button>
</div>

</div>
</section>






<section class="features">


<h2 class="title">
Trending Today
</h2>



<div class="cards">


<div class="card">

<h2>
🔥 Hot Show
</h2>

<p>
The most watched show today
</p>

</div>




<div class="card">

<h2>
🎬 Movie
</h2>

<p>
New movie release
</p>

</div>




<div class="card live">

<h2>
⚽ LIVE Football
</h2>

<p>
Barcelona vs Real Madrid
</p>

</div>


</div>


</section>








<section class="categories">


<h2 class="title">

What are you looking for?

</h2>



<div class="category-buttons">


<button onclick="showCategory('sport')">
Sport
</button>


<button onclick="showCategory('movie')">
Movies
</button>


<button onclick="showCategory('tv')">
TV Shows
</button>


<button onclick="showCategory('anime')">
Anime
</button>


<button onclick="showCategory('live')">
Live Stream
</button>


</div>




<div class="results" id="results">

</div>


</section>







<footer>

© 2026 TMK 4H Community

<br>

Movies • Sport • Anime • Live

</footer>







<script>


const content = {


sport:[

"Champions League",

"NBA Finals",

"World Cup Highlights",

"Extreme Sports"

],



movie:[

"Action Movie 2026",

"Space Adventure",

"Comedy Night",

"Thriller Zone"

],



tv:[

"Reality Show",

"Drama Series",

"Documentary",

"News Live"

],



anime:[

"Attack Style Anime",

"Fantasy World",

"New Season Anime",

"Classic Anime"

],



live:[

"Football Live",

"Gaming Stream",

"Concert Live",

"Event Broadcast"

]


};






function showCategory(type){


let box=document.getElementById("results");


box.innerHTML="";



content[type].forEach(item=>{


let div=document.createElement("div");


div.className="item";


div.innerHTML=item;


box.appendChild(div);


});


}



showCategory("sport");



</script>




</body>

</html>