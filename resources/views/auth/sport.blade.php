<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMK SPORT - beIN CONNECT Style</title>
    <link rel="stylesheet" href="{{ asset('css/sport.css') }}">
</head>
<body>
    <nav>
        <h1>TMK <span>SPORT</span></h1>
        <ul>
            <li class="active">LIVE</li>
            <li>Channel's</li>
            <li><a href="/movie" style="color:inherit; text-decoration:none;">TMK MOVIE</a></li>
        </ul>
    </nav>
    <header>
        <!-- Player iframe: Loads the first sport channel link or fallback -->
        <iframe 
            id="main-player"
            src="{{ $sports->first()->api ?? 'https://new.aflam4you.org//zzremb472.php?vid=68&amp;aflam_s=1&amp;aflam_w=669&amp;aflam_h=595&amp;aflam_k=445454555' }}" 
            loading="lazy"
            allow="fullscreen"
            webkitallowfullscreen="" 
            mozallowfullscreen="" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </header>

    <div class="channel">
        @forelse($sports as $item)
            <div class="channale" onclick="playChannel('{{ $item->api }}')">
                {{ $item->name }}
            </div>
        @empty
            <div class="channale">No channels available</div>
        @endforelse
    </div>

    <!-- Inline JavaScript to switch channel stream -->
    <script>
        function playChannel(embedUrl) {
            const player = document.getElementById('main-player');
            if (player && embedUrl) {
                player.src = embedUrl;
                // Scroll back to player smoothly
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    </script>
</body>
</html>