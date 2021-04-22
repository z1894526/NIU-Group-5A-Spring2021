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
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
