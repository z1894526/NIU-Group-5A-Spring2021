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
}
.leftAlign {
	text-align: left !important;
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
<body><?php
$transId = $_GET["trans_id"];
$orderId = $_GET["order_id"];

try {
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $Legacydsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
    $Legacypdo = new PDO($Legacydsn, $username = "student", $password = "student");
    $Legacypdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // GET ORDER INFO
    $rs = $pdo->query("SELECT * FROM Order_ WHERE order_id=$orderId;");
    $orderArr = $rs->fetchAll(PDO::FETCH_ASSOC);
    $order = $orderArr[0];
    $customerId = $order["customer_id"];
    $orderedDate = $order["ordered_date"];
    $status = $order["status"];
    $totalWeight = $order["weight_total"];
    $totalPrice = $order["price_total"];

    //GET CUSTOMER INFO
    $rs = $pdo->query("SELECT * FROM Customer WHERE customer_id=$customerId;");
    $customerArr = $rs->fetchAll(PDO::FETCH_ASSOC);
    $customer = $customerArr[0];
    $fName = $customer["first_name"];
    $lName = $customer["last_name"];
    $email = $customer["email"];
    $street = $customer["street__addr"];
    $city = $customer["city_addr"];
    $state = $customer["state_addr"];
    $zip = $customer["zip_addr"];

    // CONFIRMATION MSG
    $msg = 'ORDER ID: '.$orderId.' ORDERD ON: '.$orderedDate.'\n';
    $msg .= 'TOTAL PRICE: '.$totalPrice.'    |   STATUS: '.$status.'\n';
    $msg .= 'ORDER WEIGHT: '.$totalWeight.' SHIPPED TO '.$fName.' '.$lName.'\n';
    $msg .= 'DELIVERY ADDRESS: '.$street.''.$city .', '. $state ." ".$zip.'\n';

    $msg = wordwrap($msg,250);
    $msgSub = "Order Purchased: ".$orderId;
    $headers = "From: GROUP5A@NIU";
    mail("s.r.haut@gmail.com",$msgSub,$msg, $headers);

    $msg .= 'EMAIL SENT TO: '.$email;

    // CONFIRMATION PANEL
    ?>
    <div class="container">
    <h2>Purchase Confirmed</h2>  
    <div class="leftAligned">
    <label><?php echo $msg; ?></label>
    </div>
    </div>  
    <?php
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?></body>
</html>