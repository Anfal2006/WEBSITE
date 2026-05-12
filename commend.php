<?php
session_start(); // ⚠️ لازم يكون في أول سطر بلا ما يسبقو أي مسافة أو echo

// 1. التحقق من أن العميل مسجل دخوله
if (!isset($_SESSION['Id_Clt'])) {
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2 style='color:red;'>⛔ يرجى تسجيل الدخول أولاً لطلب المنتج</h2>";
    echo "<a href='login.html' style='padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px;'>تسجيل الدخول</a>";
    echo "</div>";
    exit;
}

// 2. الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$pass = "";
$db   = "Base_Client";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("❌ خطأ في الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// 3. استقبال البيانات من الـ HTML + رقم العميل من السيشن
$id_client = $_SESSION['Id_Clt'];          // ✅ ID اللي تخزن وقت الـ login
$vendeur   = $_POST['Vendeur_prod'] ?? '';
$prix      = $_POST['Prix_prod'] ?? '';
$ref       = $_POST['Ref_prod'] ?? '';
$colr      = $_POST['Colr_prod'] ?? '';
$qant      = $_POST['Qant_prod'] ?? 0;

// 4. إدخال الطلب في جدول Commande_produit
$stmt = $conn->prepare("INSERT INTO Commande_produit (Id_client, Vendeur_prod, Prix_prod, Ref_prod, Colr_prod, Qant_prod) 
                        VALUES (?, ?, ?, ?, ?, ?)");

// تحديد الأنواع: i=INT, s=TEXT
$stmt->bind_param("issssi", $id_client, $vendeur, $prix, $ref, $colr, $qant);

// 5. تنفيذ الاستعلام والتحقق
if ($stmt->execute()) {
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2 style='color:green;'>✅ تم تسجيل طلبك بنجاح!</h2>";
    echo "<p><b>المرجع:</b> $ref | <b>اللون:</b> $colr | <b>الكمية:</b> $qant | <b>السعر:</b> $prix</p>";
    echo "<a href='commande_produit.html' style='color:#007bff;'>طلب منتج آخر</a> | ";
    echo "<a href='index.html' style='color:#007bff;'>العودة للرئيسية</a>";
    echo "</div>";
} else {
    echo "<h2 style='color:red;'>❌ فشل في حفظ الطلب: " . $stmt->error . "</h2>";
}

// 6. إغلاق الاتصال
$stmt->close();
$conn->close();
?>