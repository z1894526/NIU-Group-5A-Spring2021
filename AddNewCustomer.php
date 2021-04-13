<html><head><title>Add New Customer</title></head><body><pre>
<?php
try {

    // Create database connection
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>". $_GET["first_name"] . "</h2>";
    echo "<h2>". $_GET["last_name"] . "</h2>";
    echo "<h2>". $_GET["email"] . "</h2>";
    echo "<h2>". $_GET["street_addr"] . "</h2>";
    echo "<h2>". $_GET["city_addr"] . "</h2>";
    echo "<h2>". $_GET["state_addr"] . "</h2>";
    echo "<h2>". $_GET["zip_addr"] . "</h2>";

    // Add customer to database
    $sql = "insert into Customer (first_name, last_name, email, street__addr, city_addr, state_addr, zip_addr) values ('${_GET["first_name"]}','${_GET["last_name"]}','${_GET["email"]}','${_GET["street_addr"]}','${_GET["city_addr"]}','${_GET["state_addr"]}','${_GET["zip_addr"]}');";
    if ($pdo->query($sql) == TRUE) 
    {
        echo "Record created successfully";
    }
    else
    {
        echo "Problem Creating Record";
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
