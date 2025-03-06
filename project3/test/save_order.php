<?php
session_start(); // بدء الجلسة

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flower_store";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // تعيين وضع الخطأ إلى استثناءات
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // التحقق من وجود معرف المستخدم في الجلسة
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $total_price = $_POST['total_price'];
        $status = 'completed'; // حالة الطلب مكتمل
        $created_at = date('Y-m-d H:i:s');

        // إدخال الطلب في جدول orders
        $sql = "INSERT INTO orders (user_id, total_price, status, created_at) VALUES (:user_id, :total_price, :status, :created_at)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'total_price' => $total_price, 'status' => $status, 'created_at' => $created_at]);
        $order_id = $conn->lastInsertId();

        // إدخال عناصر الطلب في جدول order_items
        foreach ($_POST['items'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['order_id' => $order_id, 'product_id' => $product_id, 'quantity' => $quantity, 'price' => $price]);
        }

        // إعادة توجيه المستخدم إلى صفحة التاريخ
        header("Location: history.php");
        exit;
    } else {
        echo "User not logged in.";
        exit;
    }
}
?>