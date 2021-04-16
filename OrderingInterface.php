<html><head><title>Group 5A Product System</title></head><body><pre>
<?php

function draw_table_Image($rows) {
    echo "<head>
    <style>
        body {background-color: white;}
        table {text-align: center;}
        tr {padding-top: 10px;}
        img { object-fit: contain}
    </style>
    </head>";
    echo "<table border=1 cellspacing=1 cellpadding=1>";
    echo "<tr>";

    foreach($rows[0] as $key => $item)
    {
        echo "<th>$key</th>";
    }
    echo "<th>Add to Cart</th>";
    echo "</tr>";
    foreach($rows as $row){
        echo "<div>";
        echo "<tr>";
        foreach($row as $key => $item){
            if($item == $row["pictureURL"]) {
                echo  "<td><img style=\"width:50px;height:50px;\" src={$item} /></td>";
            } else {
                echo "<td>$item</td>";
            }                    
        }
        echo '<td><input type="number" name="x'.$row['number'].'" id="x'.$row['number'].'" value="0" min="0" max="100"></td>';
        echo"</tr>";
        echo "</div>";
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
    draw_table_Image($rowsParts);
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

try {

    # Call to Maria database to get relevant tables
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    # Get Customers Info
    $rs = $pdo->query("SELECT * FROM Customer;");
    $rowsCustomer = $rs->fetchAll(PDO::FETCH_ASSOC);

    echo "<br/><br/>";
    # Calling Functions using Suporting forms and format
    AddNewCustomer($rowsCustomer);
    echo "<br/><br/>";  

    $rs = $pdo->query("SELECT * FROM Customer;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    AddPartToOrder($rows);
    echo "<br/><br/>";

    $rs = $pdo->query("SELECT * FROM Order_;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    CreditCard($rows);
    echo "<br/><br/>";

    $rs = $pdo->query("SELECT * FROM Order_;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    CompletedOrders($rows);

    echo "<br/><br/>";

    ShippingCost($rows);

}

catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
}
?>
</body>
</html>