<?php
session_start();
header('Content-Type: application/json');

include '../includes/db-connection.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (md5($password) === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            echo json_encode(['success' => true, 'redirect' => 'pages/admin/dashboard.php']);
            exit;
        } else {
            $response['message'] = 'Invalid email or password';
        }
    } else {
        $response['message'] = 'Invalid email or password';
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
exit;