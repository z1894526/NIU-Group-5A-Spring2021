<html><head><title>Admin</title></head><body>
<?php

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

try {

    # set up database connection
    $dsn = "mysql:host=courses;dbname=z1880484";
    $pdo = new PDO($dsn, $username = "z1880484", $password = "2000Nov16");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (isset($_POST["newPrice"])) {
		$statement = $pdo->prepare(
			"insert into Shipping_Cost values (:price, :newMin, :newMax);");
		$statement->execute(
				array(":price" => $_POST["newPrice"], ":newMin" => $_POST["newMin"],
				":newMax" => $_POST["newMax"])
			);
	};
	 
    # Shipping_Cost Table calling Function to draw table
    echo "<h2>Shipping Costs</h2>";
    $rs = $pdo->query("SELECT * FROM Shipping_Cost;");
    $rowsWeights = $rs->fetchAll(PDO::FETCH_ASSOC);
	echo "<table border=1 cellspacing=1>";
	echo "<tr>";

	if( !empty($rowsWeights) ) {
		foreach($rowsWeights[0] as $key => $item)
		{
			echo "<th>$key</th>";
		}
		echo "</tr>";        

		echo "<form method=\"post\" action=admin.php>";
		foreach($rowsWeights as $rowWeight){
			echo "<tr> ";
			foreach($rowWeight as $key => $item){
				echo "<td> <input type=\"text\" value=\"$item\"/> </td>";
			}
			echo "</tr>";
		}
		echo "</table>";
		echo "<input type=submit name=fees value=Submit />";
		echo "<form/>";
	}
	echo "<h3>Create a new weight bracket</h3>";
	echo "<form method=post action=admin.php>";
	echo "<input type=text placeholder=price name=newPrice id=newPrice />";
	echo "<input type=text placeholder=\"min weight\" name=newMin id=newMin />";
	echo "<input type=text placeholder=\"max weight\" name=newMax id=newMax />";
	echo "<input type=submit name=newWeights id=newWeights value=\"Create entry\"/>";
	echo "</form>";


    
    echo "<br></br>";
}

catch(PDOexception $e) { 
    echo "Connection to database failed: " . $e->getMessage();
    }
?>
</body>
</html>
