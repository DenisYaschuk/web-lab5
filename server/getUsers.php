<?php

require_once('connection.php');

if(!$_SESSION['user']){
    http_response_code(401);
    $response = [
        'status' => 'error',
        'message' => 'Unauthorized',
    ];
    echo json_encode($response);
    die();
}

if($_SESSION['user']['isAdmin']){
    $query = "SELECT * FROM users";
    $users = mysqli_query($conn, $query);

    $usersResponse = [];
    while ($user = mysqli_fetch_assoc($users)) {
        unset($user['id']);
        unset($user['password']);
        $usersResponse[] = $user;
    }
    http_response_code(200);
    $response = [
        'status' => 'success',
        'users' => $usersResponse,
    ];
    echo json_encode($response);
    die();
}
http_response_code(403);
$response = [
    'status' => 'error',
    'message' => 'Forbidden',
];
echo json_encode($response);
