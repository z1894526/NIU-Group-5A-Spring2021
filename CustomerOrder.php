<!DOCTYPE HTML>
<html>
    <!-- Previously AddPartToOrder.php -->
<title>Group 5A: Add Parts To Order</title>
<body>
<?php
session_start();
include 'NavHeader.php';
// Variables
$showDiv = false;
$pdo;
$Legacydsn;
try {
    $pdo = ConnectToDatabase();
    $Legacypdo = ConnectToLegacyDB();
} catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
//GET PARTS FROM LEGACY DB
$rs = $Legacypdo->query("SELECT * FROM parts;");
$rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);
$currentDateTime = date('Y-m-d H:i:s');
$partWeight = 0;
$partPrice = 0;
$totalWeight = 0;
$totalPrice = 0;
$b = [];
if (isset($_SESSION['cart'])) {
    foreach($rowsParts as $rowPart) {
        $itemId = $rowPart["number"];
        if (isset($_SESSION['cart'][$itemId])) {
            $qty = $_SESSION['cart'][$itemId];
            if ($qty > 0) {
                $partDesc = $rowPart["description"];
                $partWeight = $rowPart["weight"] * $qty;
                $partPrice = $rowPart["price"] * $qty;
                $totalWeight = $totalWeight + $partWeight;
                $totalPrice = $totalPrice + $partPrice;
                $a = [$itemId, $partDesc, $qty];
                array_push($b, $a);
            }
        }
    }
}

   // GET CUSTOMER FROM DB
   $rs = $pdo->query("SELECT * FROM Customer;");
   $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

   // SHOW DIV TOGGLE
    if(isset($_POST['showButton'])) {
        $showDiv = true;
    }
    if(isset($_POST['hideButton'])) {
        $showDiv = false;
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
        $sql = "insert into Order_(ordered_date,customer_id,Status,weight_total,price_total) values ('$currentDateTime','$thisCustomer','InCart','$totalWeight','$totalPrice');";
        if (!$pdo->query($sql)) {
            echo "\nOrder, Problem Creating Record";
        }
        $orderId = $pdo->lastInsertId();
        foreach($b as $arr) {
            $sql = "insert into Part_Order(order_id,part_num,item_name,quantity) values ($orderId,'$arr[0]','$arr[1]','$arr[2]');";
            if (!$pdo->query($sql)) {
                echo "\nPart Order, Problem Creating Record";
            }
        }
        ?>
        <script>window.location="AddCreditCard.php?total_price=<?php echo $totalPrice ?>&total_weight=<?php echo $totalWeight ?>&order_id=<?php echo $orderId ?>"</script>
        <?php
      } else {
         echo "\nCustomer ID NOT Found.";
      }
   }
   // ADD NEW CUSTOMER FORM
   ?>
   <div class="outterContainer"><?php
   if ($showDiv) {
      ?>
      <form  method= "post" >
         <input class="inputSubmit" type="submit" name="hideButton" value="Existing Customer? Click here."/>
      </form >
      <div class="innerContainer">
      <h2>New Customer Form</h2> 
      <form style="text-align: left;" method="post"> 
         <label>First Name</label><br/> 
		 <input type="text" class="inputTextSelect" placeholder="first name..." name="first_name" required/>
         <br/><br/> 
         <label>Last Name</label><br/> 
		 <input type="text" class="inputTextSelect" placeholder="last name..." name="last_name" required/>
         <br/><br/> 
         <label>Email</label><br/> 
		 <input type="text" class="inputTextSelect" placeholder="email..." name="email"
             pattern="[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+"
             title = "Must be a valid email address" required/><br/><br/> 
         <label>Street Address</label><br/> 
		 <input type="text" class="inputTextSelect" placeholder="street address..." 
             name="street_addr" required/><br/><br/> 
         <label>City</label><br/> 
		 <input type="text" class="inputTextSelect" placeholder="city..."
             name="city_addr" required/><br/><br/> 
         <label>State</label><br/>
         <select class="inputTextSelect" name="state_addr">
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District Of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
		 </select>
         <label>Zip</label><br/> 
		 <input type="text" class="inputTextSelect" placeholder="zip..." name="zip_addr"
			 pattern="\d{5}(?:[-\s]\d{4})?" title="Must be a valid zip code" required/><br/> 
         <br/> 
         <input type="submit" class="inputSubmit" name="addCustomer" value="Add Customer"> 
      </form>
      <br/>
    <form  action="CustomerInterface.php">
        <input class="back" type="submit" value="Back" />
    </form >
      </div>  
      <?php
   } else {
   ?>
   
      <form  method= "post" >
         <input class="inputSubmit" type="submit" name="showButton" value="New Customer? Lets set you up."/>
      </form >
      <div class="innerContainer">
      <form method="post">
         <label>Existing Customer: Select your name</label><br/>
         <select class="inputTextSelect" name="customer" id="Customer">
         <option value=""></option>
         <?php
         foreach($rows as $row) { 
            echo "<option value=\"" . $row["customer_id"] . "\">". $row["first_name"] . " " . $row["last_name"] . "</option>";
         }
         ?>
         </select>
         <br/><br/>
         <input type="submit" class="inputSubmit" name="continueCheckout" value="Continue Checkout" />
      </form>
      <br/>
        <form  action="CustomerInterface.php">
            <input class="back" type="submit" value="Back" />
        </form >
      </div>
   <?php
   }
   ?>
   </div>
   </body>
</html>
