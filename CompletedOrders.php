<html><head><title>Completed Orders</title></head><body><pre>
<?php
try {

    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function Title($rows) 
    {
        foreach($rows as $row)
        {
            echo "<h2>". $row["UserName"] . " (" . $row["UserID"] . ")</h2>";
        }
    }

    $rs = $pdo->prepare("SELECT * FROM order_ WHERE UserName = ?;");
    $rs->execute(array($_GET[Completed]));
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    Title($rows);

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

    $rs = $pdo->query("SELECT * FROM Workout where UserID = '${_GET["User"]}' and CAST(Date AS DATE) >= '${_GET["StartDate"]}' and CAST(Date AS DATE) <= '${_GET["EndDate"]}';");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rows);


    echo "<br></br>";

    echo "<form action=\"http://students.cs.niu.edu/~z1894526/ProductSystem.php\">";
    echo "<input type=\"submit\" value=\"Back\" />";
    echo "</form>";
    
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
    }
?>