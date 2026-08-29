<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMK 4H - Admin Dashboard</title>
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

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
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
            text-transform: uppercase;
        }

        /* SECTIONS & TABS */
        .dashboard-section {
            display: none;
        }

        .dashboard-section.active {
            display: block;
        }

        /* GRID CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #181818;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #222;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .stat-card h3 {
            font-size: 14px;
            color: #aaa;
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #fff;
        }

        .stat-card .trend {
            font-size: 12px;
            color: #00ff88;
            margin-top: 5px;
        }

        /* TABLES */
        .table-container {
            background: #181818;
            border-radius: 10px;
            border: 1px solid #222;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .table-header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #222;
        }

        .table-header h2 {
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th,
        td {
            padding: 15px 20px;
            border-bottom: 1px solid #222;
        }

        th {
            background: #111;
            color: #aaa;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:hover {
            background: #202020;
        }

        /* BUTTONS & BADGES */
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            transition: 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #168cff;
            color: white;
        }

        .btn-primary:hover {
            opacity: 0.85;
        }

        .btn-danger {
            background: #ff3b30;
            color: white;
        }

        .btn-danger:hover {
            opacity: 0.85;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-live {
            background: rgba(22, 140, 255, 0.2);
            color: #168cff;
            border: 1px solid #168cff;
        }

        .badge-active {
            background: rgba(0, 255, 136, 0.15);
            color: #00ff88;
        }

        .badge-admin {
            background: rgba(255, 159, 10, 0.15);
            color: #ff9f0a;
        }

        /* INNER TABS FOR MEDIA MANAGEMENT */
        .tab-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab-btn {
            background: #222;
            color: white;
            border: 1px solid #333;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
        }

        .tab-btn.active {
            background: #168cff;
            border-color: #168cff;
        }

        /* LOG TERMINAL */
        .log-console {
            background: #0a0a0a;
            border: 1px solid #222;
            border-radius: 8px;
            padding: 20px;
            font-family: monospace;
            font-size: 13px;
            max-height: 400px;
            overflow-y: auto;
            color: #00ff88;
        }

        .log-entry {
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .log-timestamp {
            color: #777;
        }

        .log-empty {
            color: #555;
            font-style: italic;
            text-align: center;
            padding: 40px 0;
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
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            TMK 4H
            <span>ADMIN PANEL</span>
        </div>

        <ul class="nav-menu">
            <li class="nav-item active" onclick="switchSection('stats', this)">
                📊 <span>Statistics</span>
            </li>
            <li class="nav-item" onclick="switchSection('users', this)">
                👥 <span>Users</span>
            </li>
            <li class="nav-item" onclick="switchSection('media', this)">
                🎬 <span>Movies & Live</span>
            </li>
            <li class="nav-item" onclick="switchSection('admins', this)">
                🛡️ <span>Admins</span>
            </li>
            <li class="nav-item" onclick="switchSection('logs', this)">
                📋 <span>Page Logs</span>
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
            <h1 id="page-title">Dashboard Overview</h1>

            <div class="header-actions">
                <!-- Logged In User Profile -->
                <div class="user-profile">
                    <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <span>{{ Auth::user()->name }}</span>
                </div>

                <!-- Laravel Breeze Logout Form -->
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log Out</button>
                </form>
            </div>
        </header>

        <!-- SECTION 1: STATISTICS -->
        <section id="stats" class="dashboard-section active">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <div class="value">24,512</div>
                    <div class="trend">+12% this week</div>
                </div>
                <div class="stat-card">
                    <h3>Active Streams</h3>
                    <div class="value">14</div>
                    <div class="trend" style="color: #168cff;">3 Live Now</div>
                </div>
                <div class="stat-card">
                    <h3>Movies Library</h3>
                    <div class="value">1,840</div>
                    <div class="trend">+45 added this month</div>
                </div>
                <div class="stat-card">
                    <h3>Bandwidth Usage</h3>
                    <div class="value">4.2 TB</div>
                    <div class="trend">Peak time active</div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h2>Live Viewing Traffic</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Channel / Stream</th>
                            <th>Category</th>
                            <th>Current Viewers</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Barcelona vs Real Madrid</td>
                            <td>Sport</td>
                            <td>12,450</td>
                            <td><span class="badge badge-live">LIVE</span></td>
                        </tr>
                        <tr>
                            <td>Action Movie 2026</td>
                            <td>Movies</td>
                            <td>3,210</td>
                            <td><span class="badge badge-active">Active</span></td>
                        </tr>
                        <tr>
                            <td>Champions League Replay</td>
                            <td>Sport</td>
                            <td>1,890</td>
                            <td><span class="badge badge-active">Active</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 2: USERS -->
        <section id="users" class="dashboard-section">
            <div class="table-container">
                <div class="table-header">
                    <h2>User Management</h2>
                    <button class="btn btn-primary">+ Add New User</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#USR-{{ Auth::user()->id }}</td>
                            <td>{{ Auth::user()->name }}</td>
                            <td>{{ Auth::user()->email }}</td>
                            <td><span class="badge badge-active">Active (You)</span></td>
                            <td><button class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>#USR-1092</td>
                            <td>Alex Johnson</td>
                            <td>alex@example.com</td>
                            <td><span class="badge badge-active">Active</span></td>
                            <td><button class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>#USR-1093</td>
                            <td>Sarah Parker</td>
                            <td>sarah@example.com</td>
                            <td><span class="badge badge-active">Active</span></td>
                            <td><button class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 3: MEDIA MANAGEMENT (MOVIES & LIVE STREAMS) -->
        <section id="media" class="dashboard-section">
            <div class="tab-buttons">
                <button class="tab-btn active" onclick="switchMediaTab('movies-tab', this)">Movies Management</button>
                <button class="tab-btn" onclick="switchMediaTab('streams-tab', this)">Live Streams Management</button>
            </div>

            <!-- MOVIES SUB-TAB -->
            <div id="movies-tab" class="media-content">
                <div class="table-container">
                    <div class="table-header">
                        <h2>Movies List</h2>
                        <button class="btn btn-primary">+ Add Movie</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Genre</th>
                                <th>Release Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Action Movie 2026</td>
                                <td>Action</td>
                                <td>2026</td>
                                <td><button class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
                            </tr>
                            <tr>
                                <td>Space Adventure</td>
                                <td>Sci-Fi</td>
                                <td>2025</td>
                                <td><button class="btn btn-danger" onclick="deleteRow(this)">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- STREAMS SUB-TAB -->
            <div id="streams-tab" class="media-content" style="display:none;">
                <div class="table-container">
                    <div class="table-header">
                        <h2>Live Streams List</h2>
                        <button class="btn btn-primary">+ Add Stream</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Stream Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Football Live</td>
                                <td>Sport</td>
                                <td><span class="badge badge-live">LIVE</span></td>
                                <td><button class="btn btn-danger" onclick="deleteRow(this)">End & Delete</button></td>
                            </tr>
                            <tr>
                                <td>Concert Live</td>
                                <td>Music</td>
                                <td><span class="badge badge-live">LIVE</span></td>
                                <td><button class="btn btn-danger" onclick="deleteRow(this)">End & Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- SECTION 4: ADMINS -->
        <section id="admins" class="dashboard-section">
            <div class="table-container">
                <div class="table-header">
                    <h2>Admin Accounts</h2>
                    <button class="btn btn-primary">+ Add Admin</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Admin Name</th>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Admin Principal</td>
                            <td><span class="badge badge-admin">Super Admin</span></td>
                            <td>Full Access</td>
                            <td><button class="btn btn-danger" onclick="deleteRow(this)">Remove</button></td>
                        </tr>
                        <tr>
                            <td>Sports Mod</td>
                            <td><span class="badge badge-admin">Moderator</span></td>
                            <td>Live Streams Only</td>
                            <td><button class="btn btn-danger" onclick="deleteRow(this)">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 5: PAGE LOGS -->
        <section id="logs" class="dashboard-section">
            <div class="table-container" style="padding: 20px;">
                <div class="table-header" style="padding: 0 0 20px 0; border-bottom: none;">
                    <h2>System & Page Logs</h2>
                    <button class="btn btn-danger" onclick="clearLogs()">🔥 Delete All Logs</button>
                </div>

                <div class="log-console" id="logConsole">
                    <div class="log-entry"><span class="log-timestamp">[{{ date('Y-m-d H:i:s') }}]</span> SYSTEM: Admin panel initialized for {{ Auth::user()->name }}.</div>
                    <div class="log-entry"><span class="log-timestamp">[{{ date('Y-m-d H:i:s') }}]</span> USER: {{ Auth::user()->email }} authenticated successfully.</div>
                    <div class="log-entry"><span class="log-timestamp">[2026-07-30 18:48:22]</span> STREAM: Live match "Barcelona vs Real Madrid" started successfully.</div>
                    <div class="log-entry"><span class="log-timestamp">[2026-07-30 18:49:00]</span> MEDIA: Movie "Action Movie 2026" requested 410 times.</div>
                </div>
            </div>
        </section>

    </main>

    <script>
        // SECTION SWITCHING
        function switchSection(sectionId, element) {
            document.querySelectorAll('.dashboard-section').forEach(section => {
                section.classList.remove('active');
            });

            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });

            document.getElementById(sectionId).classList.add('active');
            element.classList.add('active');

            const titles = {
                'stats': 'Dashboard Overview',
                'users': 'User Management',
                'media': 'Movies & Live Stream Management',
                'admins': 'Admin Privilege Control',
                'logs': 'Page System Logs'
            };
            document.getElementById('page-title').innerText = titles[sectionId];
        }

        // MEDIA SUB-TABS
        function switchMediaTab(tabId, element) {
            document.querySelectorAll('.media-content').forEach(content => {
                content.style.display = 'none';
            });
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            document.getElementById(tabId).style.display = 'block';
            element.classList.add('active');
        }

        // DELETE ROW
        function deleteRow(button) {
            if (confirm('Are you sure you want to delete this item?')) {
                const row = button.closest('tr');
                row.remove();
            }
        }

        // CLEAR LOGS
        function clearLogs() {
            if (confirm('Are you sure you want to PERMANENTLY delete all page logs?')) {
                const consoleBox = document.getElementById('logConsole');
                consoleBox.innerHTML = '<div class="log-empty">Logs cleared by Admin. No log records remaining.</div>';
            }
        }
    </script>
</body>

</html>