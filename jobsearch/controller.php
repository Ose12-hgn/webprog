<!-- MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B -->
<!-- FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B -->

<?php
function my_connectDB()
{
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'job_search';

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Failed to connect: " . $conn->connect_error);
    }

    return $conn;
}

function my_closeDB($conn)
{
    mysqli_close($conn);
}

// function to READ user + field
function getUserWithField($user_id) {
    $data = array();
    if ($user_id > 0) {
        $conn = my_connectDB();
        
        $query = $conn->prepare("
            SELECT u.*, f.field_name 
            FROM users u 
            LEFT JOIN fields f ON u.field_id = f.field_id 
            WHERE u.user_id = ?
        ");

        $query->bind_param("i", $user_id);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        }

        $query->close();
        my_closeDB($conn);
    }
    return $data;
}

// function to help UPDATE user
function handleFileUpload($file, $current_path) {
    if (!isset($file) || $file['error'] !== 0) {
        return $current_path;
    }

    $upload_dir = 'img/userProfilePicture/';
    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
        return false;
    }

    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = uniqid() . '_' . time() . '.' . $file_extension;
    $new_path = $upload_dir . $file_name;

    return move_uploaded_file($file['tmp_name'], $new_path) ? $new_path : false;
}

// function to UPDATE user
function updateUserProfile($user_id, $username, $email, $password, $name, $profile_picture, $bio, $field_id, $education_id) {
    $conn = my_connectDB();

    // Validate input
    if (!$user_id || !$username || !$email || !$name) {
        return false;
    }

    // Password handling
    $password_sql = '';
    $params = [$username, $email, $name, $profile_picture, $bio, $field_id, $education_id, $user_id];
    $types = 'ssssssii';

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $password_sql = ", password_hash_user = ?";
        array_splice($params, 3, 0, $hashed_password);
        $types = substr_replace($types, 's', 3, 0);
    }

    $sql = "UPDATE users SET 
            username_user = ?, 
            email_user = ?, 
            name_user = ? 
            $password_sql,
            profile_picture_link_user = ?, 
            bio_user = ?, 
            field_id = ?, 
            education_id = ?
            WHERE user_id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param($types, ...$params);
    $success = $stmt->execute();
    
    $stmt->close();
    my_closeDB($conn);
    
    return $success;
}

// function to DELETE user
function deleteUser($id)
{
    $conn = my_connectDB();
    $sql_query = "DELETE FROM users WHERE user_id = $id";
    $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
    my_closeDB($conn);
    return $result;
}

// function to GET all fields
function getAllFields() {
    $conn = my_connectDB();
    $fields = mysqli_query($conn, "SELECT * FROM fields");
    $result = mysqli_fetch_all($fields, MYSQLI_ASSOC);
    my_closeDB($conn);
    return $result;
}

// function to GET all education levels  
function getAllEducationLevels() {
    $conn = my_connectDB();
    $education_levels = mysqli_query($conn, "SELECT * FROM education_levels");
    $result = mysqli_fetch_all($education_levels, MYSQLI_ASSOC);
    my_closeDB($conn);
    return $result;
}

// Handle profile picture upload
function handleCompanyFileUpload($file, $current_path = 'img/companyProfilePicture/default.png') {
    if (!isset($file) || $file['error'] !== 0) {
        return $current_path;
    }

    $upload_dir = 'img/companyProfilePicture/';
    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
        return false;
    }

    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = uniqid() . '_' . time() . '.' . $file_extension;
    $new_path = $upload_dir . $file_name;

    return move_uploaded_file($file['tmp_name'], $new_path) ? $new_path : false;
}

// function to CREATE company
function createCompany($username, $password, $name, $bio, $profile_picture_path = null, $admin_user_id) {
    $conn = my_connectDB();

    $bio = $bio ?: "No bio set";
    $profile_picture_path = $profile_picture_path ?: 'img/companyProfilePicture/default.png';

    // Check if username is taken
    $check = $conn->prepare("SELECT company_id FROM companies WHERE username_company = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check_result = $check->get_result();
    if ($check_result->num_rows > 0) {
        $check->close();
        my_closeDB($conn);
        return "Username already taken";
    }
    $check->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO companies (username_company, password_hash_company, name_company, bio_company, profile_picture_link_company, admin_user_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssssi", $username, $hashed_password, $name, $bio, $profile_picture_path, $admin_user_id);

    $success = $stmt->execute();
    $stmt->close();
    my_closeDB($conn);

    return $success ? true : "Failed to create company";
}


// function to READ company by ID // LOGIN
function loginCompany($username, $password, $admin_user_id) {
    $conn = my_connectDB();

    // Cek apakah username perusahaan ada
    $stmt = $conn->prepare("SELECT * FROM companies WHERE username_company = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $company = $result->fetch_assoc();
    $stmt->close();
    my_closeDB($conn);

    if (!$company) {
        return "Username perusahaan tidak ditemukan.";
    }

    // Cek password
    if (!password_verify($password, $company['password_hash_company'])) {
        return "Password salah.";
    }

    // Cek apakah admin_user_id cocok
    if ($company['admin_user_id'] != $admin_user_id) {
        return "Akses ditolak. Anda bukan admin dari perusahaan ini.";
    }

    // Semua validasi lolos
    return $company;
}

// function to CREATE job posting
function createJobPosting($company_id, $title, $description, $location, $salary, $status) {
    $conn = my_connectDB();

    $stmt = $conn->prepare("INSERT INTO job_postings (
        company_id,
        title_job_posting,
        description_job_posting,
        location_job_posting,
        salary_range_job_posting,
        status_job_posting,
        date_posted_job_posting
    ) VALUES (?, ?, ?, ?, ?, ?, NOW())");

    if (!$stmt) return "Prepare failed: " . $conn->error;

    $stmt->bind_param("isssss", $company_id, $title, $description, $location, $salary, $status);

    if ($stmt->execute()) {
        return true;
    } else {
        return "Error: " . $stmt->error;
    }
}


// function to READ job postings by company ID
function getCompanyJobPostings($company_id) {
    $conn = my_connectDB();

    $stmt = $conn->prepare("SELECT * FROM job_postings WHERE company_id = ? ORDER BY date_posted_job_posting DESC");
    if (!$stmt) {
        return [];
    }

    $stmt->bind_param("i", $company_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $jobs = [];
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }

    return $jobs;
}

// function to READ applications by company ID
function getApplicationsByCompany($company_id) {
    $conn = my_connectDB();

    $query = "
        SELECT 
            a.application_id,
            a.status_application,
            a.date_applied,
            u.name_user,
            u.username_user,
            u.profile_picture_link_user,
            jp.title_job_posting,
            jp.job_posting_id
        FROM applications a
        JOIN job_postings jp ON a.job_posting_id = jp.job_posting_id
        JOIN users u ON a.user_id = u.user_id
        WHERE jp.company_id = ?
        ORDER BY a.date_applied DESC
    ";

    $stmt = $conn->prepare($query);
    if (!$stmt) return [];

    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $applications = [];
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }

    return $applications;
}

// function to UPDATE application status
function updateApplicationStatus($application_id, $new_status) {
    $conn = my_connectDB();

    $stmt = $conn->prepare("UPDATE applications SET status_application = ? WHERE application_id = ?");
    if (!$stmt) return false;

    $stmt->bind_param("si", $new_status, $application_id);
    return $stmt->execute();
}

// function to READ all job postings with company details
function getAllJobPostingsWithCompany() {
    $conn = my_connectDB();
    
    $query = "SELECT jp.*, c.name_company, c.profile_picture_link_company 
              FROM job_postings jp 
              JOIN companies c ON jp.company_id = c.company_id 
              ORDER BY jp.date_posted_job_posting DESC";
              
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        throw new Exception("Failed to fetch job postings");
    }
    
    $jobs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    my_closeDB($conn);
    return $jobs;
}

// function to CREATE an application for a job posting
function applyForJob($userId, $jobPostingId) {
    $conn = my_connectDB();
    
    // Check if already applied
    $checkQuery = "SELECT * FROM applications WHERE user_id = ? AND job_posting_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $userId, $jobPostingId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        my_closeDB($conn);
        return false; // Already applied
    }
    
    // Insert new application
    $status = "Not Yet";
    $dateApplied = date('Y-m-d H:i:s');
    
    $query = "INSERT INTO applications (user_id, job_posting_id, status_application, date_applied) 
              VALUES (?, ?, ?, ?)";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $userId, $jobPostingId, $status, $dateApplied);
    $success = $stmt->execute();
    
    my_closeDB($conn);
    return $success;
}

// function to UPDATE job postings
function updateJobStatus($job_id, $status) {
    $conn = my_connectDB();
    
    $stmt = $conn->prepare("UPDATE job_postings SET status_job_posting = ? WHERE job_posting_id = ?");
    if (!$stmt) {
        return false;
    }
    
    $stmt->bind_param("si", $status, $job_id);
    $success = $stmt->execute();
    
    my_closeDB($conn);
    return $success;
}

// function to READ all companies
function getAllCompanies() {
    $conn = my_connectDB();
    
    $query = "SELECT 
        company_id,
        name_company,
        bio_company as description_company,
        profile_picture_link_company 
    FROM companies";
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        error_log("Query failed: " . mysqli_error($conn));
        my_closeDB($conn);
        return [];
    }
    
    $companies = mysqli_fetch_all($result, MYSQLI_ASSOC);
    my_closeDB($conn);
    
    return $companies;
}
?>