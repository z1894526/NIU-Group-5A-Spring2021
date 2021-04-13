<html><head><title>Credit Card</title></head><body><pre>
    <?php
    try {

        $dsn = "mysql:host=courses;dbname=z1894526";
        $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $Legacydsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
        $Legacypdo = new PDO($Legacydsn, $username = "student", $password = "student");
        $Legacypdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    

        // $rs = $Legacypdo->query("SELECT * FROM parts;");
        // $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>". $_GET["Name"] . "</h2>";
        echo "<h2>". $_GET["cc"] . "</h2>";
        echo "<h2>". $_GET["exp"] . "</h2>";
        echo "<h2>". $_GET["amount"] . "</h2>";

        $url = 'http://blitz.cs.niu.edu/CreditCard/';
        $num = rand(100,999);
        $num .= '-';
        $num .= rand(100000000,999999999);
        $num .= '-';
        $num .= rand(100,999);
        $data = array(
            'vendor' => 'VE0005-99',
            'trans' => $num,
            'cc' => $_GET["cc"],
            'name' => $_GET["Name"], 
            'exp' => $_GET["exp"], 
            'amount' => $_GET["amount"]);

        $options = array(
            'http' => array(
                'header' => array('Content-type: application/json', 'Accept: application/json'),
                'method' => 'POST',
                'content'=> json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        echo($result);

        // $partWeight = 0;
        // $partPrice = 0;
        // $partId = $_GET["description"];
        // foreach($rowsParts as $rowPart){
        //     if ($partId == $rowPart["number"]) {
        //         $partDesc = $rowPart["description"];
        //         $partWeight = $rowPart["weight"] * $_GET["quantity"];
        //         $partPrice = $rowPart["price"] * $_GET["quantity"];
        //     }
        // }

        // #
        // #Status needs to be Completed
        // #
        // $sql = "insert into Order_(ordered_date,customer_id,Status,weight_total,price_total) values ('${_GET["ordered_date"]}','${_GET["customer"]}','Ordered','$partWeight','$partPrice');";
    
        // if ($pdo->query($sql) == TRUE) 
        // {
        //     echo "Order, Record created successfully";

        //     $orderId = $pdo->lastInsertId();
        //     $sql = "insert into Part_Order(order_id,part_num,item_name,quantity) values ($orderId,'$partId','$partDesc','${_GET["quantity"]}');";
        //     if ($pdo->query($sql) == TRUE) 
        //     {
        //         echo "\nPart Order, Record created successfully";
        //     }
        //     else
        //     {
        //         echo "\nPart Order, Problem Creating Record";
        //     }
        // }
        // else
        // {
        //     echo "Order, Problem Creating Record";
        // }

        // echo "<br></br>";

        // echo "<form action=\"http://students.cs.niu.edu/~z1894526/ProductSystem.php\">";
        // echo "<input type=\"submit\" value=\"Back\" />";
        // echo "</form>";  
    }
    catch(PDOexception $e) { // handle that exception
        echo "Connection to database failed: " . $e->getMessage();
        }
    ?>