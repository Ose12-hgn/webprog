<!-- MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B -->
<!-- FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B -->

<?php
session_start();
// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: company.php");
    exit();
}

// Check both company_id and user_id since company login requires both
if (!isset($_SESSION['company_id']) || !isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

require_once 'controller.php';
$conn = my_connectDB();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ployee</title>

    <!-- Preconnect to Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <!-- Link to Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- External CSS -->
    <link rel="stylesheet" href="style.css" />

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- External JS -->
    <script src="script.js"></script>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Jost', sans-serif;
        }

        main {
            margin-left: 5rem;
            /* Reserve space for fixed sidebar */
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- ALL NAV HERE -->
    <nav>
        <!-- Mobile Top Navbar - sm, md -->
        <nav id="mobile-navbar" class="flex lg:hidden justify-between items-center bg-blue-500 text-white px-4 py-3 fixed top-0 w-full z-50 shadow-md">
            <!-- Logo -->
            <a href="indexcompany.php">
                <img src="img/ployeeWhite.png" alt="Logo" class="h-8 ml-3" />
            </a>

            <!-- Hamburger Menu -->
            <button id="menu-toggle" class="focus:outline-none">
                <!-- Hamburger Icon -->
                <img id="menu-toggle-icon" src="img/hamburgerMenu.svg" class="h-6" />
                <!-- Close Icon -->
                <img id="menu-close-icon" src="img/close.svg" class="h-6 hidden" />
            </button>
        </nav>

        <!-- Dropdown Menu Mobile Top Navbar - sm, md -->
        <div id="mobile-dropdown" class="slide-down hidden lg:hidden fixed top-[55px] w-full bg-white text-black shadow-md z-40">
            <div class="flex justify-around text-sm border-t border-gray-300 py-3">
                <a href="#" class="flex flex-col items-center text-blue-500 font-medium">
                    <img src="img/navbar/homeBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Home</span>
                </a>
                <a href="applicationsCompany.php" class="flex flex-col items-center hover:text-blue-600">
                    <img src="img/navbar/applyBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Applications</span>
                </a>
                <a href="jobs.php" class="flex flex-col items-center hover:text-blue-600">
                    <img src="img/navbar/jobBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Jobs</span>
                </a>
                <button id="logout-button-mobile" class="flex flex-col items-center hover:text-blue-600">
                    <img src="img/navbar/logoutBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Logout</span>
                </button>
            </div>
        </div>

        <!-- Desktop Sidebar - lg -->
        <nav class="hidden lg:flex fixed top-0 left-0 h-full w-20 bg-blue-500 text-white z-50 flex-col items-center py-6 space-y-2">
            <!-- Logo -->
            <a href="indexcompany.php" class="mb-6">
                <img src="img/ployeeWhite.png" class="h-10 hover:invert transition duration-500 ease-in-out" alt="Logo" />
            </a>

            <!-- Navigation -->
            <div class="flex flex-col items-center space-y-1 w-full">
                <a href="#" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full bg-white text-blue-600 border-r-[3px] border-blue-700">
                        <img src="img/navbar/homeBlack.svg" alt="Home" class="w-5 h-5 mb-1" />
                        <span class="text-[12px]">Home</span>
                    </div>
                </a>
                <a href="applicationsCompany.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-blue-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/applyBlack.svg" alt="Applications" class="w-5 h-5 mb-1" />
                        <span class="text-[12px]">Applications</span>
                    </div>
                </a>
                <a href="jobCompany.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-blue-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/jobBlack.svg" alt="Jobs" class="w-5 h-5 mb-1" />
                        <span class="text-[12px]">Jobs</span>
                    </div>
                </a>
            </div>

            <!-- Spacer -->
            <div class="flex-grow"></div>

            <!-- Logout -->
            <button id="logout-button" class="group w-full flex justify-center mb-4">
                <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-blue-300 transition duration-300 ease-in-out">
                    <img src="img/navbar/logoutBlack.svg" alt="Logout" class="w-5 h-5 mb-1" />
                    <span class="text-[12px]">Logout</span>
                </div>
            </button>
        </nav>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen pl-4 pr-4 sm:pl-8 sm:pr-8 lg:pl-24 pt-[80px] lg:pt-8 pb-16 space-y-6 max-w-7xl mx-auto">

        <!-- Header Page -->
        <div class="text-center">
            <img src="img/ployeeOrange.png" class="h-20 w-auto mx-auto mb-2" alt="Logo" />
            <p class="text-sm text-gray-600 font-medium">– To Start with A Simple One –</p>
            <div class="h-[4px] w-full bg-amber-500 rounded-full mx-auto mt-2 mb-4"></div>
        </div>
        <div class="container mx-auto p-6">

            <!-- Home Section -->
            <section id="home" class="mb-10">
                <h2 class="text-3xl font-bold mb-4">Welcome to Your Company Dashboard</h2>
                <p class="text-gray-700">Manage your company profile, view job seekers, and post jobs.</p>
            </section>

            <!-- Job Posting Section -->
            <section id="jobposting" class="mb-10">
                <h2 class="text-2xl font-bold mb-4">Your Job Postings</h2>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-4">Manage your job postings here.</p>
                    <a href="jobCompany.php" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        + Create New Job
                    </a>
                </div>
            </section>


        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 px-8 py-6 text-black">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <img src="img/ployeeOrange.png" alt="Logo" class="h-6" />
            <div class="flex items-center gap-2 text-sm font-medium">
                <img src="img/copyright.png" alt="Copyright" class="w-4 h-4" />
                <span class="text-orange-500">2025 Ployee by MJ</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="mailto:ployee.id@gmail.com" target="_blank">
                    <img src="img/gmail.png" alt="Gmail" class="h-5" />
                </a>
                <a href="https://instagram.com" target="_blank">
                    <img src="img/instagram.png" alt="Instagram" class="h-6" />
                </a>
                <a href="https://www.linkedin.com" target="_blank">
                    <img src="img/linkedin.png" alt="LinkedIn" class="h-6" />
                </a>
                <a href="https://wa.me" class="ml-4 text-orange-500 font-semibold hover:underline" target="_blank">
                    Contact Us
                </a>
            </div>
        </div>
    </footer>

    <!-- Logout Confirmation Modal -->
    <div id="logout-modal" class="fixed inset-0 z-[999] hidden bg-black bg-opacity-40 flex items-center justify-center px-4">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-sm text-center sm:max-w-xs sm:rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Confirm Logout</h2>
            <p class="text-sm text-gray-600 mb-6">Are you sure you want to logout?</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button onclick="$('#logout-modal').addClass('hidden')"
                    class="px-4 py-2 text-sm text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-md">
                    Cancel
                </button>
                <a href="auth.php?logout=true"
                    class="px-4 py-2 text-sm bg-red-500 hover:bg-red-600 text-white rounded-md">
                    Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Add this script at the bottom -->
    <script>
        $(document).ready(function() {
            // Show modal
            $('#logout-button, #logout-button-mobile').on('click', function() {
                $('#logout-modal').removeClass('hidden');
            });

            // Close modal when clicking outside
            $('#logout-modal').on('click', function(e) {
                if (e.target.id === 'logout-modal') {
                    $(this).addClass('hidden');
                }
            });
        });
    </script>
</body>

</html>