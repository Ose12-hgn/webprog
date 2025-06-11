<!-- MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B -->
<!-- FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B -->

<?php
function my_connectDB()
{
    $host = 'localhost';
    $user = 'root';
    $password = ''; // sesuaikan jika kamu pakai password MySQL
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

function getUserWithField($user_id)
{
    $data = array();

    if ($user_id > 0) {
        $conn = my_connectDB();

        $sql_query = "SELECT u.*, f.field_name 
                      FROM users u 
                      LEFT JOIN fields f ON u.field_id = f.field_id 
                      WHERE u.user_id = $user_id";

        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $data['id'] = $row["user_id"];
            $data['username'] = $row["username_user"];
            $data['name'] = $row["name_user"];
            $data['address'] = $row["address_user"];
            $data['email'] = $row["email_user"];
            $data['profile_picture'] = $row["profile_picture_link_user"];
            $data['bio'] = $row["bio_user"];
            $data['field'] = $row["field_name"];
        }

        my_closeDB($conn);
    }

    return $data;
}
