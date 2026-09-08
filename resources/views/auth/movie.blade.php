<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMK TV - Movies</title>
    <link rel="stylesheet" href="{{ asset('css/movie.css') }}">
</head>
<body>

<nav>
    <h1>TMK <span>TV</span></h1>
    <ul>
        <li><a href="/home" style="color:inherit; text-decoration:none;">LIVE</a></li>
        <li class="active">MOVIES</li>
        <li><a href="/sport" style="color:inherit; text-decoration:none;">TMK SPORT</a></li>
    </ul>
</nav>    

<header>
    <div class="live-badge">
        <span class="red-dot"></span> NOW PLAYING
    </div>
    <div class="player-glass-container">
        <div class="hero-overlay"></div>
        <!-- Player iframe: Loads the first movie's link or a default fallback -->
        <iframe id="main-player" 
                src="{{ $movies->first()->api ?? 'https://1vid.xyz/embed-y735bv8s8am1.html' }}" 
                allowfullscreen="true" 
                webkitallowfullscreen="true" 
                mozallowfullscreen="true">
        </iframe>
    </div>
</header>

<div class="category">
    <div class="movie">
        <div class="box-of-the-show">
            @forelse($movies as $item)
                <div class="movie-card" onclick="playMovie('{{ $item->api }}')">
                    <p>{{ $item->name }}</p>
                </div>
            @empty
                <div class="movie-card">
                    <p>No movies available right now.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <div class="sponsoers">
        <div class="sponsore1"></div>
        <div class="sponsore1"></div>
        <div class="sponsore1"></div>
        <div class="sponsore1"></div>
        <div class="sponsore1"></div>
    </div>
</div>

<!-- Inline JavaScript to switch video sources -->
<script>
    function playMovie(embedUrl) {
        const player = document.getElementById('main-player');
        if (player && embedUrl) {
            player.src = embedUrl;
            // Smoothly scroll back to the player on click
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
</script>

</body>
</html>