<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - TMK 4H Community</title>
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            min-height:100vh;
            background:
            linear-gradient(rgba(0,0,0,.78), rgba(0,0,0,.92)),
            radial-gradient(circle at top, #1b1b1b, #050505 70%);
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
            padding:20px;
        }

        .welcome-box{
            width:480px;
            max-width:100%;
            padding:45px;
            background:rgba(15,15,15,.88);
            border-radius:12px;
            box-shadow: 0 20px 60px rgba(0,0,0,.8);
            text-align: center;
        }

        .logo{
            color:#168cff;
            font-size:42px;
            font-weight:900;
            letter-spacing:-2px;
            margin-bottom:10px;
        }

        .community{
            display:block;
            color:#aaa;
            font-size:14px;
            letter-spacing:3px;
            font-weight:500;
            margin-bottom:20px;
        }

        p{
            color:#aaa;
            font-size:15px;
            margin-bottom:30px;
        }

        .nav-links{
            display:flex;
            flex-direction:column;
            gap:12px;
        }

        .btn{
            display:block;
            width:100%;
            padding:14px;
            border-radius:6px;
            text-decoration:none;
            font-weight:bold;
            font-size:16px;
            transition:.3s;
            text-align:center;
            border:none;
            cursor:pointer;
        }

        .btn-primary{
            background:#168cff;
            color:white;
        }

        .btn-primary:hover{
            background:#006fe6;
        }

        .btn-secondary{
            background:#222;
            color:#ddd;
            border:1px solid #444;
        }

        .btn-secondary:hover{
            background:#333;
            color:white;
        }

        .btn-danger{
            background:#333;
            color:#ff4d4d;
            border:1px solid #444;
        }

        .btn-danger:hover{
            background:#440000;
        }

        .footer{
            position:fixed;
            bottom:15px;
            left:0;
            width:100%;
            text-align:center;
            color:#777;
            font-size:13px;
        }
    </style>
</head>
<body>

    <div class="welcome-box">
        <div class="logo">
            TMK 4H
            <span class="community">COMMUNITY</span>
        </div>

        <p>Welcome to our platform! Please sign in or create an account to continue.</p>

        <div class="nav-links">
            <!-- CHECK IF USER IS LOGGED IN -->
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                
                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log Out</button>
                </form>
            @else
                <!-- IF USER IS A GUEST -->
                <a href="{{ route('login') }}" class="btn btn-primary">Log In</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-secondary">Join Community</a>
                @endif
            @endauth
        </div>
    </div>

    <div class="footer">
        © 2026 TMK 4H Community. All rights reserved.
    </div>

</body>
</html>