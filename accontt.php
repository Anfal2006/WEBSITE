<?php
// عرض الأخطاء للتجربة
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$pass = "";
$db   = "base_client";  // ✅ حروف صغيرة

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("❌ خطأ في الاتصال: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// 2. استقبال البيانات
$no   = $_POST['nom'] ?? '';
$pno  = $_POST['prenom'] ?? '';
$age  = (int)($_POST['age'] ?? 0);
$wi   = $_POST['wilaya'] ?? '';
$tel  = (int)($_POST['telephone'] ?? 0);
$mail = $_POST['email'] ?? '';
$adr  = $_POST['adresse'] ?? '';
$mot  = $_POST['password'] ?? '';
$conf = $_POST['confirmPassword'] ?? '';
$sexe = $_POST['sexe'] ?? '';

// 3. تحقق من تطابق الباسورد
if ($mot !== $conf) {
    die("❌ كلمتا السر غير متطابقتين!");
}

// 4. إدخال البيانات
$stmt = $conn->prepare("INSERT INTO Client (No_Clt, Pno_Clt, Age_Clt, Wi_Clt, Tel_Clt, Mail_Clt, Adr_Clt, Mot_Clt, Sexe_Clt) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

// ✅ تصحيح الأنواع: Age_Clt و Tel_Clt من نوع INT
$stmt->bind_param("ssiisssss", $no, $pno, $age, $wi, $tel, $mail, $adr, $mot, $sexe);

// 5. التنفيذ
if ($stmt->execute()) {
    echo "<h2 style='color:green; text-align:center; margin-top:50px;'>✅ تم إنشاء الحساب بنجاح!</h2>";
    echo "<div style='text-align:center;'><a href='login.html'>👉 الانتقال لتسجيل الدخول</a></div>";
} else {
    echo "<h2 style='color:red;'>❌ خطأ: " . $stmt->error . "</h2>";
}

$stmt->close();
$conn->close();
?>