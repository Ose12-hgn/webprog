<!-- MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B -->
<!-- FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B -->

<?php
function my_connectDB()
{
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'dummy';

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

?>