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
    $sql = "SELECT * FROM Order_ WHERE order_id=$orderval;";
    $rs = $pdo->query($sql);
    $rowsOrder = $rs->fetchAll(PDO::FETCH_ASSOC);
    $customer_id = $rowsOrder[0]["customer_id"];
    $weight = $rowsOrder[0]['weight_total'];

    # Get customer data
    $sql = "SELECT * FROM Customer WHERE customer_id = '$customer_id';";
    $rs = $pdo->query($sql);
    $rowsCustomer = $rs->fetchAll(PDO::FETCH_ASSOC);
    $customer_first = $rowsCustomer[0]['first_name'];
    $customer_last = $rowsCustomer[0]['last_name'];
    $customer_street = $rowsCustomer[0]['street__addr'];
    $customer_city = $rowsCustomer[0]['city_addr'];
    $customer_state = $rowsCustomer[0]['state_addr'];
    $customer_zip = $rowsCustomer[0]['zip_addr'];

    # Label
    echo "<div class=\"mainStyle\">";
    echo "<hr></hr>";
    echo "<h2>Order #$orderval Shipping Label</h2>";
    echo "<p>FROM:   Group 5A, 100 Normal Rd, DeKalb, IL 60115</p>";
    echo "<p>TO:     $customer_first $customer_last, $customer_street, $customer_city, $customer_state $customer_zip</p>";
    echo "<p>WEIGHT: $weight</p>";
    echo "<p>ORDER#: $orderval</p>";
    echo "</div>";
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
</body>
</html>
