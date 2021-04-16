<html><head>
<title>Group 5A Product System</title>
<style>
.mainStyle {
    padding: 5px;
    align-items: center;
}
input[type=text], select {
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
input[type=submit] {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
input[type=submit]:hover {
  background-color: #45a049;
}
</style></head><body>
<?php

function toggleDiv(&$showDiv){
    if($showDiv){
        $showDiv = false;
    } else {
        $showDiv = true;
    }
}

try {
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $Legacydsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
    $Legacypdo = new PDO($Legacydsn, $username = "student", $password = "student");
    $Legacypdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $rs = $Legacypdo->query("SELECT * FROM parts;");
    $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);

    $showDiv = false;

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

    // Customer Names
    $rs = $pdo->query("SELECT * FROM Customer;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['showButton'])) {
        $showDiv = !$showDiv;
    }
    if(isset($_POST['continueCheckout'])) {
        #
        # Status needs to be Completed
        #
        $sql = "insert into Order_(ordered_date,customer_id,Status,weight_total,price_total) values ('$currentDateTime','$_POST["customer"]','Ordered','$totalWeight','$totalPrice');";
        if ($pdo->query($sql) == TRUE) {
            echo "Order, Record created successfully";
        } else {
            echo "Order, Problem Creating Record";
        }
    
        $orderId = $pdo->lastInsertId();
        foreach($b as $arr) {
            $sql = "insert into Part_Order(order_id,part_num,item_name,quantity) values ($orderId,'$arr[0]','$arr[1]','$arr[2]');";
            if ($pdo->query($sql) == TRUE)
            {
                echo "\nPart Order, Record created successfully";
            }
            else
            {
                echo "\nPart Order, Problem Creating Record";
            }
        }
    } 
    
    if ($showDiv) {
        echo "<hr></hr>";
        echo "<h2>Add New Customer</h2>";

        echo "<div>";
        echo"<form method=\"get\" action=\"AddNewCustomer.php\">";
        echo"<form method=\"post\">";
        echo "<label>\"First Name\"</label>";
        echo "<br></br><input type=\"text\" name=\"first_name\"/><br/>";
        echo "<label>\"Last Name\"</label>";
        echo "<br></br><input type=\"text\" name=\"last_name\"/><br/>";
        echo "<label>\"Email\"</label>";
        echo "<br></br><input type=\"text\" name=\"email\"/><br/>";
        echo "<label>\"Street Address\"</label>";
        echo "<br></br><input type=\"text\" name=\"street_addr\"/><br/>";
        echo "<label>\"City\"</label>";
        echo "<br></br><input type=\"text\" name=\"city_addr\"/><br/>";
        echo "<label>\"State\"</label>";
        echo "<br></br><input type=\"text\" name=\"state_addr\"/><br/>";
        echo "<label>\"Zip\"</label>";
        echo "<br></br><input type=\"text\" name=\"zip_addr\"/><br/>";

        echo "<br></br>";
        echo"<input type=\"submit\" name=\"button2\" value=\"Add Customer\">";
        echo"</form>";
        echo "</div>";
    }
    if (!$showDiv) {
        echo"<label for=\"customer\">Existing Customer:</label>";
        echo"<select name=\"customer\" id=\"Customer\">";
        foreach($rows as $row)
        {
            echo "<option value=\"" . $row["customer_id"] . "\">". $row["first_name"] . " " . $row["last_name"] . "</option>";
        }
        echo"</select>";

        echo "<form  method=\"post\">";
        echo "<input type=\"submit\" class=\"buttonStyle\" name=\"showButton\" value=\"New Customer\" />";
        echo "</form>";
    }
    echo "<br/><br/>";

    echo "<form  method=\"post\">";
    echo "<input type=\"submit\" class=\"buttonStyle\" name=\"continueCheckout\" value=\"Continue Checkout\" />";
    echo "</form>";
    
    echo "<br></br>";

    echo "<form action=\"CustomerInterface.php\">";
    echo "<input type=\"submit\" value=\"Back\" />";
    echo "</form>";
}
catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>