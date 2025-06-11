<!-- MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B -->
<!-- FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B -->

<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: auth.php");
    exit();
}

include 'controller.php';

// READ user + field
$userId = $_SESSION['user_id'];
$user = getUserWithField($userId);

// Placeholder untuk data perusahaan, nantinya bisa diambil dari database
$companies = [
    ['name' => 'Tech Solutions Inc.', 'description' => 'Inovasi teknologi untuk masa depan.', 'logo' => 'img/company/logo1.png'],
    ['name' => 'Creative Minds Agency', 'description' => 'Agensi kreatif dengan ide-ide brilian.', 'logo' => 'img/company/logo2.png'],
    ['name' => 'GreenLeaf Corp.', 'description' => 'Berkomitmen pada solusi ramah lingkungan.', 'logo' => 'img/company/logo3.png'],
    ['name' => 'Nexus Innovations', 'description' => 'Menghubungkan ide dengan realita.', 'logo' => 'img/company/logo4.png'],
    ['name' => 'Quantum Dynamics', 'description' => 'Pionir dalam riset dan pengembangan.', 'logo' => 'img/company/logo5.png'],
    ['name' => 'Apex Group', 'description' => 'Mencapai puncak kesuksesan bersama.', 'logo' => 'img/company/logo6.png'],
];

?>


<!DOCTYPE html>
<html class="scroll-smooth">

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

<body class="bg-gray-50 text-black font-jost">
    <!-- ALL NAV HERE -->
    <nav>
        <!-- Mobile Top Navbar - sm, md -->
        <nav id="mobile-navbar" class="flex lg:hidden justify-between items-center bg-amber-500 text-white px-4 py-3 fixed top-0 w-full z-50 shadow-md">

            <!-- Logo -->
            <a href="#">
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
                <a href="index.php" class="flex flex-col items-center hover:text-amber-600">
                    <img src="img/navbar/homeBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Home</span>
                </a>
                <a href="people.php" class="flex flex-col items-center hover:text-amber-600">
                    <img src="img/navbar/peopleBlack.svg" class="w-5 h-5 mb-1" />
                    <span>People</span>
                </a>
                <a href="jobs.php" class="flex flex-col items-center hover:text-amber-600">
                    <img src="img/navbar/jobBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Jobs</span>
                </a>
                <a href="#" class="flex flex-col items-center text-amber-500 font-medium">
                    <img src="img/navbar/companyBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Company</span>
                </a>
                <a href="profile.php" class="flex flex-col items-center hover:text-amber-600">
                    <img src="img/navbar/profileBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Profile</span>
                </a>
                <button id="logout-button-mobile" class="flex flex-col items-center hover:text-amber-600">
                    <img src="img/navbar/logoutBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Logout</span>
                </button>

            </div>

        </div>

        <!-- Desktop Sidebar - lg -->
        <nav class="hidden lg:flex fixed top-0 left-0 h-full w-20 bg-amber-500 text-white z-50 flex-col items-center py-6 space-y-2">
            <!-- Logo -->
            <a href="#" class="mb-6">
                <img src="img/ployeeWhite.png" class="h-10 hover:invert transition duration-500 ease-in-out" alt="Logo" />
            </a>

            <!-- Navigation -->
            <div class="flex flex-col items-center space-y-1 w-full">
                <a href="index.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-orange-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/homeWhite.svg" alt="Home" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                        <span class="text-[12px]">Home</span>
                    </div>
                </a>
                <a href="people.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-orange-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/peopleWhite.svg" alt="People" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                        <span class="text-[12px]">People</span>
                    </div>
                </a>
                <a href="jobs.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-orange-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/jobWhite.svg" alt="Jobs" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                        <span class="text-[12px]">Jobs</span>
                    </div>
                </a>
                <a href="#" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full bg-white text-amber-600 border-r-[3px] border-amber-700">
                        <img src="img/navbar/companyBlack.svg" alt="Company" class="w-5 h-5 mb-1" />
                        <span class="text-[12px]">Company</span>
                    </div>
                </a>
                <a href="profile.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-orange-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/profileWhite.svg" alt="Profile" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                        <span class="text-[12px]">Profile</span>
                    </div>
                </a>
            </div>

            <!-- Spacer -->
            <div class="flex-grow"></div>

            <!-- Logout -->
            <button id="logout-button" class="group w-full flex justify-center mb-4">
                <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-orange-300 transition duration-300 ease-in-out">
                    <img src="img/navbar/logoutWhite.svg" alt="Logout" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                    <span class="text-[12px]">Logout</span>
                </div>
            </button>

        </nav>
    </nav>

    <!-- Logout Confirmation Modal -->
    <div id="logout-box" class="fixed inset-0 z-[999] hidden bg-black bg-opacity-40 flex items-center justify-center px-4">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-sm text-center sm:max-w-xs sm:rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Confirm Logout</h2>
            <p class="text-sm text-gray-600 mb-6">Are you sure you want to logout?</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button id="cancel-logout" class="px-4 py-2 text-sm text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-md">
                    Cancel
                </button>
                <a href="auth.php?logout=true" id="confirm-logout" class="px-4 py-2 text-sm bg-red-500 hover:bg-red-600 text-white rounded-md">
                    Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="min-h-screen pl-4 pr-4 sm:pl-8 sm:pr-8 lg:pl-24 pt-[80px] lg:pt-8 pb-16 space-y-6 max-w-7xl mx-auto">

        <!-- Header Content -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">
                Company
            </h1>
            <div class="flex items-center w-full md:w-auto gap-4">
                <div class="relative flex-grow w-full md:w-64">
                    <input type="text" placeholder="Search for company..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
                <button class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-full shadow-md transition duration-300">
                    Create Company
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($companies as $company): ?>
                <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center text-center transition transform hover:-translate-y-1 hover:shadow-xl">
                    <img src="<?= htmlspecialchars($company['logo']) ?>" alt="<?= htmlspecialchars($company['name']) ?>" class="w-20 h-20 rounded-full mb-4 object-contain border-2 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($company['name']) ?></h3>
                    <p class="text-gray-500 text-sm mt-2 flex-grow"><?= htmlspecialchars($company['description']) ?></p>
                    <a href="#" class="mt-6 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-full transition duration-300">
                        View Details
                    </a>
                </div>
            <?php endforeach; ?>
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

    <!-- DEBUG DATA USER
        <pre><//?php print_r($user); ?></pre>
    -->
</body>

</html>