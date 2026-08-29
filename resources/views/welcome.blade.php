<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h1>Enter Your Name</h1>

    @if(session('error'))
        <p style="color: red;">
            {{ session('error') }}
        </p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
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
            required
        >

        <button type="submit">
            Enter
        </button>

    </form>

</body>
</html>
