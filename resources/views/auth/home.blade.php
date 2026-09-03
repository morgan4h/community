<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMK TV - Home</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav>
        <h1>TMK <span>TV</span></h1>
        <ul>
            <li><a href="/" class="active">Home</a></li>
            <li><a href="/movies">Movies</a></li>
            <li><a href="/football">Football</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
    </nav>

    <header class="apple-hero">
        <span class="japanese-subtag">ようこそ • プレミアムエンターテインメント</span>
        <h1>Welcome, {{ $user->name }}!</h1>
        <p class="hero-subtitle">Select your cinematic destination below.</p>
    </header>

    <main class="apple-channels-container">
        <!-- Football / Sport 3D Card -->
        <a href="/sport" class="apple-card sport-card">
            <div class="card-bg-image" style="background-image: url('https://wallpaperaccess.com/full/1884497.jpg');"></div>
            <div class="card-gradient"></div>
            <div class="card-content">
                <span class="card-badge red">
                    <span class="red-dot"></span> LIVE SPORT • 生放送
                </span>
                <h2>TMK SPORT</h2>
                <p>Immerse yourself in live beIN CONNECT style matches and high-octane sports channels.</p>
                <span class="explore-link">Watch Sport &rarr;</span>
            </div>
        </a>

        <!-- Movies 3D Card -->
        <a href="/movie" class="apple-card movie-card">
            <div class="card-bg-image" style="background-image: url('https://www.next-stage.fr/wp-content/uploads/2021/07/Netflix-miniature.jpg');"></div>
            <div class="card-gradient"></div>
            <div class="card-content">
                <span class="card-badge cyan">CINEMA • 映画</span>
                <h2>TMK MOVIES</h2>
                <p>Explore elite cinematic features, trending shows, and modern entertainment masterpieces.</p>
                <span class="explore-link">Browse Movies &rarr;</span>
            </div>
        </a>
    </main>

    <div class="user-action-bar">
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <footer>
        <div class="footer-newsletter">
            <h3>Stay Updated</h3>
            <p>Subscribe to our newsletter to receive the latest movie and football updates.</p>
            <form action="/subscribe" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>

        <div class="footer-social">
            <h3>Follow Us</h3>
            <a href="#" aria-label="Facebook">Facebook</a>
            <a href="#" aria-label="Instagram">Instagram</a>
            <a href="#" aria-label="YouTube">YouTube</a>
            <a href="#" aria-label="TikTok">TikTok</a>
            <a href="#" aria-label="X">X</a>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 My Website. All rights reserved.</p>
            <p>Made with HTML, CSS, PHP and Laravel.</p>
        </div>
    </footer>
</body>
</html>