<?php
// استدعاء ملف الاتصال بقاعدة البيانات
require_once 'databaseconnect.php';
require_once 'qure.php';

// التحقق من وجود معرف المستخدم في الرابط
if (isset($_POST['id'])) {
	$user_id = $_POST['id'];
	
	// حذف المستخدم المطلوب
	
	$result = delete_user($user_id);
	
	
	// إعادة تحميل الصفحة
	header("Location: show.php");
	exit();
}
?>
