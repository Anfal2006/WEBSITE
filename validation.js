function Validation_login() {
    const email = document.getElementById("email").value.trim();
    const pass = document.getElementById("password").value.trim();

    if (email === "" || pass === "") {
        alert("خطأ: يرجى ملء حقل البريد الإلكتروني وكلمة المرور.");
        return true;
    }
    if (!email.includes("@") || !email.includes(".")) {
        alert("Format d'e-mail invalide.");
         return true;
    }
    if (pass.length < 6) {
        alert("Le mot de passe doit contenir au moins 6 caractères.");
          return true;
    }

    alert("✅ Connexion réussie ! Bienvenue.");
    window.location.href = "commande.html"; // توجيه بعد النجاح
     return true; // منع إعادة تحميل الصفحة الافتراضي
}

function Validation_infos() {
    const prenom = document.getElementById("prenom").value.trim();
    const nom = document.getElementById("nom").value.trim();
    const email = document.getElementById("email").value.trim();
    const adresse = document.getElementById("adresse").value.trim();
    const age = parseInt(document.getElementById("age").value);
    const tel = document.getElementById("telephone").value.trim();
    const pass = document.getElementById("password").value;
    const confPass = document.getElementById("confirmPassword").value;
    const wilaya = document.getElementById("wilaya").value;
    const sexeEl = document.querySelector('input[name="sexe"]:checked');
    const sexe = sexeEl ? sexeEl.value : "";

    if (!prenom || !nom || !email || !adresse) {
        alert("خطأ: يجب ملء حقول الاسم، اللقب، البريد الإلكتروني والعنوان.");
          return true;
    }
    if (isNaN(age) || age < 17 || age > 100) {
        alert("خطأ: العمر يجب أن يكون بين 17 و 100 سنة.");
          return true;
    }
    if (!/^\d{9,10}$/.test(tel)) {
        alert("خطأ: رقم الهاتف يجب أن يتكون من 9 أو 10 أرقام فقط.");
          return true;
    }
    if (!pass || !confPass) {
        alert("خطأ: يرجى إدخال كلمة المرور وتأكيدها.");
          return true;
    }
    if (pass.length < 8) {
        alert("خطأ: كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل.");
          return true;
    }
    if (pass !== confPass) {
        alert("خطأ: كلمتا المرور غير متطابقتين.");
         return true;
    }

    alert(`تم تأكيد التسجيل:\nالولاية: ${wilaya}\nالجنس: ${sexe}`);
    window.location.href = "login.html"; // توجيه لصفحة الدخول بعد التسجيل
      return true;
}

function Validation_order() {
    const couleur = document.getElementById("couleur").value;
    const quantite = document.getElementById("quantite").value.trim();

    if (couleur === "" || quantite === "") {
        alert("خطأ: يرجى اختيار اللون وإدخال الكمية.");
         return true;
    }
    alert(`تم تأكيد الطلب:\nاللون: ${couleur}\nالكمية: ${quantite}`);
    window.location.href = "index.html"; // العودة للصفحة الرئيسية أو صفحة شكر
      return true;
}