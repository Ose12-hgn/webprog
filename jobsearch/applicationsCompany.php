<?php
session_start();
include 'controller.php';

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: company.php");
    exit();
}

if (!isset($_SESSION['company_id'])) {
    header("Location: loginCompany.php");
    exit();
}

$company_id = $_SESSION['company_id'];

// Handle accept/decline actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['application_id'])) {
    $action = $_POST['action'];
    $application_id = intval($_POST['application_id']);

    if (in_array($action, ['ACCEPTED', 'DECLINED'])) {
        updateApplicationStatus($application_id, $action);
    }
}

// Get applications
$applications = getApplicationsByCompany($company_id);
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

<body class="bg-gray-100 min-h-screen p-6 font-sans">
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
                <a href="indexcompany.php" class="flex flex-col items-center hover:text-blue-600">
                    <img src="img/navbar/homeBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Home</span>
                </a>
                <a href="#" class="flex flex-col items-center text-blue-500 font-medium">
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
                <a href="indexCompany.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-blue-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/homeBlack.svg" alt="Home" class="w-5 h-5 mb-1" />
                        <span class="text-[12px]">Home</span>
                    </div>
                </a>
                <a href="#" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full bg-white text-blue-600 border-r-[3px] border-blue-700">
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


    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Applications to Your Job Postings</h1>

        <?php if (empty($applications)) : ?>
            <div class="bg-white p-6 rounded shadow text-gray-600">No applications yet.</div>
        <?php else : ?>
            <div class="space-y-4">
                <?php foreach ($applications as $app) : ?>
                    <div class="bg-white p-5 rounded shadow-md flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-blue-700"><?= htmlspecialchars($app['name_user']) ?> (<?= htmlspecialchars($app['username_user']) ?>)</h2>
                            <p class="text-gray-700">Applied to: <strong><?= htmlspecialchars($app['title_job_posting']) ?></strong></p>
                            <p class="text-sm text-gray-500">Applied on: <?= htmlspecialchars($app['date_applied']) ?></p>
                            <p>Status: <span class="font-medium <?= $app['status_application'] === 'NOT YET' ? 'text-yellow-500' : ($app['status_application'] === 'ACCEPTED' ? 'text-green-600' : 'text-red-600') ?>">
                                    <?= $app['status_application'] ?>
                                </span></p>
                        </div>

                        <?php if ($app['status_application'] === 'NOT YET') : ?>
                            <form method="POST" class="flex gap-2">
                                <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                <button name="action" value="ACCEPTED" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept</button>
                                <button name="action" value="DECLINED" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Decline</button>
                            </form>
                        <?php else : ?>
                            <div class="text-sm text-gray-400 italic">Decision made</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logout-modal" class="fixed inset-0 z-[999] hidden bg-black bg-opacity-40 items-center justify-center px-4">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-sm text-center sm:max-w-xs sm:rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Confirm Logout</h2>
            <p class="text-sm text-gray-600 mb-6">Are you sure you want to logout?</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button onclick="$('#logout-modal').removeClass('flex').addClass('hidden')"
                    class="px-4 py-2 text-sm text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-md">
                    Cancel
                </button>
                <a href="?logout=true"
                    class="px-4 py-2 text-sm bg-red-500 hover:bg-red-600 text-white rounded-md">
                    Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Add this script -->
    <script>
        $(document).ready(function() {
            // Show modal
            $('#logout-button, #logout-button-mobile').on('click', function() {
                $('#logout-modal').removeClass('hidden').addClass('flex');
            });

            // Close modal when clicking outside
            $('#logout-modal').on('click', function(e) {
                if (e.target.id === 'logout-modal') {
                    $(this).removeClass('flex').addClass('hidden');
                }
            });
        });
    </script>
</body>

</html>
</body>

</html>