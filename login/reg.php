<?php
include_once 'connection.php';
header('Content-Type: application/json; charset=utf-8');

$tableName = $_POST['tableName'];
$numPhone  = $_POST['numPhone'];
$password  = md5($_POST['password']);


$checkUser = "SELECT * FROM Users WHERE NumPhone = '$numPhone'";
$checkQuery = mysqli_query($con, $checkUser);


if(mysqli_num_rows($checkQuery) > 0) {
    $response['error'] = "403";
    $response['message'] = "User already exists";

} else {
    $insertQuery = "INSERT INTO Users(Table_Name, NumPhone, Pass, Date_registration, Date_login, time_login)
                    VALUES('$tableName', '$numPhone', '$password', NOW(), NOW(), NOW())";
    $result = mysqli_query($con, $insertQuery);

 
    if($result) {
        $response['error'] = "200";
        $response['message'] = "Registration successful!";

    } else {
        $response['error'] = "400";
        $response['message'] = "Registration failed!";

    }
}

// إرجاع رد الخادم بصيغة JSON
echo json_encode($response);
?>