<html><head>
<title>Group 5A Product System</title>
<style>
input[type=submit] {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
input[type=submit]:hover {
  background-color: #45a049;
}
.mainStyle {
    padding: 20px;
    align-items: center;
}
</style></head><body>
<?php

try {
    # Call to Maria database to get relevant tables
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    # Get order data
    $orderval = $_POST["orderselect"];
    $sql = "SELECT customer_id, status FROM Order_ WHERE order_id = '$orderval';";
    $rs = $pdo->query($sql);
    $rowsOrder = $rs->fetchAll(PDO::FETCH_ASSOC);
    $customer_id = $rowsOrder[0]['customer_id'];
    $order_status = $rowsOrder[0]['status'];

    # Get customer data
    $sql = "SELECT email FROM Customer WHERE customer_id = $customer_id";
    $rs = $pdo->query($sql);
    $rowsCustomer = $rs->fetchAll(PDO::FETCH_ASSOC);
    $customer_email = $rowsCustomer[0]['email'];

    echo "<div class=\"mainStyle\">";
    echo "<hr></hr>";
    echo "<h2>Order #$orderval</h2>";

    if ($order_status == 'Completed') {
        echo "<p>Error: order already completed.</p>";
    } else {
        # Update database
        $currentDateTime = date('Y-m-d H:i:s');
        $sql = "UPDATE Order_ SET status='Completed', filled_date='$currentDateTime' WHERE order_id=$orderval;";
        $rs = $pdo->query($sql);

        # Print feedback
        echo "<p>Order #$orderval has been marked as completed!</p>";
        echo "<p>A confirmation email has been sent to $customer_email.</p>";
    }

    # Return button
    echo "<form method=\"post\" action=\"WarehouseInterface.php\">";
    echo "<input type=\"submit\" class=\"buttonStyle\" name=\"button2\" value=\"Return\">";
    echo "</form>";

    echo "</br/>";
    echo "</div>";
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
</body>
</html>
