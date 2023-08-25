<?php
require 'connection.php';
header('Content-Type: application/json; charset=utf-8');

$tableName = $_POST['tableName'];
$numPhone = $_POST['numPhone'];
$password = md5($_POST['password']);

function generateApiKey($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $apiKey = '';

    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $apiKey .= $characters[$index];
    }

    return $apiKey;
}

$checkUser = "SELECT *
              FROM Users JOIN section ON Users.Table_Name = section.id
              WHERE Users.Table_Name = '$tableName' AND Users.NumPhone = '$numPhone' AND Users.Pass = '$password'";

$result = mysqli_query($con, $checkUser);

if(mysqli_num_rows($result) > 0) {
    // جلب معلومات المستخدم وإضافتها إلى الرد
    $row = mysqli_fetch_assoc($result);
  
    $response['ROOT'] = $row['Table_Name'];
    $response['USNAM'] = $row['NumPhone'];
    $response['NAME'] = $row['section_name'];
    $response['USPASS'] = ($_POST['password']);
    $response['UM'] = 'http://192.168.1.104/api/RestController.php';
    $response['error'] = "200";
    $response['message'] = "success";
    
    // توليد مفتاح API
    $api_key = generateApiKey(32);
    
    // احفظ مفتاح API في قاعدة البيانات أو مكان آخر مناسب
    
    // إضافة مفتاح API إلى الرد
    $response['api_key'] = $api_key;

    // إضافة معرف المستخدم إلى الرد
    $response['id_key'] = $row['id'];

    // إضافة المعلومات الأخرى التي تحتاجها
 
    
    // تحديث حقلي التاريخ والوقت لتسجيل تاريخ ووقت آخر دخول للمستخدم
    $userId = $row['id'];
    $updateQuery = "UPDATE Users SET Date_login = NOW(), time_login = NOW(), api_key = '$api_key' WHERE id = $userId";
    mysqli_query($con, $updateQuery);
} else {
    $response['user'] = (object) [];
    $response['error'] = "400";
    $response['message'] = "Wrong credentials or user does not exist!";
}

// إرجاع رد الخادم بصيغة JSON
echo json_encode($response);
?>