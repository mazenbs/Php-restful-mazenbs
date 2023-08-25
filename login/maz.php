<!DOCTYPE html>
<?php
require 'connection.php';

// عرض المستخدمين
function showUsers() {
    global $con;
    $users = "SELECT id, Table_Name, NumPhone, Date_registration, Date_login, time_login FROM Users";
    $result = mysqli_query($con, $users);

    if(mysqli_num_rows($result) > 0) {
        // وجد المستخدمين، إضافة المستخدمين إلى الجدول
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['Table_Name'] . "</td>";
            echo "<td>" . $row['NumPhone'] . "</td>";
            echo "<td>" . $row['Date_registration'] . "</td>";
            echo "<td>" . $row['Date_login'] . "</td>";
            echo "<td>" . $row['time_login'] . "</td>";
            echo "<td><button onclick='deleteUser(" . $row['id'] . ")'>حذف</button></td>";
            echo "</tr>";
        }
    } else {
        // لم يتم العثور على مستخدمين، إرجاع رسالة خطأ
        echo "<tr>";
        echo "<td colspan='7'>لم يتم العثور على مستخدمين</td>";
        echo "</tr>";
    }
}

// إنشاء مستخدم جديد
function createUser($tableName, $numPhone, $password) {
    global $con;
    $password = md5($password);
    $insertQuery = "INSERT INTO Users(Table_Name, NumPhone, Pass, Date_registration, Date_login, time_login)
                    VALUES('$tableName', '$numPhone', '$password', NOW(), NOW(), NOW())";
    $result = mysqli_query($con, $insertQuery);

    if($result) {
        echo "<script>alert('تم إنشاء المستخدم بنجاح!');</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء إنشاء المستخدم!');</script>";
    }
}

// حذف مستخدم
function deleteUser($userId) {
    global $con;
    $deleteQuery = "DELETE FROM Users WHERE id = $userId";
    $result = mysqli_query($con, $deleteQuery);

    if($result) {
        echo "<script>alert('تم حذف المستخدم بنجاح!');</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء حذف المستخدم!');</script>";
    }
}

// تنفيذ الأوامر عند تقديم نموذج إنشاء مستخدم جديد
if(isset($_POST['create_user'])) {
    $tableName = $_POST['tableName'];
    $numPhone = $_POST['numPhone'];
    $password = $_POST['password'];
    createUser($tableName, $numPhone, $password);
}

// تنفيذ الأوامر عند تقديم نموذج حذف مستخدم
if(isset($_POST['delete_user'])) {
    $userId = $_POST['userId'];
    deleteUser($userId);
}
?>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
    <title>إدارة المستخدمين</title>
</head>
<body>
    <h1>إدارة المستخدمين</h1>
    
    <!-- عرض المستخدمين -->
    <h2>المستخدمين الموجودون:</h2>
    <table>
        <thead>
            <tr>
                <th>المعرّف</th>
                <th>اسم الجدول</th>
                <th>رقم الهاتف</th>
                <th>تاريخ التسجيل</th>
                <th>تاريخ آخر دخول</th>
                <th>وقت آخر دخول</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php showUsers(); ?>
        </tbody>
    </table>
    
    <!-- إنشاء مستخدم جديد -->
    <h2>إنشاء مستخدم جديد:</h2>
    <form method="post">
        <label for="tableName">اسم الجدول:</label>
        <input type="text" name="tableName" id="tableName" required><br>
        <label for="numPhone">رقم الهاتف:</label>
        <input type="text" name="numPhone" id="numPhone" required><br>
        <label for="password">كلمة المرور:</label>
        <input type="password" name="password" id="password" required><br>
        <button type="submit" name="create_user">إنشاء</button>
    </form>
    
    <!-- حذف مستخدم -->
    <h2>حذف مستخدم:</h2>
    <form method="post">
        <label for="userId">المعرّف:</label>
        <input type="number" name="userId" id="userId" required><br>
        <button type="submit" name="delete_user">حذف</button>
    </form>

    <script>
        // حذف مستخدم باستخدام AJAX
        function deleteUser(userId) {
            if(confirm("هل أنت متأكد من حذف هذا المستخدم؟")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        location.reload();
                    }
                }
                xhr.open("POST", "index.php");
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("delete_user=true&userId=" + userId);
            }
        }
    </script>
</body>
</html>