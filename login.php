<?php
session_start(); // ⚠️ أول سطر ضروري

// عرض الأخطاء للتجربة
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$pass = "";
$db   = "base_client";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("❌ خطأ في الاتصال: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");


// 2. استقبال البيانات من الفورم
$email = $_POST['email'] ?? '';
$mot_de_passe = $_POST['password'] ?? '';

// 3. البحث عن العميل في جدول Client
$stmt = $conn->prepare("SELECT Id_Clt, No_Clt, Pno_Clt, Mail_Clt, Mot_Clt FROM Client WHERE Mail_Clt = ? AND Mot_Clt = ?");
$stmt->bind_param("ss", $email, $mot_de_passe);
$stmt->execute();
$result = $stmt->get_result();

// 4. التحقق من النتيجة
if ($result->num_rows === 1) {
    // ✅ البيانات صحيحة: نبدأو سيشن ونخزنو المعلومات
    $row = $result->fetch_assoc();
    
    $_SESSION['Id_Clt']   = $row['Id_Clt'];   // ✅ مهم جداً للكموند
    $_SESSION['Pno_Clt']  = $row['Pno_Clt'];
    $_SESSION['No_Clt']   = $row['No_Clt'];
    $_SESSION['Mail_Clt'] = $row['Mail_Clt'];
    
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2 style='color:green;'>✅ مرحباً بكِ " . htmlspecialchars($row['Pno_Clt']) . "!</h2>";
    echo "<p>تم تسجيل الدخول بنجاح. يمكنك الآن طلب المنتجات.</p>";
    echo "<a href='commande.html' style='padding:10px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px;'>🛒 الذهاب للطلب</a> | ";
    echo "<a href='index.html' style='color:#007bff;'>الرئيسية</a>";
    echo "</div>";
} else {
    // ❌ البيانات غير صحيحة
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2 style='color:red;'>❌ البريد الإلكتروني أو كلمة المرور غير صحيحة!</h2>";
    echo "<a href='login.html' style='color:#007bff;'>⬅️ العودة لتسجيل الدخول</a>";
    echo "</div>";
}

// 5. إغلاق الاتصال
$stmt->close();
$conn->close();
?>