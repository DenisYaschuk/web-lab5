<?php

session_start();
try {
    $conn = mysqli_connect('localhost', 'root', '', 'some_users');
} catch (\Throwable $th) {
    echo "The connection was not established.";
    echo mysqli_error($conn);
    exit();
}
