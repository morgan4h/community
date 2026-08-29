<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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


    <h1>Enter Your Name</h1>

    @if(session('error'))
    <p>
        {{ session('error') }}
    </p>
    @endif

    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="/name" method="POST">

        @csrf

        <label for="name">Name:</label>

        <input
            type="text"
            id="name"
            name="name"
            required>

        <button type="submit">
            Enter
        </button>

    </form>
    <footer>

        <!-- Main footer content -->
        <div class="footer-container">

            <!-- Website information -->
            <div class="footer-section">
                <h2>My Website</h2>

                <p>
                    Welcome to our website. Discover movies, football,
                    entertainment, live events, and much more.
                </p>

                <p>
                    Our goal is to provide a simple and enjoyable place
                    for entertainment lovers.
                </p>
            </div>


            <!-- Movies -->
            <div class="footer-section">
                <h3>Movies</h3>

                <ul>
                    <li>
                        <a href="/movies">All Movies</a>
                    </li>

                    <li>
                        <a href="/movies/action">Action</a>
                    </li>

                    <li>
                        <a href="/movies/comedy">Comedy</a>
                    </li>

                    <li>
                        <a href="/movies/drama">Drama</a>
                    </li>

                    <li>
                        <a href="/movies/horror">Horror</a>
                    </li>

                    <li>
                        <a href="/movies/fantasy">Fantasy</a>
                    </li>
                </ul>
            </div>


            <!-- Football -->
            <div class="footer-section">
                <h3>Football</h3>

                <ul>
                    <li>
                        <a href="/football">Football Home</a>
                    </li>

                    <li>
                        <a href="/football/live">Live Matches</a>
                    </li>

                    <li>
                        <a href="/football/results">Results</a>
                    </li>

                    <li>
                        <a href="/football/schedule">Schedule</a>
                    </li>

                    <li>
                        <a href="/football/teams">Teams</a>
                    </li>

                    <li>
                        <a href="/football/news">Football News</a>
                    </li>
                </ul>
            </div>


            <!-- Website links -->
            <div class="footer-section">
                <h3>Website</h3>

                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>

                    <li>
                        <a href="/about">About Us</a>
                    </li>

                    <li>
                        <a href="/contact">Contact Us</a>
                    </li>

                    <li>
                        <a href="/faq">FAQ</a>
                    </li>

                    <li>
                        <a href="/help">Help Center</a>
                    </li>

                    <li>
                        <a href="/feedback">Give Feedback</a>
                    </li>
                </ul>
            </div>


            <!-- Legal -->
            <div class="footer-section">
                <h3>Legal</h3>

                <ul>
                    <li>
                        <a href="/privacy">Privacy Policy</a>
                    </li>

                    <li>
                        <a href="/terms">Terms of Service</a>
                    </li>

                    <li>
                        <a href="/cookies">Cookie Policy</a>
                    </li>

                    <li>
                        <a href="/copyright">Copyright</a>
                    </li>
                </ul>
            </div>

        </div>


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