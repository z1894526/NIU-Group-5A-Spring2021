<html><head><title>Group 5A Product System</title></head><body>
<?php

function draw_table($rows) {
    echo "<table border=1 cellspacing=1>";
    echo "<tr>";
    foreach($rows[0] as $key => $item)
    {
        echo "<th>$key</th>";
    }
    echo "</tr>";        

    foreach($rows as $row){
        echo "<tr>";
        foreach($row as $key => $item){
            echo "<td>$item</td>";
        }
        echo"</tr>";
    }
    echo "</table>";
}

try {

    # Call to Maria database to get relevant tables
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>

</body>
</html>