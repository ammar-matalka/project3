<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make a Purchase</title>
</head>
<body>
    <h1>Make a Purchase</h1>
    <form action="save_order.php" method="post">
        <input type="hidden" name="user_id" value="1"> 
        <input type="hidden" name="total_price" value="49.98"> 
        
        <input type="hidden" name="items[0][product_id]" value="1">
        <input type="hidden" name="items[0][quantity]" value="1">
        <input type="hidden" name="items[0][price]" value="29.99">
        
        <input type="hidden" name="items[1][product_id]" value="2">
        <input type="hidden" name="items[1][quantity]" value="1">
        <input type="hidden" name="items[1][price]" value="19.99"> order history
        
        <button type="submit">Purchase</button>
    </form>
</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flower_store";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $total_price = $_POST['total_price'];
    $status = 'completed'; 
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO orders (user_id, total_price, status, created_at) VALUES (:user_id, :total_price, :status, :created_at)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'total_price' => $total_price, 'status' => $status, 'created_at' => $created_at]);
    $order_id = $conn->lastInsertId();

    foreach ($_POST['items'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['order_id' => $order_id, 'product_id' => $product_id, 'quantity' => $quantity, 'price' => $price]);
    }

    header("Location: history.php");
    exit;
}
?>