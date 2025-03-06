<?php
session_start(); // بدء الجلسة

// التحقق من بيانات تسجيل الدخول (مثال بسيط)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['username'] == 'user' && $_POST['password'] == 'pass') {
        $_SESSION['user_id'] = 1; // تخزين معرف المستخدم في الجلسة
        header("Location: purchase.php"); // إعادة توجيه المستخدم إلى صفحة الشراء
        exit;
    } else {
        echo "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>