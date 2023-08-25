<?php
// استدعاء ملف الاتصال بقاعدة البيانات
require_once 'databaseconnect.php';

// استدعاء دالة استرداد جميع المستخدمين من ملف qure.php
require_once 'qure.php';

// إضافة المستخدم الجديد إذا تم إرسال البيانات عن طريق النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tableName = $_POST["tableName"];
    $numPhone = $_POST["numPhone"];
    $password = $_POST["password"];
    $Diall = $_POST["reguser"];

    // إضافة المستخدم الجديد إلى قاعدة البيانات
    // إعادة توجيه المستخدم إلى الصفحة الرئيسية
    header("Location: show.php");
    exit();
}
if (isset($_POST['edit_user'])) {
    $id = $_GET['id'];
    $tableName = $_POST['tableName'];
    $numPhone = $_POST['numPhone'];
    $password = $_POST['password'];
    // تحديث بيانات المستخدم
     $update_user($id, $tableName, $numPhone, $password);
    header("Location: show.php");
    exit();
}

// استرداد جميع المستخدمين
$users = get_users();

// عرض النموذج لإضافة مستخدم جديد
?>
<form action="../login/reg.php" method="post">
<div style="direction: rtl;">
    <!-- محتوى الصندوق النصي -->

	<label for="tableName">اسم الجدول:</label>
    <select id="tableName" name="tableName">
    <option value="SGL_REC">جدول السجل العقاري</option>
    <option value="MASAHA_REC">جدول المساحة</option>
    <option value="ARADE_REC"> جدول الاراضي</option>
    <option value="QANON_REC"> جدول الشؤن القانونية</option>
    <option value="MDER_REC"> جدول مكتب المديرالعام</option>
    <option value="THSEL_REC"> جدول التحصيل</option>
    <option value="GMHOR_REC"> جدول خدمات الجمهور</option>
  
</select>
	
	<label for="numPhone"> رقم الهاتف او اسم المستخدم:</label>
	<input type="text" id="numPhone" name="numPhone">
	
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
		<th>اســـم الادارة</th>
		<th>رقم الهاتف/او اسم المستخدم</th>
		<th> كلمة السر</th>
		<th>تاريخ التسجيل</th>
		<th>تاريخ الدخول</th>
		<th>وقت الدخول</th>
		<th>حذف</th>

	</tr>
	<?php foreach ($users as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['Table_Name']; ?></td>
			<td><?php echo $user['NumPhone']; ?></td>
			<td><?php echo $user['Pass']; ?></td>
			<td><?php echo $user['Date_registration']; ?></td>
			<td><?php echo $user['Date_login']; ?></td>
			<td><?php echo $user['time_login']; ?></td>

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
