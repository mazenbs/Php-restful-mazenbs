<?php
require 'connection.php';

$userId = $_POST['userId'];

// حذف صف المستخدم المحدد باستخدام معرف المستخدم
$deleteUser = "DELETE FROM Users WHERE id = $userId";
$result = mysqli_query($con, $deleteUser);

if($result) {
    // تم الحذف بنجاح، إرجاع رسالة نجاح
    $response['error'] = "200";
    $response['message'] = "User deleted successfully!";
} else {
    // فشل الحذف، إرجاع رسالة خطأ
    $response['error'] = "400";
    $response['message'] = "Failed to delete user!";
}

// إرجاع رد الخادم بصيغة JSON
echo json_encode($response);
?>