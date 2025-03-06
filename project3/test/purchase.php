<?php
session_start(); // بدء الجلسة

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make a Purchase</title>
</head>
<body>
    <h1>Make a Purchase</h1>
    <form action="save_order.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"> <!-- معرف المستخدم -->
        <input type="hidden" name="total_price" value="49.98"> <!-- السعر الإجمالي -->
        
        <!-- عناصر الطلب -->
        <input type="hidden" name="items[0][product_id]" value="1">
        <input type="hidden" name="items[0][quantity]" value="1">
        <input type="hidden" name="items[0][price]" value="29.99">
        
        <input type="hidden" name="items[1][product_id]" value="2">
        <input type="hidden" name="items[1][quantity]" value="1">
        <input type="hidden" name="items[1][price]" value="19.99">
        
        <button type="submit">Purchase</button>
    </form>
</body>
</html>