<!DOCTYPE HTML>
<html>
<title>Group 5A: Warehosue Interface</title>
<body><?php
session_start();
include 'NavHeader.php';

function draw_table_warehouse($rows) {
    echo "<head>
    <style>
        table {text-align: center;}
    </style>
    </head>";
    echo "<table border=1 cellspacing=1 scellpadding=1>";
    echo "<tr>";
    if($rows!= null && $rows[0]!=null) {
        foreach($rows[0] as $key => $item)
        {
            if ($key != 'filled_date') {
                echo "<th>$key</th>";
            }
        }
        echo "<th>Select</th>";
        echo "</tr>";
        foreach($rows as $row){
            echo "<div>";
            echo "<tr>";
            foreach($row as $key => $item){
                if ($key != 'filled_date') {
                    echo "<td>$item</td>";
                }
            }
            echo '<td><input type="radio" name="orderselect" value="'.$row['order_id'].'" id="'.$row['order_id'].'"></td>';
            echo"</tr>";
            echo "</div>";
        }
    } else {
        echo "No Unfulfilled Orders Available.";
    }
    echo "</table>";
}

try {
    # Call to Maria database to get relevant tables
    $pdo = ConnectToDatabase();

    # Get Customers Info
    $rs = $pdo->query("SELECT * FROM Order_ WHERE status = \"Authorized\";");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class=\"mainStyle\">";
    echo "<hr></hr>";
    echo "<h2>Unfulfilled Orders</h2>";

    echo"<form method=\"get\" action=\"ManageOrder.php\">";
    draw_table_warehouse($rows);
    echo "</br/>";

    # Buttons to manage order
    echo "<br></br>";
    echo '<div class="footer">';
    echo"<input type=\"submit\" class=\"buttonStyle\" name=\"button2\" value=\"Manage Order\">";
    echo '</div>';
    echo"</form>";
    echo "<br/><br/>";
    echo "</div>";
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
</body>
</html>
