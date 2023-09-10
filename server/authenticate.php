<?php

require_once('connection.php');

if(!empty($_POST['login']) && !empty($_POST['password'])){
    $query = "SELECT * FROM users WHERE login = (?)";
    $get_user = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($get_user, "s", $_POST['login']);
    mysqli_stmt_execute($get_user);
    $user = mysqli_stmt_get_result($get_user)->fetch_assoc();
    if($user !== null && password_verify($_POST['password'], $user['password'])) {
        unset($user['password']);
        unset($user['id']);
        $_SESSION['user'] = $user;
        $response = [
            'status' => 'success',
            'user' => $user,
        ];
        http_response_code(200);
        echo json_encode($response);
        die();
    }
    else {
        http_response_code(404);
        $response = [
            'status' => 'error',
            'message' => 'User with such login and/or password not found',
        ];
        echo json_encode($response);
        die();
    }
}
http_response_code(400);
$response = [
    'status' => 'error',
    'message' => 'Login or password provided was empty',
];
echo json_encode($response);
