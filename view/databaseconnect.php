<?php
// تأسيس اتصال بقاعدة البيانات
$servername = "sql304.infinityfree.com";
$username = "if0_34543480";
$password = "CeaYargmkASN5R";
$dbname = "if0_34543480_mazenbs";
	

$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من أن الاتصال تم بنجاح
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
?>
