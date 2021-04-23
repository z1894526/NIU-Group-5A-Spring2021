<!DOCTYPE html>
<html>
<style>
<?php include 'style.css'; ?>
</style>
<header>
<div class="topnav">
    <form method="POST" action="CustomerInterface.php">
        <input type="submit" value="Customer"/>
    </form>
    <form method="POST" action="ReceivingDesk.php">
        <input type="submit" value="Receiving Desk"/>
    </form>
    <form method="POST" action="WarehouseInterface.php">
        <input type="submit" value="Warehouse"/>
    </form>
    <form method="POST" action="AdminConsoleInterface.php">
        <input type="submit" value="Admin Console"/>
    </form>
    <!-- <input type="submit" id="FOR CSS ONLY - DON'T DELETE" value=""/> -->
</div>
</body>
<?php 
function ConnectToDatabase() {
    $PASS = "1985May09";
    $DNS = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($DNS, $username="z1894526", $password=$PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
function ConnectToLegacyDB() {
    $Legacydsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
    $Legacypdo = new PDO($Legacydsn, $username = "student", $password = "student");
    $Legacypdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $Legacypdo;
}
function draw_table($rows) {
    echo "<table border=1 cellspacing=1>";
    echo "<tr>";
    if($rows!= null && $rows[0]!=null) {
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
    } else {
        echo "NO DATA";
    }
    echo "</table>";
}
?>
</html>