<?php

require_once('connection.php');

if(!isset($_SESSION['user'])){
    http_response_code(401);
    $response = [
        'status' => 'error',
        'message' => 'Unauthorized',
    ];
    echo json_encode($response);
    die();
}
if(!$_SESSION['user']['isAdmin']){
    http_response_code(403);
    $response = [
        'status' => 'error',
        'message' => 'Forbidden',
    ];
    echo json_encode($response);
    die();
}
if(!empty($_POST['login'])){
    $query = "SELECT * FROM users WHERE login = (?)";
    $get_user = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($get_user, "s", $_POST['login']);
    mysqli_stmt_execute($get_user);
    $user = mysqli_stmt_get_result($get_user)->fetch_assoc();

    if($user === null){
        http_response_code(400);
        $response = [
            'status' => 'error',
            'message' => 'User with given login does not exist',
        ];
        echo json_encode($response);
        die();
    }
    unset($user['id']);
    unset($user['password']);
    unset($user['login']);
    http_response_code(200);
    $response = [
        'status' => 'success',
        'user' => $user,
    ];
    echo json_encode($response);
    die();
}
http_response_code(400);
$response = [
    'status' => 'error',
    'message' => 'Empty login provided',
];
echo json_encode($response);
die();