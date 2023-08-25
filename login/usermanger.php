<?php
// استدعاء ملف الاتصال بقاعدة البيانات
require_once 'connection.php';

// استدعاء دالة استرداد جميع المستخدمين من ملف qure.php
require_once 'qure.php';

// إضافة المستخدم الجديد إذا تم إرسال البيانات عن طريق النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // التحقق من وجود الحقول المطلوبة
    if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // إضافة المستخدم الجديد إلى قاعدة البيانات
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // رسالة نجاح إضافة المستخدم
            $success_message = "تم إضافة المستخدم بنجاح.";
        } else {
            // رسالة فشل إضافة المستخدم
            $error_message = "حدث خطأ أثناء إضافة المستخدم.";
        }
    } else {
        // رسالة خطأ عند عدم تعبئة جميع الحقول المطلوبة
        $error_message = "يرجى تعبئة جميع الحقول المطلوبة.";
    }
}

// حذف المستخدم إذا تم إرسال البيانات عن طريق النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user"])) {
    $id = $_POST["user_id"];

    // حذف المستخدم من قاعدة البيانات
    $sql = "DELETE FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // رسالة نجاح حذف المستخدم
        $success_message = "تم حذف المستخدم بنجاح.";
    } else {
        // رسالة فشل حذف المستخدم
        $error_message = "حدث خطأ أثناء حذف المستخدم.";
    }
}

// استرداد جميع المستخدمين
$users = get_users();

?>

<!-- نموذج إضافة مستخدم جديد -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="username">اسم المستخدم:</label>
    <input type="text" id="username" name="username">
    <br>
    <label for="email">البريد الإلكتروني:</label>
    <input type="email" id="email" name="email">
    <br>
    <label for="password">كلمة المرور:</label>
    <input type="password" id="password" name="password">
    <br>
    <button type="submit">إضافة مستخدم</button>
</form>

<?php
// عرض رسالة النجاح إذا تم إضافة المستخدم بنجاح
if (isset($success_message)) {
   ?>
    <div class="success-message"><?php echo $success_message; ?></div>
<?php
}

// عرض رسالة الخطأ إذا فشلت عملية إضافة المستخدم أو تعليمات المستخدم غير مكتملة
if (isset($error_message)) {
?>
    <div class="error-message"><?php echo $error_message; ?></div>
<?php
}

// عرض قائمة المستخدمين المستردة من قاعدة البيانات
if (!empty($users)) {
?>
    <table>
        <thead>
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>كلمة المرور</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['password']; ?></td>
                    <td>
                        <!-- نموذج حذف المستخدم -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" name="delete_user">حذف</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
} else {
    // رسالة عدم وجود مستخدمين
    echo "لا يوجد مستخدمين.";
}
?> 

وكما ذكرت سابقًا، يمكن تحسين المظهر باستخدام CSS وتغيير الأسلوب حسب احتياجاتك.