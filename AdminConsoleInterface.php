<html><head><title>Admin View</title></head><body>
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

	function addAnd(&$sql, &$needAnd) {
		if($needAnd) {
			$sql .= "AND ";
			$needAnd--;
		}
	}

	function addWhere(&$sql, &$needWhere) {
		if($needWhere) {
			$sql .= "WHERE ";
			$needWhere--;
		}
	}

try {

    # Call to Maria database to get relevant tables
    $dsn = "mysql:host=courses;dbname=z1894526";
    $pdo = new PDO($dsn, $username = "z1894526", $password = "1985May09");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "SELECT * FROM Order_ ";
	if( isset($_GET["filter"]) ) {
		$needAnd = 0;
		$needWhere = 1;
		if($_GET["status"] == "ordered") {
			addWhere($sql, $needWhere);
			$sql .= "status = 'Ordered' ";
			$needAnd++;
		}
		else if($_GET["status"] == "fulfilled") {
			addWhere($sql, $needWhere);
			$sql .= "status = 'Fulfilled' ";
			$needAnd++;
		}

		if(!empty($_GET["dateMin"])) {
			addWhere($sql, $needWhere);
			echo "dateMin is not empty <br/>";
			$sql .= "ordered_date >= :dateMin ";
			$needAnd++;
		}
		addAnd($sql, $needAnd);

		if(!empty($_GET["dateMax"])) {
			addWhere($sql, $needWhere);
			echo "dateMax is not empty <br/>";
			$sql .= "ordered_date <= :dateMax ";
			$needAnd++;
		}
		addAnd($sql, $needAnd);

		if(!empty($_GET["priceMin"])) {
			addWhere($sql, $needWhere);
			echo "priceMin is not empty <br/>";
			$sql .= "price >= :priceMin ";
			$needAnd++;
		}
		addAnd($sql, $needAnd);

		if(!empty($_GET["priceMax"])) {
			addWhere($sql, $needWhere);
			echo "priceMax is not empty <br/>";
			$sql .= "price <= :price ";
		}

		
		echo " query is ".$sql."<br/>";

	}
?>
	 <form method="get" action="AdminConsoleInterface.php">
	 <span>Filter orders</span> <br/>
	 <label for="status">Status</label>
	 <select name="status">
	 <option value="any">Any</option>
	 <option value="ordered">Ordered</option>"
	 <option value="fulfilled">Fulfilled</option>
	 </select> <br/>
	 <label for="dateMin">Date Range</label>
	 <input type="date" name="dateMin"/> - 
	 <input type="date" name="dateMax"/> <br/>
	 <label for="priceMin">Price Range</label>
	 <input type="number" name="priceMin"/> - 
	 <input type="number" name="priceMax"/> <br/>
	 <input type="submit" value="Apply Filters" name="filter"/>
	 </form>
<?php

    # Order_ Table calling Function to draw table
    echo "<h2>Order</h2>";
	$rs = $pdo->prepare($sql);
	$rs->execute(
    $rowsFood = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsFood);

    # Part_Order Table calling Function to draw table
    echo "<h2>Part Order</h2>";
    $rs = $pdo->query("SELECT * FROM Part_Order;");
    $rowsMicro = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsMicro);

    # Customer Table calling Function to draw table
    echo "<h2>Customer</h2>";
    $rs = $pdo->query("SELECT * FROM Customer;");
    $rowsCustomer = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rowsCustomer);

}
catch(PDOexception $e) {
    echo "Connection to database failed: " . $e->getMessage();
}
?>

</body>
</html>
