<!DOCTYPE HTML>
<html>
<title>Group 5A: Add Credit Card</title>
<body>
<?php
session_start();
session_destroy(); // Clears Order History
include 'NavHeader.php';

// <?php
// Get Data from AddPartToOrder.php
$totalPrice = $_GET["total_price"];
$totalWeight = $_GET["total_weight"];
$orderId = $_GET["order_id"];
$shippingPrice = 0;
$pdo;

try {
    $pdo = ConnectToDatabase();
    $rs = $pdo->query("SELECT * FROM Shipping_Cost;");
    $shippingCostArray = $rs->fetchAll(PDO::FETCH_ASSOC);

    foreach($shippingCostArray as $shippingCost) {
        if($totalWeight <= $shippingCost["max_weight"] && $totalWeight >= $shippingCost["min_weight"]){
            $shippingPrice = $shippingCost["price"];
            break;
        }
    }
} catch(PDOexception $e) {/* Exception Handler */
    echo "Connection to database failed: " . $e->getMessage();
}

$formatTotalPrice = '$' . number_format($totalPrice, 2);
$formatShippingPrice = '$' . number_format($shippingPrice, 2);
$calculatedTotalAmount = '$' . number_format(($totalPrice + $shippingPrice), 2);

?>

<div class="outterContainer">
<div class="innerContainer">
<h2>Add Credit Card</h2>
<form style="text-align: left;" method="post">
<label>Name on Card</label><br/> 
<input type="text" class="inputTextSelect" placeholder="Name on card..." name="Name"/><br/><br/> 
<label>Credit Card transIdber</label><br/> 
<input type="text" class="inputTextSelect" placeholder="Credit Card..." name="cc"/><br/><br/>
<label>Expiration Date (MM/YYYY)</label><br/> 
<input type="text" class="inputTextSelect" placeholder="Expiration date..." name="exp"/><br/><br/>
<br/><br/> 
<label style="font-size: 16px;"><?php echo "Order Amount: ".$formatTotalPrice ?></label><br/> 
<label style="font-size: 16px;"><?php echo "Shipping Amount: ".$formatShippingPrice ?></label><br/>
<br/>
<label style="font-size: 16px;"><?php echo "Total Amount: ".$calculatedTotalAmount ?></label><br/> 

<br></br>
<input type="submit" class="inputSubmit" name="AddCC" value="Submit Credit Card">
</form>
<br/>
   <form  action="CustomerOrder.php">
      <input class="back" type="submit" value="Back" />
   </form >
</div>
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
            $sql = "UPDATE Order_ SET `status`='Authorized', `price_total`='$totalPrice'  WHERE order_id=$orderId;";
            if (!$pdo->query($sql)) {
                echo "\nOrder, Problem Creating Record";
            }
            ?>
            <script>window.location="ConfirmationPage.php?order_id=<?php echo $orderId ?>&trans_id=<?php echo $transId ?>"</script>
            <?php
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
