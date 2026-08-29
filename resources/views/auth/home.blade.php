<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

    <h1>Welcome, {{ $user->name }}!</h1>

    <div class="live-football">
        <i>Create live stream of football</i>
    </div>

    <div class="movie">
        <p>Put here movie of V for Vendetta</p>
    </div>

    <form action="/logout" method="POST">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

</body>
</html>
