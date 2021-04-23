<!DOCTYPE HTML>
<html>
<title>Group 5A: Print Label</title>
<body><?php
session_start();
include 'NavHeader.php';

try {
    # Call to Maria database to get relevant tables
    $pdo = ConnectToDatabase();

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