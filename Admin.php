<html><head><title>Admin</title></head><body>
<?php

try {
    // set up database connection
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// add an inputted weight bracket
	if (isset($_POST["newWeights"])) {
		echo $_POST["newPrice"];
		echo "<br/>";

		// to do:
		// test for valid input
		// make sure weights don't overlap with existing ones

		$statement = $pdo->prepare(
			"insert into Shipping_Cost values (:price, :newMin, :newMax);");
		$statement->execute(
				array(":price" => $_POST["newPrice"], ":newMin" => $_POST["newMin"],
				":newMax" => $_POST["newMax"])
			);
	};

	// apply modifications to weight brackets
	if (isset($_POST["changeFees"])) {
		// delete requested weight brackets (if any)
		$rs = $pdo->query("SELECT min_weight FROM Shipping_Cost;");
		$minWeights = $rs->fetchAll(PDO::FETCH_COLUMN);	
		foreach($minWeights as $minWeight) {
			$name = "delete".$minWeight;	//name of index in $_POST array
			//replace because decimals become underlines in $_POST for some reason
			$name = str_replace(".","_",$name);	
			if (isset($_POST["$name"])) {
				$pdo->query("DELETE FROM Shipping_Cost WHERE min_weight = $minWeight;");
				print_r($pdo->errorInfo());
			}
		}

		//prevent overlapping weight brackets
		//for each min weight
		//	for each min weights after current one
		//		if equal to future min weight
		//			return error
		//	   if greater than future min weight
		//			if current min weight is less than that row's max weight
		//				return error
		//			endif	
		//		endif
		//	end for loop
		//if less than current max weight
		//	return error

		$suffix=1;
		$min = "feesData".$suffix;
		$error = false;
		while(isset($_POST[$min])) {
			$futureSuffix = $suffix + 3;
			$futureMin = "feesData" . $futureSuffix;
			while(isset($_POST[$futureMin])) {
				if( $_POST[$min] == $_POST[$futureMin] ) {
					$error = true;
				}

				if( $_POST[$min] > $_POST[$futureMin] ) {
					$futureMax = "feesData" . ($futureSuffix+1);
					if ($_POST[$min] < $_POST[$futureMax]) {
						$error = true;
					}
				}

				$futureSuffix += 3;
				$futureMin = "feesData".$futureSuffix;
			}

			$max = "feesData" . ($suffix+1);
			if( $_POST[$min] > $_POST[$max] ) {
				$error = true;
			}

			if($error) {
				echo "Error in input: Weight brackets may not overlap";
				break;	//stop searching for errors
			}

			// change min to match with next min_weight value
			$suffix += 3;
			$min = "feesData".$suffix;
		}	// for each row in the table

		if(!$error) {
			// process input
			// if a weight bracket was modified
			// update that row in the database
			// easier said than done haha
		}
	}	// if the form to modify shipping costs table was submitted

	echo '$_POST array:<br/>';
	print_r($_POST);
	echo "<br/>";
	foreach($_POST as $key => $item){
		print_r($item);}

    // query for shipping costs
	echo "<h2>Shipping Costs</h2>";
	$sql = "SELECT min_weight AS 'Min Weight', " .
		"max_weight AS 'Max Weight', price AS 'Price' FROM Shipping_Cost " .
		"ORDER BY min_weight ASC;";
    $rs = $pdo->query($sql);
    $rowsWeights = $rs->fetchAll(PDO::FETCH_ASSOC);
	echo "<table border=1 cellspacing=1>";
	echo "<tr>";

	// prints shipping costs as a tabular form
	if( !empty($rowsWeights) ) {
		foreach($rowsWeights[0] as $key => $item)
		{
			echo "<th>$key</th>";
		}
		echo "<th>mark for deletion</th>";
		echo "</tr>";        

		$suffix=1;
		echo "<form method=\"post\" action=\"{$_SERVER["PHP_SELF"]}\">";
		foreach($rowsWeights as $rowWeight){
			echo "<tr> ";
			foreach($rowWeight as $key => $item){
				echo "<td> ";
				if($suffix % 3 == 0) {		//if displaying a price value
					echo "$";
				}
				echo "<input value=\"$item\" name=\"feesData".$suffix."\"/> </td>";
				++$suffix;
			}
			echo "<td> <input type=checkbox name=delete".$rowWeight["Min Weight"]." value=delete /> </td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<input type=submit name=changeFees value=Submit /> ";
		echo "<form/>";
	}

	// form to add a row to shipping cost table
	echo "<h3>Create a new weight bracket</h3>";
	echo "<form method=\"post\" action=\"{$_SERVER["PHP_SELF"]}\">";
	echo "<input type=number placeholder=\"min weight\" name=newMin id=newMin />";
	echo "<input type=number placeholder=\"max weight\" name=newMax id=newMax />";
	echo "<input type=number placeholder=price name=newPrice id=newPrice />";
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
