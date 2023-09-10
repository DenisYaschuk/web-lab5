<?php

require_once('connection.php');

if (!empty($_POST['login'])
    && !empty($_POST['password'])
) {
    $query = "SELECT * FROM users WHERE login = (?)";
    $get_user = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($get_user, "s", $_POST['login']);
    mysqli_stmt_execute($get_user);
    $user = mysqli_stmt_get_result($get_user)->fetch_assoc();

    if($user !== null){
        http_response_code(400);
        $response = [
            'status' => 'error',
            'message' => 'User with this login already exists',
        ];
        echo json_encode($response);
        die();
    }

    $query = "INSERT INTO users (`login`, `password`) VALUES (?,?)";
    $add_user = mysqli_prepare($conn, $query);

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($add_user, "ss", $_POST['login'], $password);
    mysqli_stmt_execute($add_user);
    http_response_code(200);
    $response = [
        'status' => 'success',
        'message' => 'User created',
    ];
    echo json_encode($response);
    die();
}
http_response_code(400);
$response = [
    'status' => 'error',
    'message' => 'Login or password provided was empty',
];
echo json_encode($response);

