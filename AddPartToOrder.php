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

        $partWeight = 0;
        $partPrice = 0;
        $partId = $_GET["description"];
        foreach($rowsParts as $rowPart){
            if ($partId == $rowPart["number"]) {
                $partDesc = $rowPart["description"];
                $partWeight = $rowPart["weight"] * $_GET["quantity"];
                $partPrice = $rowPart["price"] * $_GET["quantity"];
            }
        }

        #
        #Status needs to be Completed
        #
        $sql = "insert into Order_(ordered_date,customer_id,Status,weight_total,price_total) values ('${_GET["ordered_date"]}','${_GET["customer"]}','Ordered','$partWeight','$partPrice');";
    
        if ($pdo->query($sql) == TRUE) 
        {
            echo "Order, Record created successfully";

            $orderId = $pdo->lastInsertId();
            $sql = "insert into Part_Order(order_id,part_num,item_name,quantity) values ($orderId,'$partId','$partDesc','${_GET["quantity"]}');";
            if ($pdo->query($sql) == TRUE) 
            {
                echo "\nPart Order, Record created successfully";
            }
            else
            {
                echo "\nPart Order, Problem Creating Record";
            }
        }
        else
        {
            echo "Order, Problem Creating Record";
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