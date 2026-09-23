<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CEO Dashboard | Admin Control</title>
    <style>
        :root {
            --bg-body: #f4f6f9;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: var(--bg-body); color: var(--text-dark); display: flex; min-height: 100vh; overflow: hidden; }

        /* Sidebar */
        aside { width: 250px; background: var(--sidebar-bg); color: #fff; display: flex; flex-direction: column; flex-shrink: 0; }
        aside .brand { padding: 20px; font-size: 1.4rem; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.1); text-transform: uppercase; letter-spacing: 1px; color: #38bdf8; }
        aside nav { flex: 1; padding: 20px 0; }
        aside nav a { display: block; padding: 12px 20px; color: #cbd5e1; text-decoration: none; font-weight: 500; transition: 0.2s; cursor: pointer; }
        aside nav a:hover, aside nav a.active { background: var(--sidebar-hover); color: #fff; border-left: 4px solid var(--primary); }

        /* Main Area */
        main { flex: 1; display: flex; flex-direction: column; overflow-y: auto; }
        header { background: #fff; padding: 15px 30px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        header h2 { font-size: 1.25rem; color: var(--text-dark); }

        .container { padding: 30px; max-width: 1200px; margin: 0 auto; width: 100%; }

        /* Section Visibility Toggle */
        .content-section { display: none; animation: fadeIn 0.3s ease-in-out; }
        .content-section.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Alerts */
        .alert { padding: 12px 18px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--card-bg); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .stat-card span { font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; }
        .stat-card h3 { font-size: 1.8rem; margin-top: 5px; color: var(--text-dark); }

        /* Cards & Tables */
        .card { background: var(--card-bg); border-radius: 8px; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card-header { padding: 18px 24px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .card-header h3 { font-size: 1.1rem; }
        .card-body { padding: 24px; overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem; }
        th { background: #f8fafc; padding: 12px 16px; color: var(--text-muted); font-weight: 600; border-bottom: 1px solid var(--border-color); }
        td { padding: 14px 16px; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }

        /* Badges & Buttons */
        .badge { display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        .badge-cat { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

        .btn { padding: 8px 14px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 500; transition: 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-hover); }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: var(--danger-hover); }
        .btn-outline { background: transparent; border: 1px solid var(--border-color); color: var(--text-dark); }
        .btn-outline:hover { background: #f8fafc; }

        /* Form Inputs */
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 0.88rem; font-weight: 500; }
        .form-control { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem; }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }

        /* Modal */
        .modal-overlay { display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(15, 23, 42, 0.6); align-items: center; justify-content: center; z-index: 1000; }
        .modal-overlay.active { display: flex; }
        .modal-box { background: #fff; width: 100%; max-width: 480px; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
        .modal-box .modal-header { padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .modal-box .modal-body { padding: 20px; max-height: 70vh; overflow-y: auto; }
        .modal-box .modal-footer { padding: 12px 20px; background: #f8fafc; border-top: 1px solid var(--border-color); text-align: right; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside>
        <div class="brand">CEO Console</div>
        <nav>
            <a class="nav-link active" data-target="section-users">Names Control</a>
            <a class="nav-link" data-target="section-links">API Directory</a>
            <a class="nav-link" data-target="section-add-link">Create Link</a>
            <a href="/home" style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 15px;">Home Page</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main>
        <header>
            <h2 id="page-title">Names Control</h2>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline">Logout</button>
            </form>
        </header>

        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <!-- Global Stats (Always visible) -->
            <div class="stats-grid">
                <div class="stat-card">
                    <span>Total Registered Names</span>
                    <h3>{{ count($users ?? []) }}</h3>
                </div>
                <div class="stat-card">
                    <span>Active API Endpoints</span>
                    <h3>{{ count($apis ?? []) }}</h3>
                </div>
            </div>

            <!-- SECTION: NAMES -->
            <div class="content-section active" id="section-users">
                <div class="card">
                    <div class="card-header">
                        <h3>Registered Names</h3>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users ?? [] as $u)
                                    <tr>
                                        <td><strong>{{ $u->name }}</strong></td>
                                        <td><small style="color: var(--text-muted);">{{ $u->created_at ? $u->created_at->format('Y-m-d H:i') : '-' }}</small></td>
                                        <td><small style="color: var(--text-muted);">{{ $u->updated_at ? $u->updated_at->format('Y-m-d H:i') : '-' }}</small></td>
                                        <td style="text-align: right;">
                                            <button type="button" 
                                                    class="btn btn-outline btn-open-user-modal" 
                                                    data-id="{{ $u->id }}" 
                                                    data-name="{{ $u->name }}"
                                                    data-created="{{ $u->created_at }}"
                                                    data-updated="{{ $u->updated_at }}">
                                                Edit
                                            </button>
                                            <form action="/users/{{ $u->id }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete record {{ $u->name }}?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: var(--text-muted);">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SECTION: API DIRECTORY -->
            <div class="content-section" id="section-links">
                <div class="card">
                    <div class="card-header">
                        <h3>API Endpoints Directory</h3>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Endpoint URL</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($apis ?? [] as $item)
                                    <tr>
                                        <td><strong>{{ $item->name }}</strong></td>
                                        <td><a href="{{ $item->api }}" target="_blank" style="color: var(--primary);">{{ $item->api }}</a></td>
                                        <td><span class="badge badge-cat">{{ $item->category ?? 'General' }}</span></td>
                                        <td><small style="color: var(--text-muted);">{{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-' }}</small></td>
                                        <td><small style="color: var(--text-muted);">{{ $item->updated_at ? $item->updated_at->format('Y-m-d H:i') : '-' }}</small></td>
                                        <td style="text-align: right;">
                                            <button type="button" 
                                                    class="btn btn-outline btn-open-api-modal" 
                                                    data-id="{{ $item->id }}" 
                                                    data-name="{{ $item->name }}" 
                                                    data-api="{{ $item->api }}"
                                                    data-category="{{ $item->category ?? '' }}"
                                                    data-created="{{ $item->created_at }}"
                                                    data-updated="{{ $item->updated_at }}">
                                                Edit
                                            </button>
                                            <form action="/apis/{{ $item->id }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete API {{ $item->name }}?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: var(--text-muted);">No APIs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SECTION: ADD NEW LINK -->
            <div class="content-section" id="section-add-link">
                <div class="card">
                    <div class="card-header">
                        <h3>Add New API Endpoint</h3>
                    </div>
                    <div class="card-body">
                        <form action="/apis" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Link / API Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Football Scores API" required>
                            </div>
                            <div class="form-group">
                                <label>Endpoint URL</label>
                                <input type="text" name="api" class="form-control" placeholder="https://api.example.com/v1/data" required>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" name="category" class="form-control" placeholder="e.g. sport, movie, ceo">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Endpoint</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- UPDATE NAME MODAL -->
    <div class="modal-overlay" id="userModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Edit Name & Timestamps</h3>
            </div>
            <form id="userUpdateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="modalUserName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Created At</label>
                        <input type="datetime-local" name="created_at" id="modalUserCreatedAt" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Updated At</label>
                        <input type="datetime-local" name="updated_at" id="modalUserUpdatedAt" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-close-modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- UPDATE API MODAL -->
    <div class="modal-overlay" id="apiModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Edit API Endpoint & Timestamps</h3>
            </div>
            <form id="apiUpdateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="modalApiName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>URL Endpoint</label>
                        <input type="text" name="api" id="modalApiUrl" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="category" id="modalApiCategory" class="form-control" placeholder="sport, movie, etc.">
                    </div>
                    <div class="form-group">
                        <label>Created At</label>
                        <input type="datetime-local" name="created_at" id="modalApiCreatedAt" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Updated At</label>
                        <input type="datetime-local" name="updated_at" id="modalApiUpdatedAt" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-close-modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/ceo.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Restore active tab from localStorage on page load
            const savedTabId = localStorage.getItem('activeCeoTab');
            if (savedTabId) {
                const targetLink = document.querySelector(`.nav-link[data-target="${savedTabId}"]`);
                const targetSection = document.getElementById(savedTabId);

                if (targetLink && targetSection) {
                    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                    document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));

                    targetLink.classList.add('active');
                    targetSection.classList.add('active');
                    document.getElementById('page-title').innerText = targetLink.innerText;
                }
            }
        });

        // Tab switching logic with localStorage
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                
                document.getElementById('page-title').innerText = this.innerText;

                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });

                const targetId = this.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');

                // Save chosen tab to localStorage
                localStorage.setItem('activeCeoTab', targetId);
            });
        });

        // Modal toggling script for Names
        document.querySelectorAll('.btn-open-user-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('userUpdateForm').action = `/users/${btn.dataset.id}`;
                document.getElementById('modalUserName').value = btn.dataset.name;
                document.getElementById('modalUserCreatedAt').value = btn.dataset.created ? btn.dataset.created.replace(' ', 'T').slice(0, 16) : '';
                document.getElementById('modalUserUpdatedAt').value = btn.dataset.updated ? btn.dataset.updated.replace(' ', 'T').slice(0, 16) : '';
                document.getElementById('userModal').classList.add('active');
            });
        });

        // Modal toggling script for APIs
        document.querySelectorAll('.btn-open-api-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('apiUpdateForm').action = `/apis/${btn.dataset.id}`;
                document.getElementById('modalApiName').value = btn.dataset.name;
                document.getElementById('modalApiUrl').value = btn.dataset.api;
                document.getElementById('modalApiCategory').value = btn.dataset.category;
                document.getElementById('modalApiCreatedAt').value = btn.dataset.created ? btn.dataset.created.replace(' ', 'T').slice(0, 16) : '';
                document.getElementById('modalApiUpdatedAt').value = btn.dataset.updated ? btn.dataset.updated.replace(' ', 'T').slice(0, 16) : '';
                document.getElementById('apiModal').classList.add('active');
            });
        });

        document.querySelectorAll('.btn-close-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active'));
            });
        });
    </script>
</body>
</html>