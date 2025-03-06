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
$user=$_SESSION['user_id']=8;


    $sql = "SELECT * FROM orders WHERE id = $user ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1 class="header">Order History</h1>
    <table class="table1">
    <tr>
        <th>Order ID</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Date</th>
        <th class="click" >image</th>
    </tr>
    
    <?php
    if (count($result) > 0) {
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['total_price'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td><form action='show_ordered_products.php' method='post'>
                      <input type='hidden' name='order_id' value='" . $row['id'] . "'>
                      <button type='submit'>Click Here</button>
                  </form></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No orders found</td></tr>";
    }
    ?>
</table>
<div class="watermark-container"></div>
<footer>
        <p>&copy; 2025 Flower Shop. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn = null; 
?>