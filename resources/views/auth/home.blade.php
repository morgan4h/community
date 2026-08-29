<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
     <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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


    <h1>Welcome, {{ $user->name }}!</h1>
<div class="live-football">
<iframe width="908" height="511" src="https://www.youtube.com/embed/dbuDLhMcyC8" title="Liverpool vs Nottingham LIVE: Premier League 2026 | Liverpool vs Nottingham Football LIVE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</div>
    <div class="movie">
       <iframe  src="https://www.youtube.com/embed/lSA7mAHolAw" title="V For Vendetta (2005) Official Trailer #1 - Sc-Fi Thriller HD" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>

    <form action="/logout" method="POST">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

        <!-- Newsletter section -->
        <div class="footer-newsletter">

            <h3>Stay Updated</h3>

            <p>
                Subscribe to our newsletter to receive the latest
                movie and football updates.
            </p>

            <form action="/subscribe" method="POST">

                @csrf

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required>

                <button type="submit">
                    Subscribe
                </button>

            </form>

        </div>


        <!-- Social media section -->
        <div class="footer-social">

            <h3>Follow Us</h3>

            <a href="#" aria-label="Facebook">
                Facebook
            </a>

            <a href="#" aria-label="Instagram">
                Instagram
            </a>

            <a href="#" aria-label="YouTube">
                YouTube
            </a>

            <a href="#" aria-label="TikTok">
                TikTok
            </a>

            <a href="#" aria-label="X">
                X
            </a>

        </div>


        <!-- Bottom footer -->
        <div class="footer-bottom">

            <p>
                &copy; 2026 My Website.
                All rights reserved.
            </p>

            <p>
                Made with HTML, CSS, PHP and Laravel.
            </p>

        </div>

    </footer>
</body>
</html>
