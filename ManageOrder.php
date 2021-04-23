<!DOCTYPE HTML>
<html>
<title>Group 5A: Manage Order</title>
<body><?php
session_start();
include 'NavHeader.php';

function draw_table_order($rows) {
    echo "<head>
    <style>
        table {text-align: center;}
    </style>
    </head>";
    echo "<table border=1 cellspacing=1 cellpadding=1>";
    echo "<tr>";

    foreach($rows[0] as $key => $item)
    {
        echo "<th>$key</th>";
    }
    echo "</tr>";
    foreach($rows as $row){
        echo "<div>";
        echo "<tr>";
        foreach($row as $key => $item){
            echo "<td>$item</td>";
        }
        echo"</tr>";
        echo "</div>";
    }
    echo "</table>";
}

try {
    # Call to Maria database to get relevant tables
    $pdo = ConnectToDatabase();
    # Get order data
    $orderval = $_GET["orderselect"];
    $sql = "SELECT * FROM Order_ WHERE order_id = '$orderval';";
    $rs = $pdo->query($sql);
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

    # Get part order data
    $sql = "SELECT * FROM Part_Order WHERE order_id = '$orderval';";
    $rs = $pdo->query($sql);
    $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class=\"mainStyle\">";
    echo "<hr></hr>";
    echo "<h2>Manage Order #$orderval</h2>";

    draw_table_order($rows);
    echo "</br/>";
    draw_table_order($rowsParts);
    echo "</br/>";

    # Buttons to manage order
    echo "<br></br>";
    echo "<form method=\"post\" action=\"PrintList.php\">";
    echo "<input type=\"hidden\" id=\"orderselect\" name=\"orderselect\" value=$orderval>";
    echo "<input type=\"submit\" class=\"buttonStyle\" name=\"button2\" value=\"Print Packing List\">";
    echo "</form>";

    echo "<form method=\"post\" action=\"PrintLabel.php\">";
    echo "<input type=\"hidden\" id=\"orderselect\" name=\"orderselect\" value=$orderval>";
    echo "<input type=\"submit\" class=\"buttonStyle\" name=\"button2\" value=\"Print Shipping Label\">";
    echo "</form>";

    echo "<form method=\"post\" action=\"PrintInvoice.php\">";
    echo "<input type=\"hidden\" id=\"orderselect\" name=\"orderselect\" value=$orderval>";
    echo "<input type=\"submit\" class=\"buttonStyle\" name=\"button2\" value=\"Print Shipping Invoice\">";
    echo "</form>";

    echo "<form method=\"post\" action=\"CompleteOrder.php\">";
    echo "<input type=\"hidden\" id=\"orderselect\" name=\"orderselect\" value=$orderval>";
    echo "<input type=\"submit\" class=\"buttonStyle\" name=\"button2\" value=\"Mark Complete\">";
    echo "</form>";

    echo "<br/><br/>";
    echo "</div>";
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
</body>
</html>