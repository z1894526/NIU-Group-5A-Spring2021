<!DOCTYPE HTML>
<html>
<style>
* {
    font-family: 'Open Sans Condensed', sans-serif;
    text-transform: uppercase;
}
body {
   background-color: hsl(79, 75%, 87%, 0.5);
}
.mainStyle {
    padding: 5px;
    align-items: center;
}
input[type=text], select {
	border: 2px solid #4D4D4D;
    width: 100%;
    padding: 12px 4px;
    margin: 6px 0;
    border-radius: 4px;
    box-sizing: border-box;
}
input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    border: 1px solid #4D4D4D;
    color: white;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-weight: bold;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
input[type=submit]:hover {
    background-color: #45a049;
}
label {
    font-size: large;
    font-weight: bold;
}
div {
   max-width: 600px;
   text-align: center;
   align-items: center;
}
.leftAlign {
	text-align: left;
}
.container {
    max-width: 500px;
    border-radius: 5px;
    background-color: rgba(42, 91, 139, 0.5);
    border: 4px solid #4D4D4D;
    padding: 40px;
    padding-top: 20px;
}
h2 {
	font-size: 25px;
    text-align: center;
    font-weight: bold;
}
.smallerButton {
	max-width: 500px;
}
</style>
<body>

<?php
$totalPrice = $_GET["total_price"];
$totalWeight = $_GET["total_weight"];
$orderId = $_GET["order_id"];
$shippingPrice = 0;
$pdo;
$dsn = "mysql:host=courses;dbname=z1894526";
try {
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $rs = $pdo->query("SELECT * FROM Shipping_Cost;");
    $shippingCostArray = $rs->fetchAll(PDO::FETCH_ASSOC);

    foreach($shippingCostArray as $shippingCost) {
        if($totalWeight < $shippingCost["max_weight"] && $totalWeight > $shippingCost["min_weight"]){
            $shippingPrice = $shippingCost["price"];
            break;
        }
    }
} catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}

$formatTotalPrice = money_format("$%i", $totalPrice);
$formatShippingPrice = money_format("$%i", $shippingPrice);
$calculatedTotalAmount = money_format("$%i", ($totalPrice + $shippingPrice));

?>

<div class="container">
<hr></hr>
<h2>Add Credit Card</h2>
<form class="leftAlign" method="post">
<label>Name on Card</label><br/> 
<input type="text" placeholder="Name on card..." name="Name"/><br/><br/> 
<label>Credit Card transIdber</label><br/> 
<input type="text" placeholder="Credit Card..." name="cc" value="6011 1234 4321 1234"/><br/><br/>   <!-- DELETE VALUE AFTER TESTING -->
<label>Expiration Date (MM/YYYY)</label><br/> 
<input type="text" placeholder="Expiration date..." name="exp" value="08/2022"/><br/><br/>          <!-- DELETE VALUE AFTER TESTING -->
<br/><br/> 
<label style="font-size: 16px;"><?php echo "Order Amount: ".$formatTotalPrice ?></label><br/> 
<label style="font-size: 16px;"><?php echo "Shipping Amount: ".$formatShippingPrice ?></label><br/>
<br/>
<label style="font-size: 16px;"><?php echo "Total Amount: ".$calculatedTotalAmount ?></label><br/> 

<br></br>
<input type="submit" name="AddCC" value="Submit Credit Card">
</form>
</div>

<?php
if(isset($_POST['AddCC'])) {
    $totalPrice = $totalPrice + $shippingPrice;
    try {
        $url = 'http://blitz.cs.niu.edu/CreditCard/';
        $transId = rand(100,999) . '-' . rand(100000000,999999999) . '-' . rand(100,999);
        $data = array(
            'vendor' => 'VE0005-99',
            'trans' => $transId,
            'cc' => $_POST["cc"],
            'name' => $_POST["Name"], 
            'exp' => $_POST["exp"], 
            'amount' => $totalPrice);

        $options = array(
            'http' => array(
                'header' => array('Content-type: application/json', 'Accept: application/json'),
                'method' => 'POST',
                'content'=> json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $obj = json_decode($result);
        if($obj->authorization) { // Authorized
            $sql = "UPDATE Order_ SET `status`='Purchased', `price_total`='$totalPrice'  WHERE order_id=$orderId;";
            if (!$pdo->query($sql)) {
                echo "\nOrder, Problem Creating Record";
            }
            header("Location: ConfirmationPage.php?order_id=$orderId&trans_id=$transId");
            exit();
        } else { // Denied
            echo "DENIED... TRY AGAIN";
        }
    }
    catch(PDOexception $e) { // handle that exception
        echo "Connection to database failed: " . $e->getMessage();
    }
}
?>