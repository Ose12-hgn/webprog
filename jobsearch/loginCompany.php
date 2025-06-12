<!-- MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B -->
<!-- FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B -->

<?php
session_start();
include 'controller.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $admin_user_id = $_SESSION['user_id'];

    $company = loginCompany($username, $password, $admin_user_id);

    if (is_array($company)) {
        $_SESSION['company_id'] = $company['company_id'];
        $_SESSION['company_name'] = $company['name_company'];
        header("Location: indexCompany.php");
        exit();
    } else {
        $message = $company; // ini pesan error dari fungsi
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Company</title>
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
    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-blue-700 mb-4">Login as Company</h2>

        <?php if (!empty($message)): ?>
            <div class="bg-red-100 text-red-600 p-2 rounded-md text-sm mb-2 text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Company Username" required class="w-full px-4 py-2 border rounded-md">
            <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded-md">
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-700 transition">
                Login
            </button>
        </form>
    </div>
</body>

</html>
