<!DOCTYPE HTML>
<html>
<title>Group 5A: Confirmation Page</title>
<body><?php
include 'NavHeader.php';
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

    // $msg .= 'EMAIL SENT TO: '.$email;

    // CONFIRMATION PANEL
    ?>
    <div class="container">
    <h2>Purchase Confirmed</h2>  
    <div class="leftAligned">
    <label style="font-size: 16px;"><?php echo 'ORDER ID: '.$orderId.' ORDERD ON: '.$orderedDate; ?></label><br/> 
    <label style="font-size: 16px;"><?php echo 'TOTAL PRICE: $'.$totalPrice.'    |   STATUS: '.$status; ?></label><br/> 
    <label style="font-size: 16px;"><?php echo 'ORDER WEIGHT: '.$totalWeight.'lbs SHIPPED TO '.$fName.' '.$lName; ?></label><br/> 
    <label style="font-size: 16px;"><?php echo 'DELIVERY ADDRESS: '.$street.' '.$city.', '.$state.' '.$zip; ?></label><br/> 
    </div>
    </div>  
    <?php
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?></body>
</html>