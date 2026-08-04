<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - TMK 4H Community</title>
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
            padding:120px 20px 80px;
            overflow-y:auto;
        }

        /* LOGO */
        .logo{
            position:absolute;
            top:35px;
            left:45px;
            color:#168cff;
            font-size:38px;
            font-weight:900;
            letter-spacing:-2px;
            line-height:.9;
        }

        .community{
            display:block;
            color:#aaa;
            font-size:14px;
            letter-spacing:3px;
            font-weight:500;
            margin-left:4px;
            margin-bottom:6px;
        }

        /* JOIN / LOGIN BOX */
        .join-box{
            width:440px;
            max-width:100%;
            padding:45px;
            background:rgba(15,15,15,.88);
            border-radius:12px;
            box-shadow: 0 20px 60px rgba(0,0,0,.8);
        }

        .join-box h1{
            font-size:32px;
            margin-bottom:25px;
        }

        /* INPUTS */
        .input{
            width:100%;
            padding:15px;
            margin-bottom:15px;
            border-radius:5px;
            border:1px solid #444;
            background:#222;
            color:white;
            font-size:15px;
        }

        .input::placeholder{
            color:#888;
        }

        .input:focus{
            outline:none;
            border-color:#168cff;
        }

        /* ERROR MESSAGES & STATUS */
        .error-msg {
            color: #ff4d4d;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 12px;
            display: block;
        }

        .status-msg {
            color: #4ade80;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }

        /* REMEMBER ME & FORGOT PASSWORD ROW */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #aaa;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input {
            accent-color: #168cff;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-password {
            color: #aaa;
            text-decoration: none;
            transition: .2s;
        }

        .forgot-password:hover {
            color: #168cff;
        }

        /* BUTTON */
        button{
            width:100%;
            padding:15px;
            border:none;
            border-radius:5px;
            background:#168cff;
            color:white;
            font-size:17px;
            font-weight:bold;
            cursor:pointer;
            transition:.3s;
        }

        button:hover{
            background:#006fe6;
        }

        /* SIGNUP LINK */
        .login{
            margin-top:25px;
            text-align:center;
            color:#aaa;
        }

        .login a{
            color:white;
            text-decoration:none;
        }

        .login a:hover{
            color:#168cff;
        }

        /* FOOTER */
        .footer{
            position:fixed;
            bottom:15px;
            left:0;
            width:100%;
            text-align:center;
            color:#777;
            font-size:13px;
        }

        /* MEDIA QUERIES */
        @media(max-width:768px){
            .logo{ top:25px; left:30px; font-size:34px; }
            .join-box{ width:90%; padding:40px; }
        }

        @media(max-width:500px){
            body{ padding:100px 15px 70px; align-items:flex-start; }
            .logo{ top:20px; left:20px; font-size:30px; }
            .community{ font-size:11px; }
            .join-box{ width:100%; max-width:380px; padding:30px 22px; margin-top:20px; }
            .join-box h1{ font-size:26px; }
            .input{ padding:14px; }
            button{ padding:14px; }
            .footer{ font-size:11px; bottom:8px; }
            .form-options { flex-direction: column; gap: 10px; align-items: flex-start; }
        }

        @media(max-width:360px){
            .logo{ font-size:26px; }
            .join-box{ padding:25px 18px; }
        }
    </style>
</head>
<body>

    <div class="logo">
        <span class="community">community</span>
        TMK 4H
    </div>

    <div class="join-box">
        <h1>Sign In</h1>

        <!-- Session Status (Displays status messages like "Password reset link sent") -->
        @if (session('status'))
            <div class="status-msg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required autofocus autocomplete="username">
            @error('email')
                <span class="error-msg">{{ $message }}</span>
            @enderror

            <!-- Password -->
            <input class="input" type="password" name="password" placeholder="Password" required autocomplete="current-password">
            @error('password')
                <span class="error-msg">{{ $message }}</span>
            @enderror

            <!-- Remember Me & Forgot Password -->
            <div class="form-options">
                <label for="remember_me" class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit">Log In</button>
        </form>

        <div class="login">
            New to TMK 4H?
            <a href="{{ route('register') }}">Create Account</a>
        </div>
    </div>

    <div class="footer">
        © 2026 TMK 4H Community. All rights reserved.
    </div>

</body>
</html>