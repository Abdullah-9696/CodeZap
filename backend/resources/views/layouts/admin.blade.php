<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            color: black;
        }
        .sidebar {
            width: 220px;
            color: white;
            min-height: 100vh;
            background-color: #03030a;
            background-size: cover;
            background-position: center;
        }
        .sidebar a {
            color: white !important;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: rgba(0,0,0,0.5);
            border-radius: 4px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .topbar {
            background-color: white;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    @auth
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column">
            <h3 class="text-center py-3">Admin Panel</h3>
            <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="{{ route('admin.courses.index') }}"><i class="bi bi-journal-bookmark me-2"></i> Courses</a>
            <a href="{{ route('admin.skills.index') }}"><i class="bi bi-award me-2"></i> Skills</a>
            <a href="{{ route('admin.students.create') }}"><i class="bi bi-person-plus me-2"></i> Add Student</a>
            <a href="{{ route('admin.students.index') }}"><i class="bi bi-people me-2"></i> All Students</a>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="topbar">
                <span class="me-3">Hello, {{ Auth::user()->name }}</span>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" onclick="handleLogout(event)">Logout</button>
                </form>
            </div>

            <div class="mt-4">
                @yield('content')
            </div>
        </div>

        <!-- JavaScript to handle logout and prevent back navigation -->
        <script>
            function handleLogout(event) {
                event.preventDefault(); // Prevent default form submission
                const form = document.getElementById('logout-form');
                
                // Submit form via fetch to ensure logout
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => {
                    // Clear history and redirect to login page
                    window.history.replaceState(null, '', '{{ route('login') }}');
                    window.location.replace('{{ route('login') }}');
                }).catch(() => {
                    // In case of error, still redirect to login
                    window.history.replaceState(null, '', '{{ route('login') }}');
                    window.location.replace('{{ route('login') }}');
                });
            }

            // Prevent back navigation on admin pages
            (function() {
                window.history.pushState(null, '', window.location.href);
                window.onpopstate = function(event) {
                    window.history.pushState(null, '', '{{ route('login') }}');
                    window.location.replace('{{ route('login') }}');
                };
            })();
        </script>
    @endauth

    @guest
        <!-- Redirect to login page for unauthenticated users -->
        <script>
            window.location.replace('{{ route('login') }}');
        </script>
    @endguest
</body>
</html>