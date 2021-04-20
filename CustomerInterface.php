<!DOCTYPE HTML>
<html>
<title>Group 5A: Online Shopping</title>
</head><body>
<?php
session_start();
include 'NavHeader.php';

if (isset($_POST['update'])) {
	$quantity = (int)$_POST['quantity'];
	$productId = (int)$_POST['productId'];
    if($_POST['update'] == '+') {
        $quantity++;
    } else if($_POST['update'] == '-') {
        $quantity--;
		if($quantity < 0) $quantity = 0;
    }
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'][$productId] = $quantity;
    } else {
        $_SESSION['cart'] = array($productId => $quantity);
    }
}

function draw_table_Image($rows) { 
    ?>
    <div class="grid-container" id="customers">
    <?php
    foreach($rows as $row){
        ?>
        <div class="grid-item"><tr><td>
        <form method="post"> 
        <input type="hidden" name="productId" value="<?php echo $row['number'];?>" />
        <div class="container">
        <img width="120" height="100" src="<?php echo $row['pictureURL'] ?>" />
        <p><?php echo $row['description']."<br/>".
        "Part Number: ".$row['number']."<br/>".
        "Amount: $".$row['price']."<br/>".
        "Weight: ".$row['weight']." lbs";?></p>
         <div>
            <input type="submit" value="-" name="update" class="minus">
            <input type="number" name='quantity' id='quantity' step="1" min="0" max="" class="qty" value="<?php echo (isset($_SESSION["cart"][$row['number']]))?$_SESSION["cart"][$row['number']]:'0';?>" size="16" inputmode="">
            <input type="submit" value="+" name="update" class="plus">
        </div>
        </div>
        </form>
        </td></tr></div><?php
    }
    ?></div><?php
}

try {
    $Legacydsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
    $Legacypdo = new PDO($Legacydsn, $username = "student", $password = "student");
    $Legacypdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
     
    $rs = $Legacypdo->query("SELECT * FROM parts;");
    $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);
    
    ?>
    <div>
    
    <form method="get" action="AddPartToOrder.php">
    <form method="post">
    <div class="footer">
        <input type="submit" class="inputSubmit" value="Checkout Order">
    </div>
    </form>

    <?php draw_table_Image($rowsParts) ?>
    </div><?php
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
</body>
</html>