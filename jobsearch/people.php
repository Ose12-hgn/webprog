<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: auth.php");
    exit();
}

include 'controller.php';
$conn = my_connectDB();

// Mengambil data user yang sedang login untuk ditampilkan di navigasi
$currentUserId = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT u.*, f.field_name
    FROM users u
    LEFT JOIN fields f ON u.field_id = f.field_id
    WHERE u.user_id = ?
");
$stmt->bind_param("i", $currentUserId);
$stmt->execute();
$result = $stmt->get_result();
$currentUser = $result->fetch_assoc();

// Placeholder untuk data semua pengguna, nantinya bisa diambil dari database
// Kita akan filter agar tidak menampilkan user yang sedang login
$allUsersStmt = $conn->prepare("
    SELECT u.name_user, u.profile_picture_link_user, f.field_name
    FROM users u
    LEFT JOIN fields f ON u.field_id = f.field_id
    WHERE u.user_id != ?
    LIMIT 18
");
$allUsersStmt->bind_param("i", $currentUserId);
$allUsersStmt->execute();
$people = $allUsersStmt->get_result()->fetch_all(MYSQLI_ASSOC);


$conn->close();

?>


<!DOCTYPE html>
<html class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>People - Ployee</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="style.css" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="script.js"></script>

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
    <nav>
        <nav id="mobile-navbar" class="flex lg:hidden justify-between items-center bg-amber-500 text-white px-4 py-3 fixed top-0 w-full z-50 shadow-md">
            <a href="index.php">
                <img src="img/ployeeWhite.png" alt="Logo" class="h-8 ml-3" />
            </a>
            <button id="menu-toggle" class="focus:outline-none">
                <img id="menu-toggle-icon" src="img/hamburgerMenu.svg" class="h-6" />
                <img id="menu-close-icon" src="img/close.svg" class="h-6 hidden" />
            </button>
        </nav>

        <div id="mobile-dropdown" class="slide-down hidden lg:hidden fixed top-[55px] w-full bg-white text-black shadow-md z-40">
            <div class="flex justify-around text-sm border-t border-gray-300 py-3">
                <a href="index.php" class="flex flex-col items-center hover:text-amber-600">
                    <img src="img/navbar/homeBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Home</span>
                </a>
                <a href="people.php" class="flex flex-col items-center text-amber-500 font-medium">
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

        <nav class="hidden lg:flex fixed top-0 left-0 h-full w-20 bg-amber-500 text-white z-50 flex-col items-center py-6 space-y-2">
            <a href="index.php" class="mb-6">
                <img src="img/ployeeWhite.png" class="h-10 hover:invert transition duration-500 ease-in-out" alt="Logo" />
            </a>
            <div class="flex flex-col items-center space-y-1 w-full">
                <a href="index.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-orange-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/homeWhite.svg" alt="Home" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                        <span class="text-[12px]">Home</span>
                    </div>
                </a>
                <a href="people.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full bg-white text-amber-600 border-r-[3px] border-amber-700">
                        <img src="img/navbar/peopleBlack.svg" alt="People" class="w-5 h-5 mb-1" />
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
            <div class="flex-grow"></div>
            <button id="logout-button" class="group w-full flex justify-center mb-4">
                <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-orange-300 transition duration-300 ease-in-out">
                    <img src="img/navbar/logoutWhite.svg" alt="Logout" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                    <span class="text-[12px]">Logout</span>
                </div>
            </button>
        </nav>
    </nav>

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

    <main class="min-h-screen pl-4 pr-4 sm:pl-8 sm:pr-8 lg:pl-24 pt-[80px] lg:pt-8 pb-16 space-y-6 max-w-7xl mx-auto">

        <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">
                People
            </h1>
            <div class="relative flex-grow w-full md:w-auto max-w-xs">
                <input type="text" placeholder="Search for people..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-amber-500">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            <?php foreach ($people as $person): ?>
                <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center text-center transition transform hover:-translate-y-1 hover:shadow-lg cursor-pointer">
                    <img src="<?= htmlspecialchars($person['profile_picture_link_user'] ?? 'img/default_pp.png') ?>" alt="<?= htmlspecialchars($person['name_user']) ?>" class="w-16 h-16 rounded-full mb-3 object-cover border-2 border-amber-200">
                    <h3 class="text-md font-semibold text-gray-800 leading-tight"><?= htmlspecialchars($person['name_user']) ?></h3>
                    <p class="text-gray-500 text-xs mt-1"><?= htmlspecialchars($person['field_name'] ?? 'No field') ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <footer class="bg-white border-t border-gray-200 px-8 py-6 text-black mt-auto">
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
</body>

</html>