<!DOCTYPE HTML>
<html>
<title>Group 5A: Online Shopping</title>
</head><body>
<?php
session_start();
include 'NavHeader.php';
$pdo;
$Legacydsn;
$qtyMap;
try {
    $pdo = ConnectToDatabase();
    $Legacypdo = ConnectToLegacyDB();
    $rs = $pdo->query("SELECT * FROM Inventory ORDER BY part_number;");
    $partQtys = $rs->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOexception $e) {
    echo "Connection to database failed: " . $e->getMessage();
}
if (isset($_POST['update'])) {
    $quantity = 0;
    $productId = (int)$_POST['productId'];
    if(isset($_SESSION['cart']) && isset($_SESSION['cart'][$productId])) {
        $quantity = $_SESSION['cart'][$productId];
    }
	
    if($_POST['update'] == '+') {
        if($_SESSION["qty"][$productId] < ((int)$_POST['quantity'] + 1)) {
            echo "Invalid Amount";
        } else {
            $quantity = (int)$_POST['quantity'] + 1;
        }
    } else if($_POST['update'] == '-') {
        if($_SESSION["qty"][$productId] < ((int)$_POST['quantity'] - 1)) {
            echo "Invalid Amount";
        } else {
            $quantity = (int)$_POST['quantity'] - 1;
        }
		if($quantity < 0) $quantity = 0;
    }
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'][$productId] = $quantity;
    } else {
        $_SESSION['cart'] = array($productId => $quantity);
    }
}
function createProductCatelog($rowsParts, $partQtys) { 
    ?>
    <div class="grid-container" id="customers">
    <?php

    
    foreach($partQtys as $pQty) {
        $_SESSION["qty"][$pQty['part_number']] = $pQty['quantity_on_hand'];
    }

    foreach($rowsParts as $part){
        ?>
        <div class="grid-item"><tr><td>
        <form id="<?php echo $part['number'] ?>" method="post" action="CustomerInterface.php?#<?php echo $part['number'] ?>"> 
        <input type="hidden" name="productId" style="width:0; height=0;" value="<?php echo $part['number'];?>" />
            <img src="<?php echo $part['pictureURL'] ?>" style="width:200px; height=200px;">
            <h3 style="height: 50px;"><?php echo $part['description'] ?></h3>
            <p class="price"><?php echo "$".$part['price'];?></p>
            <div class="lineSpacing">
            <p><?php echo "QTY AVAILABLE: ".$_SESSION["qty"][$part['number']];?></p>
            <p><?php echo "Part Number: ".$part['number']?></p>
            <p><?php echo "Weight: ".$part['weight']." lbs";?></p>
            </div>
            <p>  <input type="submit" value="-" name="update" class="minus">
            <input type="number" name='quantity' id='quantity' step="1" min="0" max="" class="qty" value="<?php echo (isset($_SESSION["cart"][$part['number']]))?$_SESSION["cart"][$part['number']]:'0';?>" size="16" inputmode="">
            <input type="submit" value="+" name="update" class="plus"></p>
        </form>
        </td></tr></div><?php
    }
    ?></div><?php
}

try {
    $rs = $Legacypdo->query("SELECT * FROM parts;");
    $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div>

   
    <?php createProductCatelog($rowsParts, $partQtys) ?>
    <div class="footer">
        <form method="get" action="CustomerOrder.php">
        <form method="post">
            <input type="submit" class="inputSubmit" value="Checkout Order">
        </form>
    </div>
    </div><?php
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
</body>
</html>