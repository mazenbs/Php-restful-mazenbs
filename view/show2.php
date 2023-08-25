<?php
// استدعاء ملف الاتصال بقاعدة البيانات
require_once 'databaseconnect.php';

// استدعاء دالة استرداد جميع المستخدمين من ملف qure.php
require_once 'qure.php';

// إضافة المستخدم الجديد إذا تم إرسال البيانات عن طريق النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $Diall = $_POST["reguser"];

    // إضافة المستخدم الجديد إلى قاعدة البيانات
    // إعادة توجيه المستخدم إلى الصفحة الرئيسية
    header("Location: users.php");
    exit();
}
if (isset($_POST['edit_user'])) {
    $id = $_GET['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // تحديث بيانات المستخدم
     $update_user($id, $username, $email, $password);
    header("Location: users.php");
    exit();
}

// استرداد جميع المستخدمين
$users = get_users();

// عرض النموذج لإضافة مستخدم جديد
?>
<form action="../login/login.php" method="post">
<div style="direction: rtl;">
    <!-- محتوى الصندوق النصي -->

	<label for="username"> اسم المستخدم:</label>
	<input type="text" id="username" name="username">
	
	<label for="email"> الايميل:</label>
	<input type="text" id="email" name="email">
	
	<label for="password"> كلمة السر:</label>
	<input type="password" id="password" name="password">
	
	<button type="submit">حفظ</button>
	</div>
</form>

<!-- عرض البيانات في جدول -->
<div style="direction: rtl;">
<table border='1'>
	<tr>
		<th>رقم id</th>
		<th>اسم المستخدم</th>
		<th>ايميل</th>
		<th> كلمة السر</th>
		<th>تعديل</th>
		<th>حذف</th>
	</tr>
	<?php foreach ($users as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['password']; ?></td>
			<td><a href='edit_user.php?id=<?php echo $user['id']; ?>'>تعديل</a></td>
			<td>
				<form action='delete_user.php' method='post'>
					<input type='hidden' name='id' value='<?php echo $user['id']; ?>'>
					<button type='submit' onclick='return confirm("هل أنت متأكد من رغبتك في حذف هذا المستخدم؟")'>حذف</button>
				</form>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
	</div>
