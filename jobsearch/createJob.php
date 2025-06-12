<?php
session_start();
include 'controller.php';

if (!isset($_SESSION['company_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $salary = $_POST['salary'] ?? '';
    $status = $_POST['status'] ?? 'ACTIVE';
    $company_id = $_SESSION['company_id'];

    createJobPosting($company_id, $title, $description, $location, $salary, $status);

    header("Location: jobCompany.php");
    exit();
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

<body class="bg-sky-100 min-h-screen flex items-center justify-center p-6">
    <form method="POST" class="bg-white p-8 rounded-lg shadow-md w-full max-w-xl space-y-4">
        <h1 class="text-2xl font-bold text-blue-600 mb-4">Create New Job</h1>

        <input type="text" name="title" placeholder="Job Title" required class="w-full p-2 border rounded" />
        <textarea name="description" placeholder="Job Description" required class="w-full p-2 border rounded h-32"></textarea>
        <input type="text" name="location" placeholder="Location" required class="w-full p-2 border rounded" />
        <input type="text" name="salary" placeholder="Salary Range (e.g. 5jt - 10jt)" required class="w-full p-2 border rounded" />
        <select name="status" class="w-full p-2 border rounded">
            <option value="ACTIVE" selected>Active</option>
            <option value="INACTIVE">Inactive</option>
        </select>

        <div class="flex justify-between">
            <a href="jobCompany.php" class="text-blue-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Post Job</button>
        </div>
    </form>
</body>
</html>
