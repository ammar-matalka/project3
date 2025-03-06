<?php
session_start(); 

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
    $order_id = $_POST['order_id'];

    $sql = "SELECT oi.product_id, oi.quantity, oi.price AS item_price, p.name, p.image
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['order_id' => $order_id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ordered Product Images</title>
    <link rel="stylesheet" href="./css.css">
</head>
<body>
    <h1>Ordered Product Images</h1>
    <div class="product-gallery">
        <?php
        if (count($result) > 0) {
            foreach ($result as $row) {
                echo "<div class='product'>";
                echo "<img alt='Product Image' src='" . $row['image'] . "' style='width:200px; height:200px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;'>";
                echo "<p>" . $row['name'] . "</p>";
                echo "<p>Quantity: " . $row['quantity'] . "</p>";
                echo "<p>Price: $" . $row['item_price'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>
    <footer>
        <p>&copy; 2025 Flower Shop. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn = null; 
?>