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

// Variables
$showDiv = false;

try {
   $dsn = "mysql:host=courses;dbname=z1894526";
   $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $Legacydsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
   $Legacypdo = new PDO($Legacydsn, $username = "student", $password = "student");
   $Legacypdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   //GET PARTS FROM LEGACY DB
   $rs = $Legacypdo->query("SELECT * FROM parts;");
   $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);
   $currentDateTime = date('Y-m-d H:i:s');
   $partWeight = 0;
   $partPrice = 0;
   $totalWeight = 0;
   $totalPrice = 0;
   $b = [];
   foreach($rowsParts as $rowPart) {
       $x = $rowPart["number"];
       $qty = $_GET["x".$x];
       if ($qty > 0) {
           $partDesc = $rowPart["description"];
           $partWeight = $rowPart["weight"] * $qty;
           $partPrice = $rowPart["price"] * $qty;
           $totalWeight = $totalWeight + $partWeight;
           $totalPrice = $totalPrice + $partPrice;
           $a = [$x, $partDesc, $qty];
           array_push($b, $a);
       }
   }

   // GET CUSTOMER FROM DB
   $rs = $pdo->query("SELECT * FROM Customer;");
   $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

   // SHOW DIV TOGGLE
   if(isset($_POST['showButton'])) {
      if ($showDiv) {
         $showDiv = false;
      } else {
         $showDiv = true;
      }
   }

   // ADD NEW CUSTOMER FUNCTION
   if(isset($_POST['addCustomer'])) {
      try {
          // Add customer to database
          $sql = "insert into Customer (first_name, last_name, email, street__addr, city_addr, state_addr, zip_addr) values ('${_POST["first_name"]}','${_POST["last_name"]}','${_POST["email"]}','${_POST["street_addr"]}','${_POST["city_addr"]}','${_POST["state_addr"]}','${_POST["zip_addr"]}');";
          if ($pdo->query($sql) == TRUE) 
          {
              echo "Customer Information Added Successfully.";
          }
          else
          {
              echo "Problem Creating Record";
          } 
      }
      catch(PDOexception $e) { // handle that exception
          echo "Connection to database failed: " . $e->getMessage();
      }
      $showDiv = false;
      $rs = $pdo->query("SELECT * FROM Customer;");
      $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
   }

   // ADD ORDER TO DB WITH CUSTOMER
   if(isset($_POST['continueCheckout'])) {
      if(!empty($_POST['customer'])) {
        $thisCustomer = $_POST['customer'];
        $sql = "insert into Order_(ordered_date,customer_id,Status,weight_total,price_total) values ('$currentDateTime','$thisCustomer','Ordered','$totalWeight','$totalPrice');";
        if (!$pdo->query($sql)) {
            echo "\nOrder, Problem Creating Record";
        }
        $orderId = $pdo->lastInsertId();
        foreach($b as $arr) {
            $sql = "insert into Part_Order(order_id,part_num,item_name,quantity) values ($orderId,'$arr[0]','$arr[1]','$arr[2]');";
            if (!$pdo->query($sql))
            {
                echo "\nPart Order, Problem Creating Record";
            }
        }
        header("Location: AddCreditCard.php?total_price=$totalPrice&order_id=$orderId");
        exit();
      } else {
         echo "\nCustomer ID NOT Found.";
      }
   }
   echo "<div>";
   // ADD NEW CUSTOMER FORM
   if ($showDiv) {
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
   } else {
   ?>
      <form  method= "post" >
         <input class="smallerButton" type="submit" name="showButton" value="New Customer? Lets set you up."/>
      </form >
      <br/>
      <!-- CONTINUE CHECKOUT FORM -->
      <div class="container"><form method="post">
         <label>Existing Customer:</label><br/>
         <select name="customer" id="Customer">
         <?php
         foreach($rows as $row) { 
            echo "<option value=\"" . $row["customer_id"] . "\">". $row["first_name"] . " " . $row["last_name"] . "</option>";
         }
         ?>
         </select>

         <!-- Checkout Button -->
         <br/><br/>
         <input type="submit" class="buttonStyle" name="continueCheckout" value="Continue Checkout" />
      </form></div>
   <?php
   }

   // Back Button
   ?><br/>
   <form  action="CustomerInterface.php">
      <input class="smallerButton" type="submit" value="Back" />
   </form >
   </div>
   <?php
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?></body>
</html>