<html><head><title>Group 5A: Developer View</title></head><body>
<?php
include 'NavHeader.php';
try {
    # Call to Maria database to get relevant tables
    $pdo = ConnectToDatabase();

    # Customer Table calling Function to draw table
    echo "<h2>Customer</h2>";
    $rs = $pdo->query("SELECT * FROM Customer;");
    $rowsCustomer = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsCustomer);

    # Order_ Table calling Function to draw table
    echo "<h2>Order</h2>";
    $rs = $pdo->query("SELECT * FROM Order_;");
    $rowsFood = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsFood);

    # Part_Order Table calling Function to draw table
    echo "<h2>Part Order</h2>";
    $rs = $pdo->query("SELECT * FROM Part_Order;");
    $rowsMicro = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsMicro);

    # Shipping_Cost Table calling Function to draw table
    echo "<h2>Shipping Cost</h2>";
    $rs = $pdo->query("SELECT * FROM Shipping_Cost;");
    $rowsWorkout = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsWorkout);

     # Shipping_Cost Table calling Function to draw table
     echo "<h2>Party Quantity</h2>";
     $rs = $pdo->query("SELECT * FROM Inventory;");
     $rowsQty = $rs->fetchAll(PDO::FETCH_ASSOC);
     draw_table($rowsQty);
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>

</body>
</html>