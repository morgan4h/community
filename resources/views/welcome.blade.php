<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMK TV - Login</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/movies">Movies</a></li>
            <li><a href="/football">Football</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
    </nav>

    <div class="login-card-wrapper">
        <div class="apple-hero-login">
            <span class="japanese-subtag">ようこそ • サインイン</span>
            <h1>Enter Your Name</h1>
            <p class="hero-subtitle">Access your personalized TMK TV destination.</p>
        </div>

        <div class="login-card">
            @if(session('error'))
            <p class="alert-box">{{ session('error') }}</p>
            @endif

            @if($errors->any())
            <ul class="alert-box-list">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif

            <form action="/name" method="POST">
                @csrf
                <div class="form-field-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="e.g. Alex" required autocomplete="off">
                </div>
                <button type="submit">Continue &rarr;</button>
            </form>
        </div>
    </div>

    <footer>
        <!-- Footer content remains the same -->
        <div class="footer-container">
            <div class="footer-section">
                <h2>TMK TV</h2>
                <p>Welcome to our website. Discover movies, football, entertainment, live events, and much more.</p>
            </div>
            <div class="footer-section">
                <h3>Movies</h3>
                <ul>
                    <li><a href="/movies">All Movies</a></li>
                    <li><a href="/movies/action">Action</a></li>
                    <li><a href="/movies/comedy">Comedy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Football</h3>
                <ul>
                    <li><a href="/football">Football Home</a></li>
                    <li><a href="/football/live">Live Matches</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Website</h3>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Legal</h3>
                <ul>
                    <li><a href="/privacy">Privacy Policy</a></li>
                    <li><a href="/terms">Terms of Service</a></li>
                </ul>
            </div>
        </div>

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
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
            <a href="#">YouTube</a>
            <a href="#">TikTok</a>
            <a href="#">X</a>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 My Website. All rights reserved.</p>
            <p>Made with HTML, CSS, PHP and Laravel.</p>
        </div>
    </footer>
</body>

</html>