<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="max-w-lg w-full bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Change Password</h2>

        <!-- Success Message -->
        <div id="successMessage" class="hidden bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
            Password changed successfully! Redirecting to login...
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="hidden bg-red-100 text-red-700 p-3 rounded mb-4 text-center">
            Current password is incorrect!
        </div>

        <form id="changePasswordForm" class="space-y-5">
            <div class="relative">
                <input type="password" name="current_password" required
                    class="peer w-full border border-gray-300 rounded-xl p-4 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Current Password">
                <label class="absolute left-4 top-3 text-gray-500 text-sm transition-all
                    peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400
                    peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-blue-500 peer-focus:text-sm">
                    Current Password
                </label>
            </div>

            <div class="relative">
                <input type="password" name="new_password" required
                    class="peer w-full border border-gray-300 rounded-xl p-4 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="New Password">
                <label class="absolute left-4 top-3 text-gray-500 text-sm transition-all
                    peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400
                    peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-blue-500 peer-focus:text-sm">
                    New Password
                </label>
            </div>

            <div class="relative">
                <input type="password" name="new_password_confirmation" required
                    class="peer w-full border border-gray-300 rounded-xl p-4 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Confirm New Password">
                <label class="absolute left-4 top-3 text-gray-500 text-sm transition-all
                    peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400
                    peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-blue-500 peer-focus:text-sm">
                    Confirm New Password
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all duration-200">
                Change Password
            </button>
        </form>
    </div>

    <script>
        const loginUrl = "/login"; // Replace with your login route

        // Form submit logic
        document.getElementById('changePasswordForm').addEventListener('submit', function(e){
            e.preventDefault();
            const current = e.target.current_password.value;
            const newPass = e.target.new_password.value;
            const confirmPass = e.target.new_password_confirmation.value;

            if(newPass !== confirmPass){
                document.getElementById('errorMessage').textContent = "New passwords do not match!";
                document.getElementById('errorMessage').classList.remove('hidden');
                document.getElementById('successMessage').classList.add('hidden');
            } else {
                document.getElementById('successMessage').classList.remove('hidden');
                document.getElementById('errorMessage').classList.add('hidden');

                // Redirect to login after 2 seconds
                setTimeout(() => {
                    window.location.href = loginUrl;
                }, 2000);
            }
        });

        // Disable back button to prevent cached page
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.location.replace(loginUrl); // Redirect to login if user presses back
        };

        // Reload page to ensure no cached form data
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || window.performance && window.performance.navigation.type === 2) {
                window.location.replace(loginUrl);
            }
        });
    </script>

</body>
</html>
