<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEO</title>
    <link rel="stylesheet" href="{{ asset('css/ceo.css') }}">
</head>
<body>
    <nav>
        <h1>ceo</h1>
        <ul>
            <li>users</li>
            <li>content</li>
            <li>add link</li>
        </ul>
    </nav>
    
    <div class="users panel-section">
        <div class="user">
            <h1>the name</h1>
            <p>role</p>
            <button class="btn-delete">delete</button>
            <button>update</button>
        </div>
    </div>

    <div class="content panel-section">
        <div class="link">
            <h1>name of the link</h1>
            <p><a href="#" target="_blank">the link</a></p>
            <button class="btn-delete">delete</button>
            <button>update</button>
        </div>
    </div>

    <div class="add-link panel-section">
        <h2>add link</h2>
        <p>add new link</p>
        <input type="text" placeholder="name of the link">
        <input type="text" placeholder="the api or url that we need to use">
        <button>add link</button>
    </div>

    <script src="{{ asset('js/ceo.js') }}"></script>
</body>
</html>