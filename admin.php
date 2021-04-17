<html><head><title>Admin</title></head><body>
<?php

try {

    # set up database connection
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST["newPrice"])) {
        $statement = $pdo->prepare(
            "insert into Shipping_Cost values (:price, :newMin, :newMax);");
        $statement->execute(
                array(":price" => $_POST["newPrice"], ":newMin" => $_POST["newMin"],
                ":newMax" => $_POST["newMax"])
            );
    };
     
    # Shipping_Cost Table with form
    echo "<h2>Shipping Costs</h2>";
    $rs = $pdo->query("SELECT * FROM Shipping_Cost;");
    $rowsWeights = $rs->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border=1 cellspacing=1>";
    echo "<tr>";

    if( !empty($rowsWeights) ) {
        foreach($rowsWeights[0] as $key => $item)
        {
            echo "<th>$key</th>";
        }
        echo "</tr>";        

        echo "<form method=\"post\" action=admin.php>";
        foreach($rowsWeights as $rowWeight){
            echo "<tr> ";
            foreach($rowWeight as $key => $item){
                echo "<td> <input type=\"text\" value=\"$item\"/> </td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "<input type=submit name=fees value=Submit />";
        echo "<form/>";
    }

    # form to make new weight bracket
    echo "<h3>Create a new weight bracket</h3>";
    echo "<form method=post action=admin.php>";
    echo "<input type=text placeholder=price name=newPrice id=newPrice />";
    echo "<input type=text placeholder=\"min weight\" name=newMin id=newMin />";
    echo "<input type=text placeholder=\"max weight\" name=newMax id=newMax />";
    echo "<input type=submit name=newWeights id=newWeights value=\"Create entry\"/>";
    echo "</form>";
    
    echo "<br></br>";
}

catch(PDOexception $e) { 
    echo "Connection to database failed: " . $e->getMessage();
    }
?>
</body>
</html>
