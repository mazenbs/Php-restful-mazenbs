<?php
// استدعاء ملف الاتصال بقاعدة البيانات
require_once 'databaseconnect.php';

// إضافة بيانات المستخدم الجديد
function add_user($table_name, $num_phone, $pass, $date_registration, $date_login, $time_login) {
    global $conn;

    // إدخال البيانات في جدول المستخدمين
    $sql = "INSERT INTO Users (Table_Name, NumPhone, Pass, Date_registration, Date_login, time_login) VALUES ('$table_name', $num_phone, $pass, '$date_registration', '$date_login', '$time_login')";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// تعديل بيانات المستخدم
function edit_user($id, $table_name, $num_phone, $pass, $date_registration, $date_login, $time_login) {
    global $conn;

    // تحديث البيانات في جدول المستخدمين
    $sql = "UPDATE Users SET Table_Name='$table_name', NumPhone=$num_phone, Pass=$pass, Date_registration='$date_registration', Date_login='$date_login', time_login='$time_login' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// حذف بيانات المستخدم
function delete_user($id) {
    global $conn;

    // حذف البيانات من جدول المستخدمين
    $sql = "DELETE FROM Users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// استرداد جميع بيانات المستخدمين
function get_users() {
    global $conn;

    // الحصول على جميع البيانات من جدول المستخدمين
    $sql = "SELECT * FROM Users";
    $result = $conn->query($sql);

    // إنشاء مصفوفة لتخزين البيانات
    $users = array();

    if ($result->num_rows > 0) {
        // استرداد البيانات وإضافتها إلى المصفوفة
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}
?>