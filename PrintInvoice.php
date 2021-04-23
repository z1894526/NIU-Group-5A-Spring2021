<!DOCTYPE HTML>
<html>
<title>Group 5A: Print Invoice</title>
<body><?php
session_start();
include 'NavHeader.php';
$pdo;
$Legacypdo;
function draw_table_invoice($rows) {
    echo "<head>
    <style>
        body {background-color: white;}
        table {text-align: center;}
        tr {padding-top: 10px;}
        img { object-fit: contain}
    </style>
    </head>";
    echo "<table border=1 cellspacing=1 cellpadding=1>";
    echo "<tr>";

    # Headings
    echo "<th>Description</th>";
    echo "<th>Quantity</th>";
    echo "<th>Unit Price</th>";
    echo "<th>Total</th>";
    echo "</tr>";
    foreach($rows as $row){
        echo "<div>";
        echo "<tr>";
        foreach($row as $key => $item){
            if ($key == "price" or $key == "total") {
                echo "<td>\$$item</td>";
            } else if ($key != "part_num"){
                echo "<td>$item</td>";
            }
        }
        echo"</tr>";
        echo "</div>";
    }
    echo "</table>";
}
try {
    $pdo = ConnectToDatabase();
    $Legacypdo = ConnectToLegacyDB();
} catch(PDOexception $e) {
    echo "Connection to database failed: " . $e->getMessage();
}
try {
    # Get legacy part data
    $rs = $Legacypdo->query("SELECT * FROM parts;");
    $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);

    # Get part order data
    $orderval = $_POST["orderselect"];
    $sql = "SELECT part_num, item_name, quantity FROM Part_Order WHERE order_id=$orderval;";
    $rs = $pdo->query($sql);
    $rowsPOrder = $rs->fetchAll(PDO::FETCH_ASSOC);

    # Get order data
    $sql = "SELECT * FROM Order_ WHERE order_id=$orderval;";
    $rs = $pdo->query($sql);
    $rowsOrder = $rs->fetchAll(PDO::FETCH_ASSOC);
    $customer_id = $rowsOrder[0]["customer_id"];
    $weight = $rowsOrder[0]['weight_total'];
    $order_price = $rowsOrder[0]["price_total"];

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

    # Shipping info
    echo '<div class="centerDiv">';
    echo "<div class=\"mainStyle\">";
    echo "<hr></hr>";
    echo "<h2>Order #$orderval Shipping Invoice</h2>";
    echo "<p>FROM:   Group 5A, 100 Normal Rd, DeKalb, IL 60115</p>";
    echo "<p>TO:     $customer_first $customer_last, $customer_street, $customer_city, $customer_state $customer_zip</p>";
    echo "<p>WEIGHT: $weight</p>";
    echo "<p>ORDER#: $orderval</p>";

    # Add total price to each item
    foreach($rowsPOrder as $key => $item) {
        # Find price in legacy db
        $itemno = $item['part_num'];
        $sql = "SELECT price FROM parts WHERE number = $itemno";
        $rs = $Legacypdo->query($sql);
        $legacypart = $rs->fetchAll(PDO::FETCH_ASSOC);

        # Add to row
        $rowsPOrder[$key]['price'] = $legacypart[0]['price'];
        $rowsPOrder[$key]['total'] = $item['quantity'] * $legacypart[0]['price'];
    }

    # Print table
    echo "<p>ITEMS:</p>";
    draw_table_invoice($rowsPOrder);
    echo "<p>SUBTOTAL: \$$order_price</p>";
    echo "</div></div>";
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
</body>
</html>
