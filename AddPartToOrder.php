    <html><head><title>Add Part To Order</title></head><body><pre>
    <?php
    try {

        $dsn = "mysql:host=courses;dbname=z1894526";
        $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $Legacydsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
        $Legacypdo = new PDO($Legacydsn, $username = "student", $password = "student");
        $Legacypdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    

        $rs = $Legacypdo->query("SELECT * FROM parts;");
        $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>". $_GET["customer"] . "</h2>";
        echo "<h2>". $_GET["description"] . "</h2>";
        echo "<h2>". $_GET["quantity"] . "</h2>";
        echo "<h2>". $_GET["ordered_date"] . "</h2>";

        
        // $partId = $_GET["description"];
        $itemAdded = 0;
        $partWeight = 0;
        $partPrice = 0;
        $b = [];
        for($x = 1; $x <= 149; $x++){
        foreach($rowsParts as $rowPart)
            $x = $rowPart["number"];
            $qty = $_GET["x".$x];
            if ($qty > 0) {
                $partDesc = $rowPart["description"];
                $partWeight = $rowPart["weight"] * $qty;
                $partPrice = $rowPart["price"] * $qty;
                $a = [$x, $partDesc, $qty, $partWeight, $partPrice];
                array_push($b, $a);
            }
        }
       

        #
        #Status needs to be Completed
        #
        $itemAdded = 0;
        foreach($b as $arr) {
            if($itemAdded == 0) {
                $sql = "insert into Order_(ordered_date,customer_id,Status,weight_total,price_total) values ('${_GET["ordered_date"]}','${_GET["customer"]}','Ordered','$arr[3]','$arr[4]');";
                $itemAdded = 1;
                if ($pdo->query($sql) == TRUE) {
                    echo "Order, Record created successfully";
                } else {
                    echo "Order, Problem Creating Record";
                }
            } else {
                $orderId = $pdo->lastInsertId();
                $sql = "insert into Order_(order_id,ordered_date,customer_id,Status,weight_total,price_total) values ('$orderId','${_GET["ordered_date"]}','${_GET["customer"]}','Ordered','$arr[3]','$arr[4]');";
                if ($pdo->query($sql) == TRUE) {
                    echo "Order, Record created successfully";
                } else {
                    echo "Order, Problem Creating Record";
                } 
            }
        }

        $orderId = $pdo->lastInsertId();
        $itemAdded = 0;
        $sql = "insert into Part_Order(order_id,part_num,item_name,quantity) values ";
        foreach($b as $arr) {
            if($itemAdded > 0) {
                $sql .=",";
            }
            $sql .= "($orderId,'$arr[0]','$arr[1]','$arr[2]')";
        }
        $sql .= ";";

        if ($pdo->query($sql) == TRUE) 
        {
            echo "\nPart Order, Record created successfully";
        }
        else
        {
            echo "\nPart Order, Problem Creating Record";
        }

        echo "<br></br>";

        echo "<form action=\"http://students.cs.niu.edu/~z1894526/ProductSystem.php\">";
        echo "<input type=\"submit\" value=\"Back\" />";
        echo "</form>";  
    }
    catch(PDOexception $e) { // handle that exception
        echo "Connection to database failed: " . $e->getMessage();
        }
    ?>