<!DOCTYPE HTML>
<html>
<title>Group 5A: Print List</title>
<body><?php
session_start();
include 'NavHeader.php';
$pdo;
$Legacypdo;

function draw_table_order($rows) {
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

    echo "<th>Part Number</th>";
    echo "<th>Description</th>";
    echo "<th>Quantity</th>";
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

    # Get part data
    $orderval = $_POST["orderselect"];
    $sql = "SELECT part_num, item_name, quantity FROM Part_Order WHERE order_id = '$orderval';";
    $rs = $pdo->query($sql);
    $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class=\"mainStyle\">";
    echo "<hr></hr>";
    echo "<h2>Order #$orderval Packing List</h2>";

    draw_table_order($rowsParts);
    echo "</br/>";
    echo "</div>";
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
</body>
</html>