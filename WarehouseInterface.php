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

function draw_table_Image($rows) {
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
    echo "<th>Select</th>";
    echo "</tr>";
    foreach($rows as $row){
        echo "<div>";
        echo "<tr>";
        foreach($row as $key => $item){
            echo "<td>$item</td>";
        }
        echo '<td><input type="radio" name="orderselect" value="'.$row['order_id'].'" id="'.$row['order_id'].'"></td>';
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

    # Get Customers Info
    $rs = $pdo->query("SELECT * FROM Order_ WHERE status = \"Purchased\";");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class=\"mainStyle\">";
    echo "<hr></hr>";
    echo "<h2>Unfulfilled Orders</h2>";

    echo"<form method=\"get\" action=\"ManageOrder.php\">";
    draw_table_Image($rows);
    echo "</br/>";

    # Buttons to manage order
    echo "<br></br>";
    echo"<input type=\"submit\" class=\"buttonStyle\" name=\"button2\" value=\"Manage Order\">";
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
