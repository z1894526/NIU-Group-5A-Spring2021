<html><head>
<title>Group 5A Product System</title>
<style>
.buttonStyle {
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
    echo "<th>Add to Cart</th>";
    echo "</tr>";
    foreach($rows as $row){
        echo "<div>";
        echo "<tr>";
        foreach($row as $key => $item){
            if($item == $row["pictureURL"]) {
                echo  "<td><img style=\"width:50px;height:50px;\" src={$item} /></td>";
            } else {
                echo "<td>$item</td>";
            }                    
        }
        echo '<td><input type="number" name="x'.$row['number'].'" id="x'.$row['number'].'" value="0" min="0" max="100"></td>';
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
    $rs = $pdo->query("SELECT * FROM Customer;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

    // Add Parts
    $Legacydsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
    $Legacypdo = new PDO($Legacydsn, $username = "student", $password = "student");
    $Legacypdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    

    $rs = $Legacypdo->query("SELECT * FROM parts;");
    $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class=\"mainStyle\">";
    echo "<hr></hr>";
    echo "<h2>Add Part to order</h2>";

    echo"<form method=\"get\" action=\"AddPartToOrder.php\">";
    echo"<form method=\"post\">";
    draw_table_Image($rowsParts);
    echo "</br/>";

    # Button to add vaules inserted into MySql
    echo "<br></br>";
    echo"<input type=\"submit\" class=\"buttonStyle\" name=\"button2\" value=\"Checkout Order\">";
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