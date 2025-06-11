<!-- MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B -->
<!-- FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B -->

<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: auth.php"); // Atau bisa redirect ke halaman lain kalau mau
    exit;
}

session_start();
include 'controller.php';

$conn = my_connectDB();
$error = "";

// Login Process
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM users WHERE username_user = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password_hash_user'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username_user'];
        header("Location: loading.php");
        exit;
    } else {
        $error = "Username or Password is incorrect!";
    }
}

// Register Process
if (isset($_POST['register'])) {
    $username = trim($_POST['username_user']);
    $password = $_POST['password_user'];
    $email = trim($_POST['email']);
    $name = trim($_POST['name_user']);
    $address = trim($_POST['address_user']) ?: 'No Address Set';
    $bio = trim($_POST['bio_user']) ?: 'No Bio Set';
    $field_id = !empty($_POST['field_id']) ? intval($_POST['field_id']) : null;
    $education_id = !empty($_POST['education_id']) ? intval($_POST['education_id']) : null;

    // Profile Picture Upload
    $profile_picture = "img/default_pp.png";
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'img/userProfilePicture/';
        $fileName = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
        $targetPath = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
            $profile_picture = $targetPath;
        }
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Username/email check
    $check = $conn->prepare("SELECT * FROM users WHERE username_user = ? OR email_user = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Username atau Email sudah digunakan.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username_user, password_hash_user, email_user, name_user, address_user, profile_picture_link_user, bio_user, field_id, education_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssii", $username, $password_hash, $email, $name, $address, $profile_picture, $bio, $field_id, $education_id);

        if ($stmt->execute()) {
            // Automatic login after register
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            header("Location: loading.php");
            exit;
        } else {
            $error = "Gagal mendaftarkan user: " . $conn->error;
        }
    }
}

// Dropdown data
$fields = mysqli_query($conn, "SELECT * FROM fields");
$education_levels = mysqli_query($conn, "SELECT * FROM education_levels");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Auth</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scriptAuth.js" defer></script>
    <style>
        body {
            font-family: "Jost", sans-serif;
        }
    </style>
</head>

<body class="bg-amber-50 min-h-screen flex flex-col items-center justify-center">
    <!-- Logo -->
    <img src="img/ployeeOrange.png" alt="Logo Besar" class="h-32 mb-6">

    <!-- Login/Register Box -->
    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-lg">
        <div class="flex justify-around mb-4">
            <button id="btn-login" class="text-amber-600 font-bold">Login</button>
            <button id="btn-register" class="text-gray-400 font-bold">Register</button>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-600 p-2 rounded-md text-sm mb-2"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Login Form -->
        <form id="login-form" method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 border rounded-md">
            <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded-md">
            <button type="submit" name="login" class="w-full bg-amber-500 text-white py-2 rounded-md hover:bg-amber-600 transition">Login</button>
        </form>

        <!-- Register Form -->
        <form id="register-form" method="POST" enctype="multipart/form-data" class="space-y-4 hidden">
            <input type="text" name="username_user" placeholder="Username" required class="w-full px-4 py-2 border rounded-md">
            <input type="password" name="password_user" placeholder="Password" required class="w-full px-4 py-2 border rounded-md">
            <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border rounded-md">
            <input type="text" name="name_user" placeholder="Full Name" required class="w-full px-4 py-2 border rounded-md">
            <input type="text" name="address_user" placeholder="Address (optional)" class="w-full px-4 py-2 border rounded-md">
            <input type="file" name="profile_picture" accept="image/*" class="w-full px-4 py-2 border rounded-md">
            <textarea name="bio_user" placeholder="Bio (optional)" class="w-full px-4 py-2 border rounded-md"></textarea>
            <select name="field_id" class="w-full px-4 py-2 border rounded-md">
                <option value="">Select Field</option>
                <?php while ($field = mysqli_fetch_assoc($fields)): ?>
                    <option value="<?= $field['field_id'] ?>"><?= htmlspecialchars($field['field_name']) ?></option>
                <?php endwhile; ?>
            </select>
            <select name="education_id" class="w-full px-4 py-2 border rounded-md">
                <option value="">Select Education Level</option>
                <?php while ($edu = mysqli_fetch_assoc($education_levels)): ?>
                    <option value="<?= $edu['education_id'] ?>"><?= htmlspecialchars($edu['education_name']) ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="register" class="w-full bg-amber-500 text-white py-2 rounded-md hover:bg-amber-600 transition">Register</button>
        </form>
    </div>
</body>

</html>