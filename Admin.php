<html><head><title>Admin</title></head><body>
<?php

//suffix indicates where to start searching for overlap
function detectOverlap($min, $max, $suffix) {
	$valid = true;
	$futureMin = "feesData" . $suffix;
	while(isset($_POST[$futureMin])) {
		if( $_POST[$min] == $_POST[$futureMin] ) {
			$valid = false;
		}

		if( $_POST[$min] > $_POST[$futureMin] ) {
			$futureMax = "feesData" . ($suffix+1);
			if ($_POST[$min] < $_POST[$futureMax]) {
				$valid = false;
			}
		}
		$suffix += 3;
		$futureMin = "feesData".$suffix;
	}

	if( $_POST[$min] > $_POST[$max] ) {
		$valid = false;
	}

	return $valid;
}

try {
    // set up database connection
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// add an inputted weight bracket
	if (isset($_POST["newWeights"])) {
//		echo $_POST["newPrice"];
//		echo "<br/>";

		$valid = detectOverlap("newMin","newMax",1);

		if($valid) {
			$statement = $pdo->prepare(
				"insert into Shipping_Cost (price, min_weight, max_weight) " . 
					"values (:price, :newMin, :newMax);"
			);
			$statement->execute(
					array(":price" => $_POST["newPrice"], ":newMin" => $_POST["newMin"],
					":newMax" => $_POST["newMax"])
				);
		}
		else {
			echo "Error in new weight bracket: weights may not overlap with existing ranges";
			echo "<br/>";
		}

	}

	if (isset($_POST["changeFees"])) {
		// delete requested weight brackets (if any)
		$rs = $pdo->query("SELECT min_weight FROM Shipping_Cost ORDER BY min_weight ASC;");
		$minWeights = $rs->fetchAll(PDO::FETCH_COLUMN);	
		$rowNum = 1;
		$deleted=array();
		foreach($minWeights as $minWeight) {
			$name = "delete".$minWeight;	//name of index in $_POST array
			//replace because decimals become underlines in $_POST for some reason
			$name = str_replace(".","_",$name);	
			if (isset($_POST[$name])) {
				// store which row is being deleted
				$deleted[$rowNum]=true;
				$pdo->query("DELETE FROM Shipping_Cost WHERE min_weight = $minWeight;");
			}
			else {
				$deleted[$rowNum] = false;
			}
			$rowNum++;
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

		$suffix = 1;
		$min = "feesData" . $suffix;
		$max = "feesData" . ($suffix+1);
		$rowNum = 1;
		$futureSuffix = $suffix + 3;
		$valid = true;
		// for each row in the shipping cost table
		while(isset($_POST[$min])) {
			// detect any overlap with future rows
			// this part is messed up ugh
			$futureRowNum = $rowNum + 1;
			$futureMin = "feesData" . $futureSuffix;
			// for each future row in the table that was displayed
			while(isset($_POST[$futureMin])) {
				if(!$deleted[$rowNum] and !$deleted[$futureRowNum]) {
					if( $_POST[$min] == $_POST[$futureMin] ) {
						$valid = false;
					}

					if( $_POST[$min] > $_POST[$futureMin] ) {
						$futureMax = "feesData" . ($futureSuffix+1);
						if ($_POST[$min] < $_POST[$futureMax]) {
							$valid = false;
						}
					}
				}

				if( $_POST[$min] > $_POST[$max] and !$deleted[$rowNum]) {
					$valid = false;
				}

				$futureSuffix += 3;
				$futureMin = "feesData".$futureSuffix;
				$futureRowNum++;
			}
			if(!$valid) {
				// if overlapped with row marked for deletion then dont do this
				echo "Error in input: Weight brackets may not overlap";
				echo "<br/>";
				break;	//stop searching for errors
			}

			// change min and max to match with next row
			$suffix += 3;
			$futureSuffix += 3;
			$min = "feesData".$suffix;
			$max = "feesData" . ($suffix+1);
			$rowNum++;
		}

		if($valid) {
			// process input
			// if a weight bracket was modified
			// 
			// update that row in the database
			// easier said than done lol
			$original = $pdo->query("SELECT * FROM Shipping_Cost ORDER BY min_weight ASC;");
			$suffix = 1;
			$rowNum = 0;
			$min = "feesData" . $suffix;
			// for each row that may have been modified
			while(isset($_POST[$min])) {
				$rowNum++;
				//if this row hasn't already been deleted from database
				if(!$deleted[$rowNum]) {	
					$suffix++;
					$max = "feesData".$suffix;
					$suffix++;
					$price = "feesData".$suffix;

					$origBracket = $original->fetch(PDO::FETCH_ASSOC);
					// if a weight bracket was modified
					// (comparisons work because sorted by min_weight)
					if( $_POST[$min] != $origBracket["min_weight"] OR
							$_POST[$max] != $origBracket["max_weight"] OR
							$_POST[$price] != $origBracket["price"] ) {
						// update the database
						$sql = "UPDATE Shipping_Cost SET min_weight = {$_POST[$min]}, " .
							"max_weight = {$_POST[$max]}, price = {$_POST[$price]} " .
							"WHERE min_weight= {$origBracket["min_weight"]}";
						//safe because input restricted to numbers
						$pdo->query($sql);
					}
					$suffix++;
					$min = "feesData" . $suffix;
				} 
				else if ($deleted[$rowNum]) {
					// skip row that will be deleted
					$suffix += 3;
					$min = "feesData" . $suffix;
				}
				// print_r($deleted);
			}
		}	// if modified brackets don't overlap
	}	// if the form to modify shipping costs table was submitted

//	echo '$_POST array:<br/>';
//	print_r($_POST);
//	echo "<br/>";

    // query for shipping costs
	echo "<h2>Shipping Charges</h2>";
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
				echo "<input type=number min=0 step=0.01 value=\"$item\"" .
					" name=\"feesData".$suffix."\"/> </td>";
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
	echo "<input type=number min=0 step=0.01 placeholder=\"min weight\" name=newMin id=newMin />";
	echo "<input type=number min=0 step=0.01 placeholder=\"max weight\" name=newMax id=newMax />";
	echo "<input type=number min=0 step=0.01 placeholder=price name=newPrice id=newPrice />";
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
