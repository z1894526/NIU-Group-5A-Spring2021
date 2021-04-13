<html><head><title>Group 5A Product System</title></head><body><pre>
<?php

try {

    # Call to Maria database to get relevant tables
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function draw_table($rows) {
        echo "<table border=1 cellspacing=1>";
        echo "<tr>";
        foreach($rows[0] as $key => $item)
        {
            echo "<th>$key</th>";
        }
        echo "</tr>";        

        foreach($rows as $row){
            echo "<tr>";
            foreach($row as $key => $item){
                echo "<td>$item</td>";
            }
            echo"</tr>";
        }
        echo "</table>";
    }

    #Add new Customer
    function AddNewCustomer($row)
    {

        echo "<hr></hr>";
        echo "<h2>Add New Customer</h2>";

        echo"<form method=\"get\" action=\"AddNewCustomer.php\">";
        echo"<form method=\"post\">";

        # Text boxes to add values from Cutomers into Customer table
        echo "<br></br><input type=\"text\" name=\"first_name\"/>\"First Name\"<br/>";
        echo "<br></br><input type=\"text\" name=\"last_name\"/>\"Last Name\"<br/>";
        echo "<br></br><input type=\"text\" name=\"email\"/>\"Email\"<br/>";
        echo "<br></br><input type=\"text\" name=\"street_addr\"/>\"Street Address\"<br/>";
        echo "<br></br><input type=\"text\" name=\"city_addr\"/>\"City\"<br/>";
        echo "<br></br><input type=\"text\" name=\"state_addr\"/>\"State\"<br/>";
        echo "<br></br><input type=\"text\" name=\"zip_addr\"/>\"zip\"<br/>";

        echo "<br></br>";
        echo"<input type=\"submit\" name=\"button2\" value=\"Add Customer\">";
        echo"</form>";
    }
    function AddPartToOrder($rows)
    {
        $Legacydsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
        $Legacypdo = new PDO($Legacydsn, $username = "student", $password = "student");
        $Legacypdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    

        $rs = $Legacypdo->query("SELECT * FROM parts;");
        $rowsParts = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<hr></hr>";
        echo "<h2>Add Part to order</h2>";

        echo"<form method=\"get\" action=\"AddPartToOrder.php\">";
        echo"<form method=\"post\">";
        echo"<label for=\"description\">Part Description:</label>";
        echo"<select name=\"description\" id=\"description\">";
                 
        foreach($rowsParts as $rowPart)
        {
            echo "<option value=\"" . $rowPart["number"] . "\">". $rowPart["description"]. "</option>";
        }
        #Text Box
        echo "<br></br>";
        echo "<br></br><input type=\"text\" name=\"quantity\"/>\"Quantity\"<br/>";

        echo"</select>";
        echo "<br></br>";

        echo"<label for=\"customer\">Customer:</label>";
        echo"<select name=\"customer\" id=\"Customer\">";
         
        foreach($rows as $row)
        {
            echo "<option value=\"" . $row["customer_id"] . "\">". $row["first_name"] . " " . $row["last_name"] . "</option>";
        }

        echo"</select>";

        echo"<form method=\"get\" action=\"AddPartToOrder.php\">";
        echo"<form method=\"post\">";
        
        # Text boxes to add values from user input for their Meals
        echo "<br></br><input type=\"text\" name=\"ordered_date\"/>\"Date and Time(YYYY-MM-DD HH:MM:SS)\"<br/>";
	   

        # Button to add vaules inserted into MySql
        echo "<br></br>";
        echo"<input type=\"submit\" name=\"button2\" value=\"Add\">";
        echo"</form>";
    }
    
    #Select a user and get the info for their Weight
    function ShippingCost($rows) 
    {
        echo "<hr></hr>";
        echo "<h2>Select to see Weight</h2>";

        echo"<form method=\"get\" action=\"ShowWeight.php\">";
        echo"<form method=\"post\">";
        echo"<br><label for=\"StartDate\">Start Date:</label>";
        echo"<input type=\"date\" name=\"StartDate\" id=\"StartDate\"></br>";
        echo"<br><label for=\"EndDate\">End Date:</label>";
        echo"<input type=\"date\" name=\"EndDate\" id=\"EndDate\"></br>";
        echo"<br></br>";
        echo"<label for=\"User\">Choose a User:</label>";
        echo"<select name=\"User\" id=\"User\">";
        
        // Create drop down menu
        foreach($rows as $row)
        {
            echo "<option value=\"" . $row["UserID"] . "\">". $row["UserName"] . "</option>";
        }

        echo"</select>";
        echo"<input type=\"submit\" UserName=\"button1\" value=\"Weight\">";
        echo"</form>";
    }

    #Select a user and get the info for their Workout
    function CompletedOrders($rows) 
    {
        echo "<hr></hr>";
        echo "<h2>Select to see Completed Orders</h2>";

        echo"<form method=\"get\" action=\"CompletedOrders.php\">";
        echo"<form method=\"post\">";
        #echo"<br><label for=\"StartDate\">Start Date:</label>";
        #echo"<input type=\"date\" name=\"StartDate\" id=\"StartDate\"></br>";
        #echo"<br><label for=\"EndDate\">End Date:</label>";
        #echo"<input type=\"date\" name=\"EndDate\" id=\"EndDate\"></br>";
        #echo"<br></br>";
        echo"<label for=\"status\">status:</label>";
        echo"<select name=\"status\" id=\"Status\">";
         
        #Create dropdown menu
        foreach($rows as $row)
        {
            echo "<option value=\"" . $row["status"] . "\">". "</option>";
        }

        echo"</select>";
        echo"<input type=\"submit\" UserName=\"button1\" value=\"Completed Orders\">";
        echo"</form>";
    }

    #Add Credit Card
    function CreditCard()
    {
        echo "<hr></hr>";
        echo "<h2>Add Credit Card</h2>";

        echo"<form method=\"get\" action=\"AddCreditCard.php\">";
        echo"<form method=\"post\">";

        # Text boxes to add values from user input for their Workouts
        echo "<br></br><input type=\"text\" name=\"Name\"/>\"Name\"<br/>";
        echo "<br></br><input type=\"text\" name=\"cc\"/>\"Credit Card Number\"<br/>";
        echo "<br></br><input type=\"text\" name=\"exp\"/>\"Expiration Date(MM/YYYY)\"<br/>";
        echo "<br></br><input type=\"text\" name=\"amount\"/>\"amount\"<br/>";

        # Button to add vaules inserted into Workout
        echo "<br></br>";
        echo"<input type=\"submit\" name=\"button2\" value=\"Submit Credit Card\">";
        echo"</form>";
    
    }

    # Customer Table calling Function to draw table
    echo "<h2>Customer</h2>";
    $rs = $pdo->query("SELECT * FROM Customer;");
    $rowsCustomer = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsCustomer);

    # Order_ Table calling Function to draw table
    echo "<h2>Order</h2>";
    $rs = $pdo->query("SELECT * FROM Order_;");
    $rowsFood = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsFood);

    # Part_Order Table calling Function to draw table
    echo "<h2>Part Order</h2>";
    $rs = $pdo->query("SELECT * FROM Part_Order;");
    $rowsMicro = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsMicro);

    # Shipping_Cost Table calling Function to draw table
    echo "<h2>Shipping Cost</h2>";
    $rs = $pdo->query("SELECT * FROM Shipping_Cost;");
    $rowsWorkout = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsWorkout);

    
    echo "<br></br>";

    echo "<br></br>";
    # Calling Functions using Suporting forms and format
    AddNewCustomer($rowsCustomer);
    echo "<br></br>";
    echo "<br></br>";    

    $rs = $pdo->query("SELECT * FROM Customer;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    AddPartToOrder($rows);
    echo "<br></br>";
    echo "<br></br>";

    $rs = $pdo->query("SELECT * FROM Order_;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    CreditCard($rows);
    echo "<br></br>";
    echo "<br></br>";


    $rs = $pdo->query("SELECT * FROM Order_;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    CompletedOrders($rows);

    echo "<br></br>";
    echo "<br></br>";

    ShippingCost($rows);

}

catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
    }
?>