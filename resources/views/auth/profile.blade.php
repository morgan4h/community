<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMK 4H - User Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #050505;
            color: white;
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: #111;
            border-right: 1px solid #222;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 25px;
            color: #168cff;
            font-size: 24px;
            font-weight: 900;
            border-bottom: 1px solid #1a1a1a;
        }

        .sidebar-logo span {
            display: block;
            color: #aaa;
            font-size: 10px;
            letter-spacing: 2px;
            margin-top: 2px;
        }

        .nav-menu {
            list-style: none;
            padding: 20px 0;
            flex-grow: 1;
        }

        .nav-item {
            padding: 15px 25px;
            color: #aaa;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            font-weight: bold;
            transition: 0.2s ease;
        }

        .nav-item:hover,
        .nav-item.active {
            color: #168cff;
            background: #181818;
            border-left: 4px solid #168cff;
        }

        .sidebar-footer {
            padding: 20px 25px;
            border-top: 1px solid #1a1a1a;
            font-size: 12px;
            color: #555;
        }

        /* MAIN CONTENT AREA */
        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            padding: 30px 40px;
            min-height: 100vh;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #1a1a1a;
        }

        .header h1 {
            font-size: 28px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #181818;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid #222;
        }

        .avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #168cff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        /* PROFILE SECTION STYLES */
        .profile-card {
            background: #181818;
            border-radius: 10px;
            border: 1px solid #222;
            padding: 30px;
            max-width: 800px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .profile-header-flex {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #222;
        }

        .profile-avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #168cff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 32px;
            color: white;
            border: 2px solid #222;
        }

        .profile-user-info h2 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .profile-user-info p {
            color: #888;
            font-size: 14px;
        }

        .profile-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 13px;
            color: #aaa;
            font-weight: bold;
        }

        .form-control {
            background: #111;
            border: 1px solid #333;
            padding: 10px 14px;
            border-radius: 6px;
            color: white;
            font-size: 14px;
            outline: none;
            display: none;
        }

        .form-control:focus {
            border-color: #168cff;
        }

        .static-value {
            font-size: 15px;
            color: #ddd;
            padding: 10px 0;
        }

        .checkbox-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 5px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #ccc;
            cursor: pointer;
        }

        .checkbox-label input {
            accent-color: #168cff;
            width: 16px;
            height: 16px;
        }

        .profile-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #222;
        }

        /* BUTTONS */
        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            transition: 0.2s ease;
        }

        .btn-primary {
            background: #168cff;
            color: white;
        }

        .btn-primary:hover {
            opacity: 0.85;
        }

        .btn-secondary {
            background: #222;
            color: white;
            border: 1px solid #333;
        }

        .btn-secondary:hover {
            background: #2a2a2a;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 900px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-logo span,
            .nav-item span,
            .sidebar-footer {
                display: none;
            }

            .main-content {
                margin-left: 70px;
                padding: 20px;
            }

            .nav-item {
                justify-content: center;
                padding: 20px 0;
            }

            .profile-form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            TMK 4H
            <span>USER PANEL</span>
        </div>

        <ul class="nav-menu">
            <li class="nav-item active">
                👤 <span>My Profile</span>
            </li>
            <li class="nav-item">
                🎬 <span>My Watchlist</span>
            </li>
            <li class="nav-item">
                ⚙️ <span>Settings</span>
            </li>
        </ul>

        <div class="sidebar-footer">
            © 2026 TMK 4H Community
        </div>
    </aside>

    <!-- MAIN CONTENT CONTAINER -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="header">
            <h1 id="page-title">My Profile</h1>
            <div class="user-profile">
                <div class="avatar">A</div>
                <span id="header-username">Alex Johnson</span>
            </div>
        </header>

        <!-- PROFILE SECTION -->
        <section class="dashboard-section active">
            <div class="profile-card">
                <div class="profile-header-flex">
                    <div class="profile-avatar-large">A</div>
                    <div class="profile-user-info">
                        <h2 id="display-name">Alex Johnson</h2>
                        <p id="display-email">alex.johnson@example.com</p>
                    </div>
                </div>

                <div class="profile-form-grid">
                    <!-- Full Name -->
                    <div class="form-group">
                        <label>Full Name</label>
                        <div class="static-value" id="val-name">Alex Johnson</div>
                        <input type="text" class="form-control" id="input-name" value="Alex Johnson">
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="static-value" id="val-email">alex.johnson@example.com</div>
                        <input type="email" class="form-control" id="input-email" value="alex.johnson@example.com">
                    </div>

                    <!-- Nationality -->
                    <div class="form-group">
                        <label>Nationality</label>
                        <div class="static-value" id="val-nationality">United States</div>
                        <input type="text" class="form-control" id="input-nationality" value="United States">
                    </div>

                    <!-- Birthday -->
                    <div class="form-group">
                        <label>Birthday</label>
                        <div class="static-value" id="val-birthday">1998-05-14</div>
                        <input type="date" class="form-control" id="input-birthday" value="1998-05-14">
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label>Gender</label>
                        <div class="static-value" id="val-gender">Male</div>
                        <select class="form-control" id="input-gender">
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Interests Checkboxes -->
                    <div class="form-group full-width">
                        <label>Interests</label>
                        <div class="static-value" id="val-interests">Anime, Movies, Gaming</div>
                        <div class="checkbox-group form-control" id="input-interests-group" style="border: none; background: transparent; padding: 0;">
                            <label class="checkbox-label"><input type="checkbox" name="interest" value="Anime" checked> Anime</label>
                            <label class="checkbox-label"><input type="checkbox" name="interest" value="Movies" checked> Movies</label>
                            <label class="checkbox-label"><input type="checkbox" name="interest" value="Gaming" checked> Gaming</label>
                            <label class="checkbox-label"><input type="checkbox" name="interest" value="Sports"> Sports</label>
                            <label class="checkbox-label"><input type="checkbox" name="interest" value="Tech"> Tech</label>
                        </div>
                    </div>
                </div>

                <div class="profile-actions">
                    <button class="btn btn-primary" id="editToggleBtn" onclick="toggleEditProfile()">Change Info</button>
                    <button class="btn btn-primary" id="saveBtn" style="display: none; background: #00ff88; color: #000;" onclick="saveProfile()">Save Changes</button>
                    <button class="btn btn-secondary" onclick="sendPasswordResetRequest()">Send Request for Changing Password</button>
                </div>
            </div>
        </section>

    </main>

    <script>
        let isEditing = false;

        function toggleEditProfile() {
            isEditing = !isEditing;
            const staticValues = document.querySelectorAll('.static-value');
            const formControls = document.querySelectorAll('.form-control');
            const editBtn = document.getElementById('editToggleBtn');
            const saveBtn = document.getElementById('saveBtn');

            if (isEditing) {
                staticValues.forEach(el => el.style.display = 'none');
                formControls.forEach(el => el.style.display = 'block');
                editBtn.innerText = 'Cancel';
                saveBtn.style.display = 'inline-block';
            } else {
                staticValues.forEach(el => el.style.display = 'block');
                formControls.forEach(el => el.style.display = 'none');
                document.getElementById('input-interests-group').style.display = 'none';
                editBtn.innerText = 'Change Info';
                saveBtn.style.display = 'none';
            }
        }

        function saveProfile() {
            const newName = document.getElementById('input-name').value;
            const newEmail = document.getElementById('input-email').value;
            const newNationality = document.getElementById('input-nationality').value;
            const newBirthday = document.getElementById('input-birthday').value;
            const newGender = document.getElementById('input-gender').value;

            const checkedInterests = [];
            document.querySelectorAll('input[name="interest"]:checked').forEach(cb => {
                checkedInterests.push(cb.value);
            });

            document.getElementById('val-name').innerText = newName;
            document.getElementById('val-email').innerText = newEmail;
            document.getElementById('val-nationality').innerText = newNationality;
            document.getElementById('val-birthday').innerText = newBirthday;
            document.getElementById('val-gender').innerText = newGender;
            document.getElementById('val-interests').innerText = checkedInterests.join(', ') || 'None selected';

            document.getElementById('display-name').innerText = newName;
            document.getElementById('display-email').innerText = newEmail;
            document.getElementById('header-username').innerText = newName;

            toggleEditProfile();
            alert('Your profile has been updated successfully!');
        }

        function sendPasswordResetRequest() {
            alert('A password change request link has been sent to your email.');
        }
    </script>
</body>

</html>