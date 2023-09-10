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

$query = "UPDATE users SET name = ?, cell = ?, country = ?, postcode = ?, isAdmin = ? where login = ?";
$updateUser = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($updateUser, "ssssis", $_POST['name'], $_POST['cell'], $_POST['country'], $_POST['postcode'], $_POST['isAdmin'], $_POST['login'], );
if(mysqli_stmt_execute($updateUser)){
    http_response_code(200);
    $response = [
        'status' => 'success',
        'message' => 'User updated',
    ];
    echo json_encode($response);
    die();
}
http_response_code(400);
$response = [
    'status' => 'error',
    'message' => 'Unexpected error occurred',
];
echo json_encode($response);



