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

// GET fields and edu levels
$fields = getAllFields();
$education_levels = getAllEducationLevels();

// Handle Profile Update
if (isset($_POST['update_profile'])) {
    // Handle file upload first
    $profile_picture_path = handleFileUpload(
        $_FILES['profile_picture'] ?? null,
        $user['profile_picture_link_user']
    );

    if ($profile_picture_path === false) {
        $error = "Failed to upload profile picture";
    } else {
        // Update profile after
        $success = updateUserProfile(
            $_SESSION['user_id'],
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
            $_POST['name'],
            $profile_picture_path,
            $_POST['bio'],
            $_POST['field_id'] ?: null,
            $_POST['education_id'] ?: null
        );

        if ($success) {
            header("Location: profile.php?updated=true");
            exit();
        } else {
            $error = "Gagal mengupdate profil";
        }
    }
}

// Handle Delete Account
if (isset($_POST['delete_account'])) {
    $success = deleteUser($_SESSION['user_id']);
    if ($success) {
        session_destroy();
        header("Location: auth.php");
        exit();
    } else {
        $error = "Failed to delete account";
    }
}
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
                <a href="company.php" class="flex flex-col items-center hover:text-amber-600">
                    <img src="img/navbar/companyBlack.svg" class="w-5 h-5 mb-1" />
                    <span>Company</span>
                </a>
                <a href="#" class="flex flex-col items-center text-amber-500 font-medium">
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
                <a href="company.php" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full hover:bg-orange-300 transition duration-300 ease-in-out">
                        <img src="img/navbar/companyWhite.svg" alt="Company" class="w-5 h-5 mb-1 group-hover:invert transition duration-300 ease-in-out" />
                        <span class="text-[12px]">Company</span>
                    </div>
                </a>
                <a href="#" class="group w-full flex justify-center">
                    <div class="flex flex-col items-center justify-center h-16 w-full bg-white text-amber-600 border-r-[3px] border-amber-700">
                        <img src="img/navbar/profileBlack.svg" alt="Profile" class="w-5 h-5 mb-1" />
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
        <!-- Update - Success/Failed -->
        <?php if (isset($_GET['updated'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline"> Profile updated </span>
            </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"> <?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <!-- Headline -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold mb-2">Profile</h1>
            <div class="h-[4px] w-24 bg-amber-500 rounded-full"></div>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Form wrapper -->
            <form method="POST" enctype="multipart/form-data" class="w-full flex flex-col lg:flex-row gap-12">
                <!-- Left Column: Profile Picture -->
                <div class="w-full lg:w-1/3">
                    <div class="flex flex-col items-center">
                        <img id="preview"
                            src="<?php echo $user['profile_picture_link_user'] ?? 'img/userProfilePicture/default.jpeg'; ?>"
                            alt="Profile Picture"
                            class="w-44 h-44 object-cover rounded-full border mb-4">
                        <label class="block font-medium mb-2">Change Profile Picture</label>
                        <input type="file" name="profile_picture" accept="image/*" class="text-sm w-full max-w-[176px]">
                    </div>
                </div>

                <!-- Right Column: Form Fields -->
                <div class="w-full lg:w-2/3 space-y-6">
                    <!-- Username -->
                    <div>
                        <label class="block font-medium mb-1">Username</label>
                        <input type="text" name="username"
                            value="<?php echo htmlspecialchars($user['username_user']); ?>"
                            placeholder="myusername" required
                            class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block font-medium mb-1">Email</label>
                        <input type="email" name="email"
                            value="<?php echo htmlspecialchars($user['email_user']); ?>"
                            placeholder="mymail@example.com" required
                            class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label class="block font-medium mb-1">Full Name</label>
                        <input type="text" name="name"
                            value="<?php echo htmlspecialchars($user['name_user']); ?>"
                            placeholder="My Name" required
                            class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block font-medium mb-1">New Password (not required)</label>
                        <input type="password" name="password"
                            placeholder="********"
                            class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    <!-- Bio -->
                    <div>
                        <label class="block font-medium mb-1">Bio</label>
                        <textarea name="bio" rows="3"
                            placeholder="I love using Ployee..."
                            class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200"><?php echo htmlspecialchars($user['bio_user']); ?></textarea>
                    </div>

                    <!-- Field -->
                    <div>
                        <label class="block font-medium mb-1">Field</label>
                        <select name="field_id"
                            class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
                            <option value="">-- Choose Field --</option>
                            <?php foreach ($fields as $field): ?>
                                <option value="<?= $field['field_id'] ?>"
                                    <?php echo ($user['field_id'] == $field['field_id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($field['field_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Education -->
                    <div>
                        <label class="block font-medium mb-1">Highest Education</label>
                        <select name="education_id"
                            class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
                            <option value="">-- Choose Highest Education --</option>
                            <?php foreach ($education_levels as $edu): ?>
                                <option value="<?= $edu['education_id'] ?>"
                                    <?php echo ($user['education_id'] == $edu['education_id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($edu['education_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Button Group -->
                    <div class="space-y-4 pt-4">
                        <!-- Save Button -->
                        <button type="submit" name="update_profile"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                            Save Changes
                        </button>

                        <!-- Delete Account -->
                        <div class="text-right">
                            <button type="button" id="delete-account-button"
                                class="text-red-600 hover:underline font-medium">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Delete Account Modal -->
        <div id="delete-account-box" class="fixed top-0 left-0 right-0 bottom-0 z-[999] hidden bg-black bg-opacity-40 flex items-center justify-center">
            <div class="bg-white rounded-xl shadow-lg p-6 w-[90%] max-w-md space-y-4 m-4">
                <h3 class="text-xl font-semibold text-red-600">Confirm Delete Account</h3>
                <p class="text-gray-700">Are you sure you want to delete your account? This action cannot be undone.</p>
                <div class="flex justify-end gap-3">
                    <button id="cancel-delete" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                    <form method="POST" class="inline">
                        <button type="submit" name="delete_account" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
                    </form>
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