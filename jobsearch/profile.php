<!-- MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B -->
<!-- FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B -->

<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: auth.php");
    exit();
}

include 'controller.php';
$conn = my_connectDB();

$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT u.*, f.field_name 
    FROM users u 
    LEFT JOIN fields f ON u.field_id = f.field_id 
    WHERE u.user_id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$conn->close();

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
<section class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-md">
  <h2 class="text-2xl font-semibold mb-6 text-center">Edit Profil</h2>

  <?php if (!empty($success_message)): ?>
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4"><?= $success_message ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="space-y-6">
    <!-- Username -->
    <div>
      <label class="block font-medium mb-1">Username</label>
      <input type="text" name="username" value="<?= htmlspecialchars($user['username_user']) ?>" required class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
    </div>

    <!-- Email -->
    <div>
      <label class="block font-medium mb-1">Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email_user']) ?>" required class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
    </div>

    <!-- Nama Lengkap -->
    <div>
      <label class="block font-medium mb-1">Nama Lengkap</label>
      <input type="text" name="name" value="<?= htmlspecialchars($user['name_user']) ?>" required class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
    </div>

    <!-- Ganti Password -->
    <div>
      <label class="block font-medium mb-1">Password Baru (kosongkan jika tidak ganti)</label>
      <input type="password" name="password" placeholder="********" class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
    </div>

    <!-- Bio -->
    <div>
      <label class="block font-medium mb-1">Bio</label>
      <textarea name="bio" rows="3" class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200"><?= htmlspecialchars($user['bio_user']) ?></textarea>
    </div>

    <!-- Field Dropdown -->
    <div>
      <label class="block font-medium mb-1">Bidang</label>
      <select name="field_id" class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
        <option value="">-- Pilih Bidang --</option>
        <?php foreach ($fields as $field): ?>
          <option value="<?= $field['id'] ?>" <?= ($field['id'] == $user['field_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($field['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Education Level Dropdown -->
    <div>
      <label class="block font-medium mb-1">Pendidikan</label>
      <select name="education_id" class="w-full border px-4 py-2 rounded-lg focus:ring focus:ring-blue-200">
        <option value="">-- Pilih Pendidikan --</option>
        <?php foreach ($education_levels as $education): ?>
          <option value="<?= $education['id'] ?>" <?= ($education['id'] == $user['education_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($education['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Foto Profil -->
    <div>
      <label class="block font-medium mb-1">Foto Profil</label>
      <div class="flex items-center gap-4">
        <img id="preview" src="<?= htmlspecialchars($user['profile_picture_link_user']) ?>" alt="Profile Picture" class="w-20 h-20 object-cover rounded-full border">
        <input type="file" name="profile_picture" accept="image/*" class="block mt-2">
      </div>
    </div>

    <!-- Submit -->
    <div class="pt-4">
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
        Simpan Perubahan
      </button>
    </div>
  </form>
</section>

<!-- Preview Foto Profil -->
<script>
  const input = document.querySelector('input[name="profile_picture"]');
  const preview = document.getElementById('preview');

  input?.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      preview.src = URL.createObjectURL(file);
    }
  });
</script>

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