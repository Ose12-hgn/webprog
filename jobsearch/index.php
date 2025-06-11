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
                <a href="#" class="flex flex-col items-center text-amber-500 font-medium">
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
                <a href="company.php" class="flex flex-col items-center hover:text-amber-600">
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
                <a href="#" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full bg-white text-amber-600 border-r-[3px] border-amber-700">
                        <img src="img/navbar/homeBlack.svg" alt="Home" class="w-5 h-5 mb-1" />
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
                <a href="company.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-orange-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/companyWhite.svg" alt="Company" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
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

        <!-- Header Page -->
        <div class="text-center">
            <img src="img/ployeeOrange.png" class="h-20 w-auto mx-auto mb-2" alt="Logo" />
            <p class="text-sm text-gray-600 font-medium">– To Start with A Simple One –</p>
            <div class="h-[4px] w-full bg-amber-500 rounded-full mx-auto mt-2 mb-4"></div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_240px] gap-6">

            <!-- Side Profile -->
            <aside class="order-1 lg:order-2 bg-white border border-gray-200 rounded-xl shadow-sm p-4 lg:sticky top-6 h-fit lg:transform lg:translate-x-6">
                <div class="flex flex-col items-center text-center">
                    <img src="<?= htmlspecialchars($user['profile_picture_link_user'] ?? 'img/default_pp.png') ?>" alt="profile" class="w-16 h-16 rounded-full mb-3 object-cover" />
                    <h2 class="font-semibold text-lg">
                        <?= htmlspecialchars($user['name_user']) ?>
                    </h2>
                    <p class="text-gray-500 text-sm mb-2">
                        <?= htmlspecialchars($user['field_name']) ?>
                    </p>
                    <p class="text-gray-700 text-sm mb-1 text-center break-words">
                        <?= htmlspecialchars($user['username_user']) ?>
                    </p>
                    <p class="text-gray-700 text-sm mb-4">
                        <?= htmlspecialchars($user['location_user']) ?>
                    </p>
                    <a href="profile.php" class="block w-full bg-amber-500 text-white py-2 rounded hover:bg-amber-600 transition duration-300 ease-in-out text-sm">Edit Profile</a>
                </div>
            </aside>

            <!-- Main Feeds -->
            <div class="order-2 lg:order-1 space-y-6">

                <!-- Header Content -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <p class="text-amber-500 font-medium text-lg lg:text-xl px-6 py-1 leading-tight">
                        Welcome to Ployee
                    </p>


                    <!-- See User's Apply -->
                    <button class="bg-amber-500 text-white text-base font-medium px-6 py-2 rounded-lg shadow-md hover:bg-amber-600 transition duration-300 ease-in-out">
                        Your Apply
                    </button>
                </div>

                <!-- Form Post -->
                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-4">
                    <div class="flex items-start space-x-4">
                        <img src="https://ui-avatars.com/api/?name=You" alt="avatar" class="w-10 h-10 rounded-full" />
                        <div class="flex-1">
                            <textarea placeholder="What's on your mind?" class="w-full p-2 border border-gray-300 rounded text-sm resize-none"></textarea>
                            <div class="flex justify-between items-center mt-2">
                                <label class="text-sm text-blue-600 cursor-pointer hover:underline">
                                    📷 Add Photo
                                    <input type="file" class="hidden" />
                                </label>
                                <button class="bg-blue-600 text-white px-4 py-1 rounded text-sm hover:bg-blue-700">Post</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Show Posts -->

                <!-- Post 1 -->
                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-4">
                    <div class="flex items-start space-x-4">
                        <img src="https://ui-avatars.com/api/?name=John+Doe" alt="avatar" class="w-10 h-10 rounded-full" />
                        <div class="flex-1">
                            <h4 class="font-semibold">John Doe</h4>
                            <p class="text-sm text-gray-500">Product Manager • 2h</p>
                            <p class="mt-2 text-sm text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                        </div>
                    </div>
                </div>

                <!-- Post 2 -->
                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-4">
                    <div class="flex items-start space-x-4">
                        <img src="https://ui-avatars.com/api/?name=Katie+Kaus" alt="avatar" class="w-10 h-10 rounded-full" />
                        <div class="flex-1">
                            <h4 class="font-semibold">Katie Kaus</h4>
                            <p class="text-sm text-gray-500">Head Coach at Nike • 1hr</p>
                            <p class="mt-2 text-sm">Obsessed with the games on LinkedIn...</p>
                        </div>
                    </div>
                </div>

                <!-- Post 3 -->
                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-4">
                    <div class="flex items-start space-x-4">
                        <img src="https://ui-avatars.com/api/?name=John+Doe" alt="avatar" class="w-10 h-10 rounded-full" />
                        <div class="flex-1">
                            <h4 class="font-semibold">John Doe</h4>
                            <p class="text-sm text-gray-500">Product Manager • 2h</p>
                            <p class="mt-2 text-sm text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                        </div>
                    </div>
                </div>

                <!-- Post 4 -->
                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-4">
                    <div class="flex items-start space-x-4">
                        <img src="https://ui-avatars.com/api/?name=Katie+Kaus" alt="avatar" class="w-10 h-10 rounded-full" />
                        <div class="flex-1">
                            <h4 class="font-semibold">Katie Kaus</h4>
                            <p class="text-sm text-gray-500">Head Coach at Nike • 1hr</p>
                            <p class="mt-2 text-sm">Obsessed with the games on LinkedIn...</p>
                        </div>
                    </div>
                </div>

                <!-- Post 5 -->
                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm space-y-4">
                    <div class="flex items-start space-x-4">
                        <img src="https://ui-avatars.com/api/?name=John+Doe" alt="avatar" class="w-10 h-10 rounded-full" />
                        <div class="flex-1">
                            <h4 class="font-semibold">John Doe</h4>
                            <p class="text-sm text-gray-500">Product Manager • 2h</p>
                            <p class="mt-2 text-sm text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                        </div>
                    </div>
                </div>

            </div>

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