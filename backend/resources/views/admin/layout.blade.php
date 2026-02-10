<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Prevent caching -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
</head>
<body class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white h-screen fixed top-0 left-0 flex flex-col">
        <div class="p-4 text-xl font-bold border-b border-gray-700">Admin Panel</div>
        <nav class="flex flex-col p-4 space-y-2 flex-grow">
            <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('admin.students.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Students</a>
            <a href="{{ route('admin.courses.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Courses</a>
            <a href="{{ route('admin.skills.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Skills</a>
        </nav>

        <!-- Logout Button -->
        <div class="p-4 border-t border-gray-700">
            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 ml-64 overflow-auto">
        @yield('content')

        <!-- Pagination Section -->
        <div class="mt-6 flex justify-center">
            @yield('pagination')
        </div>
    </main>

    <!-- Disable Back After Logout -->
    <script>
        (function () {
            // Always block back button
            window.history.pushState(null, "", window.location.href);
            window.onpopstate = function () {
                window.history.pushState(null, "", window.location.href);
                window.location.replace("{{ route('login') }}");
            };

            // Extra protection: After logout, clear history
            document.getElementById("logoutForm")?.addEventListener("submit", function () {
                setTimeout(() => {
                    window.location.replace("{{ route('login') }}");
                }, 100);
            });
        })();
    </script>
</body>
</html>
