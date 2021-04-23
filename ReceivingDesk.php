<!DOCTYPE HTML>
<html>
<title>Group 5A: Admin</title>
<body><?php
session_start();
include 'NavHeader.php';

$pdo;
$rs;
$rowsParts;
$partQtys;

try {
    # set up database connection
    $pdo = ConnectToDatabase();
    $Legacypdo = ConnectToLegacyDB();

    $rs = $pdo->query("SELECT * FROM Inventory;");
    $partQtys = $rs->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOexception $e) {
    echo "Connection to database failed: " . $e->getMessage();
}

try {
    $rs = $Legacypdo->query("SELECT * FROM parts;");
    $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);

    foreach($rowsParts as $rowPart) {
        $partNum = $rowPart["number"];
        $partDesc = $rowPart["description"];

        $rs = $pdo->query("SELECT * FROM Inventory WHERE part_number = '$partNum';");
        $urows = $rs->fetchAll(PDO::FETCH_ASSOC);
    
        if (empty($urows)){
            $sql = "INSERT INTO `Inventory`(`part_number`, `part_desc`, `quantity_on_hand`) VALUES ('$partNum','$partDesc','10')";
            if (!$pdo->query($sql)) {
                echo "Problem Creating Record";
            } 
        }
    }
} catch(PDOexception $e) {
    echo "Connection to database failed: " . $e->getMessage();
}
#process input
if(isset($_POST["updateInv"])) {
    if (!empty($_POST["itemid"]) || !empty($_POST["itemDesc"])){
        $itemid;
        $itemDesc;

        $updateById = !empty($_POST["itemid"]);
        if($updateById) {
            $itemid = $_POST["itemid"];
        } else {
            $itemDesc = $_POST["itemDesc"];
        }
        $amount = $_POST["amount"];
        
        #search for itemid
        $urows = null;
        $sql = "SELECT * FROM Inventory WHERE ";
        if($updateById) {
            $sql .= "part_number = '$itemid';";
        } else {
            $sql .= "part_desc = '$itemDesc';";
        }
        $rs = $pdo->query($sql);
        $urows = $rs->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($urows)) {
            if($updateById) {
                $sql = "UPDATE Inventory SET quantity_on_hand = quantity_on_hand + $amount WHERE part_number = '$itemid';";
            } else {
                $sql = "UPDATE Inventory SET quantity_on_hand = quantity_on_hand + $amount WHERE part_desc = lower('$itemDesc');";
            }
            if(!$pdo->query($sql)) {
                echo "DB Update Failed.";
            }
        } else {
            echo "Invalid Input!";
        }
        $urows = null;
    } else {
        echo "Must Enter Part Number or Description";
    }
}
$rs = $pdo->query("SELECT * FROM Inventory ORDER BY part_number;");
$partQtys = $rs->fetchAll(PDO::FETCH_ASSOC);
if (isset($_POST['update']) && $partQtys!= null && $partQtys[0]!=null) {
    foreach($partQtys as $pQty) {
        $partNum = $pQty['part_number'];
        if (isset($_POST[$partNum]) && $_POST[$partNum] > 0) {
            $sql = "UPDATE Inventory SET quantity_on_hand=quantity_on_hand+'$_POST[$partNum]' WHERE part_number ='$partNum'";
            if ($pdo->query($sql) == FALSE) 
            {
                echo "Problem Creating Record";
            }
        }
    }

    $rs = $pdo->query("SELECT * FROM Inventory ORDER BY part_number;");
    $partQtys = $rs->fetchAll(PDO::FETCH_ASSOC);    
}

?>
    <!-- <h1>Receiving Desk Interface</h1> -->
    
<div class="centerContainer">
    <form action='' method='POST'>
        <div class="centerDiv">
            <h2>Update Inventory</h2>

            <div style="display: inline;">
                <label>Part Number</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='number' name='itemid'></br></br>
                <label>OR</label></br></br>
                <label>Part Description</labesl>
                <input type='text' name='itemDesc'>
            </div>
            </br></br></br></br>
            <label>Receiving QTY</label></br>
            <input type='number' name='amount' required></br>
            <input type='submit' class="miniButton" name='updateInv' value='Update Inventory'>
        </div>
    </form></br></br>
</div></br></br></br></br>



<table>
<div class="centerContainer">
<h2 style="padding-bottom: 10px;">Update Bulk Inventory</h2>
</div>
<tr>
<?php
echo '<form method="post">';
if($partQtys!= null && $partQtys[0]!=null) {
    foreach($partQtys[0] as $key => $item) {
        echo "<th>$key</th>";
    }
    echo '<th>Receiving QTY</th>';
    echo "</tr>";        
    foreach($partQtys as $pQty) {
        echo "<tr>";
        foreach($pQty as $key => $item){
            if($key=="quantity_on_hand") {
                echo "<td>$item</td>";
                ?>
                    <td>
                        <input type="text" min='1' name='<?php echo $pQty['part_number']; ?>' >      
                    </td>

                <?php
            } else {
                echo "<td>$item</td>";
            }
        }
        echo"</tr>";
    } 
} else {
    echo "NO DATA";
}
?>
    
    <div class="footer">
            <input type="submit" name="update" class="inputSubmit" value="Bulk Update">
    </div>
    </form>
</table>
</body>
</html>