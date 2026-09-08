<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEO</title>
    <link rel="stylesheet" href="{{ asset('css/ceo.css') }}">
    <style>
        /* Lightweight Modal Overlay Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            align-items: center; justify-content: center;
            z-index: 1000;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #fff; padding: 25px; border-radius: 8px;
            min-width: 320px; color: #333;
        }
        .modal-box h3 { margin-top: 0; }
        .modal-box input, .modal-box select {
            width: 100%; margin: 8px 0; padding: 8px; box-sizing: border-box;
        }
        .modal-actions { margin-top: 15px; text-align: right; }
        .modal-actions button { margin-left: 5px; }
        
        .category-badge {
            display: inline-block;
            background-color: #e0e0e0;
            color: #333;
            padding: 3px 8px;
            font-size: 0.85rem;
            border-radius: 4px;
            margin-top: 5px;
        }
    </style>
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
    
    <!-- USERS PANEL -->
    <div class="users panel-section">
        @forelse ($users ?? [] as $u)
            <div class="user">
                <h1>{{ $u->name }}</h1>
                <p>{{ ($u->is_admin ?? 0) == 1 ? 'admin' : 'user' }}</p>

                <!-- DELETE USER FORM -->
                <form action="/users/{{ $u->id }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" onclick="return confirm('Delete user {{ $u->name }}?')">delete</button>
                </form>

                <!-- TRIGGER UPDATE USER MODAL -->
                <button type="button" 
                        class="btn-open-user-modal" 
                        data-id="{{ $u->id }}" 
                        data-name="{{ $u->name }}" 
                        data-admin="{{ $u->is_admin ?? 0 }}">
                    update
                </button>
            </div>
        @empty
            <div class="user">
                <h1>No Users</h1>
                <p>No user records found.</p>
            </div>
        @endforelse
    </div>

    <!-- CONTENT / APIS PANEL -->
    <div class="content panel-section">
        @forelse ($apis ?? [] as $item)
            <div class="link">
                <h1>{{ $item->name }}</h1>
                <p><a href="{{ $item->api }}" target="_blank">{{ $item->api }}</a></p>
                <p><span class="category-badge">Category: {{ $item->category ?? 'General' }}</span></p>

                <!-- TRIGGER UPDATE API MODAL -->
                <button type="button" 
                        class="btn-open-api-modal" 
                        data-id="{{ $item->id }}" 
                        data-name="{{ $item->name }}" 
                        data-api="{{ $item->api }}"
                        data-category="{{ $item->category ?? '' }}">
                    update
                </button>

                <!-- DELETE API FORM -->
                <form action="/apis/{{ $item->id }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" onclick="return confirm('Delete API {{ $item->name }}?')">delete</button>
                </form>
            </div>
        @empty
            <div class="link">
                <p>No API records found.</p>
            </div>
        @endforelse
    </div>

    <!-- ADD LINK PANEL -->
    <div class="add-link panel-section">
        <h2>add link</h2>
        <p>add new link</p>

        <form action="/apis" method="POST">
            @csrf
            <input type="text" name="name" placeholder="name of the link" required>
            <input type="text" name="api" placeholder="the api or url that we need to use" required>
            <input type="text" name="category" placeholder="category (e.g. sports, movies, ceo)">
            <button type="submit">add link</button>
        </form>
    </div>

    <!-- UPDATE USER MODAL BOX -->
    <div class="modal-overlay" id="userModal">
        <div class="modal-box">
            <h3>Update User</h3>
            <form id="userUpdateForm" method="POST">
                @csrf
                @method('PUT')
                <label>Name:</label>
                <input type="text" name="name" id="modalUserName" required>

                <label>Role:</label>
                <select name="is_admin" id="modalUserAdmin">
                    <option value="0">user</option>
                    <option value="1">admin</option>
                </select>

                <div class="modal-actions">
                    <button type="button" class="btn-close-modal">Cancel</button>
                    <button type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- UPDATE API MODAL BOX -->
    <div class="modal-overlay" id="apiModal">
        <div class="modal-box">
            <h3>Update Link</h3>
            <form id="apiUpdateForm" method="POST">
                @csrf
                @method('PUT')
                <label>Name:</label>
                <input type="text" name="name" id="modalApiName" required>

                <label>API / URL:</label>
                <input type="text" name="api" id="modalApiUrl" required>

                <label>Category:</label>
                <input type="text" name="category" id="modalApiCategory" placeholder="category">

                <div class="modal-actions">
                    <button type="button" class="btn-close-modal">Cancel</button>
                    <button type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/ceo.js') }}"></script>
</body>
</html>