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
   $rs = $pdo->query("SELECT * FROM Order_ where order_id=$orderId;");
   $order = $rs->fetchAll(PDO::FETCH_ASSOC);

   $customerId = $order["customer_id"];
   $orderedDate = $order["ordered_date"];
   $status = $order["status"];
   $totalWeight = $order["weight_total"];
   $totalPrice = $order["price_total"];

   // GET CUSTOMER INFO
   $rs = $pdo->query("SELECT * FROM Customer where customer_id=$customerId;");
   $customer = $rs->fetchAll(PDO::FETCH_ASSOC);

   $fName = $customer["first_name"];
   $lName = $customer["last_name"];
   $email = $customer["email"];
   $street = $customer["street__addr"];
   $city = $customer["city_addr"];
   $state = $customer["state_addr"];
   $zip = $customer["zip_addr"];

//    // GET PART ORDER INFO: Part_Order


}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
<div class="container">
<h2>New Customer Form</h2> 
<form class="leftAlign" method="post"> 
    <label>First Name</label><br/> 
    <input type="text" placeholder="first name..." name="first_name"/><br/><br/> 
    <label>Last Name</label><br/> 
    <input type="text" placeholder="last name..." name="last_name"/><br/><br/> 
    <label>Email</label><br/> 
    <input type="text" placeholder="email..." name="email"/><br/><br/> 
    <label>Street Address</label><br/> 
    <input type="text" placeholder="street address..." name="street_addr"/><br/><br/> 
    <label>City</label><br/> 
    <input type="text" placeholder="city..." name="city_addr"/><br/><br/> 
    <label>State</label><br/> 
    <input type="text" placeholder="state..." name="state_addr"/><br/><br/> 
    <label>Zip</label><br/> 
    <input type="text" placeholder="zip..." name="zip_addr"/><br/> 
    <br/> 
    <input type="submit" name="addCustomer" value="Add Customer"> 
</form>
</div>  
<?php

?></body>
</html>