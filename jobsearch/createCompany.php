<!-- MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B -->
<!-- FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B -->

<?php
session_start();
include 'controller.php';

$message = "";

// Redirect to auth.php if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php?error=You must be logged in to create a company.");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $name = trim($_POST['name']);
    $bio = trim($_POST['bio']);
    $admin_user_id = $_SESSION['user_id'];

    // Handle file upload
    $profile_picture_path = handleCompanyFileUpload($_FILES['profile_picture']);

    // Create company
    $result = createCompany($username, $password, $name, $bio, $profile_picture_path, $admin_user_id);

    if ($result === true) {
        header("Location: loginCompany.php");
        exit();
    } else {
        $message = $result;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Company</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Jost', sans-serif;
        }
    </style>
</head>

<body class="bg-sky-100 min-h-screen flex flex-col items-center justify-center">
    <!-- Back Button -->
    <div class="absolute top-4 left-4 bg-white rounded-xl hover:bg-gray-300 transition duration-300 ease-in-out shadow-md p-2">
        <a href="company.php" class="text-blue-600 hover:text-blue-800 font-medium">
            Back
        </a>
    </div>


    <!-- Logo -->
    <img src="img/ployeeOrange.png" alt="Logo" class="h-32 mb-6">

    <!-- Form Box -->
    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-blue-700 mb-4">Register Company</h2>

        <?php if (!empty($message)): ?>
            <div class="bg-red-100 text-red-600 p-2 rounded-md text-sm mb-2 text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="username" placeholder="Company Username" required class="w-full px-4 py-2 border rounded-md">
            <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded-md">
            <input type="text" name="name" placeholder="Company Name" required class="w-full px-4 py-2 border rounded-md">
            <textarea name="bio" placeholder="Company Bio (optional)" class="w-full px-4 py-2 border rounded-md"></textarea>
            <input type="file" name="profile_picture" accept="image/*" class="w-full px-4 py-2 border rounded-md">
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-700 transition">
                Create Company
            </button>
        </form>
    </div>
</body>

</html>