<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMK TV - Movies</title>
    <link rel="stylesheet" href="{{ asset('css/movie.css') }}">
    <style>
        /* Card Layout Refinements */
        .movie-card {
            position: relative;
            width: 100%;
            height: 250px;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            background-color: #141414;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .movie-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.7);
        }

        /* Poster Image Fix */
        .movie-poster {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        /* Non-blocking Gradient Overlay */
        .movie-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.92) 0%, rgba(0, 0, 0, 0.2) 60%, rgba(0, 0, 0, 0) 100%);
            pointer-events: none;
        }

        /* Movie Info Alignment */
        .movie-card-info {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 12px 14px;
            box-sizing: border-box;
            z-index: 2;
        }

        .movie-title {
            color: #ffffff !important;
            font-size: 0.95rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.9);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
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
        <iframe id="main-player" 
                src="{{ $movies->first()->api ?? 'https://1vid.xyz/embed-y735bv8s8am1.html' }}" 
                allowfullscreen="true" 
                webkitallowfullscreen="true" 
                mozallowfullscreen="true"
                sandbox="allow-scripts allow-same-origin allow-forms allow-popups"
                referrerpolicy="no-referrer">
        </iframe>
    </div>
</header>

<div class="category">
    <div class="movie">
        <div class="box-of-the-show">
            @forelse($movies as $item)
                <!-- Card using dynamic img tag with $item->url -->
                <div class="movie-card" onclick="playMovie('{{ $item->api }}')">
                    <img src="{{ $item->url ?? 'https://via.placeholder.com/300x450?text=No+Poster' }}" 
                         alt="{{ $item->name }}" 
                         class="movie-poster" 
                         loading="lazy">
                    <div class="movie-card-overlay"></div>
                    <div class="movie-card-info">
                        <p class="movie-title">{{ $item->name }}</p>
                    </div>
                </div>
            @empty
                <div class="movie-card" style="display: flex; align-items: center; justify-content: center;">
                    <p class="movie-title">No movies available.</p>
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

<script>
    function playMovie(embedUrl) {
        const player = document.getElementById('main-player');
        if (player && embedUrl) {
            player.src = embedUrl;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
</script>

</body>
</html>