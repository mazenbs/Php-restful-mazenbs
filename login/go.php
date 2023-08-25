<?php
header('Content-Type: application/json; charset=utf-8');
require 'connection.php';
require_once "../MobileRestHandler.php";
$mobileRestHandler = new MobileRestHandler();
$mobileRestHandler->getusers();





/*
$users = "SELECT section.* FROM section";         
//$users = "SELECT id, Table_Name, NumPhone, Date_registration, Date_login, time_login FROM Users";
$result = mysqli_query($con, $users);

if(mysqli_num_rows($result) > 0) {
    // وجد المستخدمين، إضافة المستخدمين إلى الرد
    while($row = mysqli_fetch_assoc($result)) {
        $response['users'][] = $row;
    }
    $response['error'] = "200";
} else {
    // لم يتم العثور على مستخدمين، إرجاع رسالة خطأ
    $response['error'] = "400";
    $response['users'][] = "";
}


// إرجاع رد الخادم بصيغة JSON
echo json_encode($response);
*/

?>