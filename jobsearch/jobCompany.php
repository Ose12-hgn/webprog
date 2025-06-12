<?php
session_start();
include 'controller.php';

// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: company.php");
    exit();
}

// Check authentication
if (!isset($_SESSION['company_id'])) {
    header("Location: loginCompany.php");
    exit();
}
if (isset($_POST['deactivate_job'])) {
    $job_id = $_POST['job_id'];
    if (updateJobStatus($job_id, 'INACTIVE')) {
        // Refresh the page to show updated status
        header("Location: jobCompany.php");
        exit();
    }
}

$company_id = $_SESSION['company_id'];
$jobs = getCompanyJobPostings($company_id);
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

<body class="bg-sky-100 min-h-screen py-10 px-4">
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
                <a href="applicationsCompany.php" class="flex flex-col items-center hover:text-blue-600">
                    <img src="img/navbar/applyBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Applications</span>
                </a>
                <a href="#" class="flex flex-col items-center text-blue-500 font-medium">
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
                <a href="indexcompany.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-blue-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/homeWhite.svg" alt="Home" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                        <span class="text-[12px]">Home</span>
                    </div>
                </a>
                <a href="applicationsCompany.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-blue-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/applyWhite.svg" alt="Applications" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                        <span class="text-[12px]">Applications</span>
                    </div>
                </a>
                <a href="#" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full bg-white text-blue-600 border-r-[3px] border-blue-700">
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
                    <img src="img/navbar/logoutWhite.svg" alt="Logout" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                    <span class="text-[12px]">Logout</span>
                </div>
            </button>
        </nav>
    </nav>

    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-blue-700">Your Job Postings</h1>
            <a href="createJob.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                + Create New Job
            </a>
        </div>

        <!-- Job Listings -->
        <?php if (empty($jobs)) : ?>
            <div class="bg-white p-6 rounded-lg shadow text-gray-600">
                You haven't posted any jobs yet.
            </div>
        <?php else : ?>
            <div class="space-y-4">
                <?php foreach ($jobs as $job) : ?>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-blue-800"><?= htmlspecialchars($job['title_job_posting']) ?></h2>
                        <p class="text-gray-700 mt-1"><?= nl2br(htmlspecialchars($job['description_job_posting'])) ?></p>
                        <div class="text-sm text-gray-500 mt-2">
                            Location: <?= htmlspecialchars($job['location_job_posting']) ?> |
                            Salary: <?= htmlspecialchars($job['salary_range_job_posting']) ?> |
                            Status: <span class="<?= $job['status_job_posting'] === 'ACTIVE' ? 'text-green-600' : 'text-red-600' ?>">
                                <?= $job['status_job_posting'] ?>
                            </span> |
                            Posted on: <?= htmlspecialchars($job['date_posted_job_posting']) ?>
                        </div>
                        <div class="mt-3 flex gap-2">
                            <?php if ($job['status_job_posting'] === 'ACTIVE'): ?>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="job_id" value="<?= $job['job_posting_id'] ?>">
                                    <button type="submit" name="deactivate_job"
                                        class="text-red-600 hover:text-red-800 font-medium"
                                        onclick="return confirm('Are you sure you want to deactivate this job posting?')">
                                        Deactivate
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
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

    <!-- Logout Modal Script -->
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