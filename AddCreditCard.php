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
        $num = rand(100,999) . '-' . rand(100000000,999999999) . '-' . rand(100,999);
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
        $obj = json_decode($result);
        if($obj->authorization) {
            // Authorized Logic
        } else {
            // Denied Logic
        }

    }
    catch(PDOexception $e) { // handle that exception
        echo "Connection to database failed: " . $e->getMessage();
        }
    ?>