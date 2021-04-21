<html>
<!-- Thomas Whiteside
     CSCI 467 ECommerce Application
     Receiving Desk Interface   -->
  <head>
  </head>
  <body>
    <?php
      function print_table($rows){
        echo "<table border=1 cellspacing=1";
        echo "<tr>";
        foreach($rows[0] as $key => $item){
          echo "<th>$key</th>";
        }
        echo "</tr>";
        foreach($rows as $row){
          echo "<tr>";
          foreach($row as $key => $item){
            echo "<td>$item</td>";
          }
          echo "</tr>";
        }
        echo "</table>";
      }

      include("secrets.php");
      try{
        $dsn = "mysql:host=courses;dbname=z1789524";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $ldsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
        $lpdo = new PDO($ldsn, 'student', 'student');
        $lpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        echo "<h1>Receiving Desk Interface</h1>";
        echo "<h2>Update Inventory</h2>";

        echo "Item Number</br>";
        echo "<form action='http://students.cs.niu.edu/~z1789524/receivingdesk.php' method='POST'>";
          echo "<input type='number' name='itemid' min='1' max='149' required></br>";
          echo "Amount to add</br>";
          echo "<input type='number' name='amount' required>";
          echo "<input type='submit' value='Update Inventory'>";
        echo "</form></br>";

        #process input
        if (!empty($_POST)){
          $itemid = $_POST["itemid"];
          $amount = $_POST["amount"];
          #search for itemid
          $urows = NULL;
          $rs = $pdo->query("SELECT * FROM Inventory WHERE part_number = '$itemid';");
          $urows = $rs->fetchAll(PDO::FETCH_ASSOC);
          #if item is not yet in database add to database
          if (empty($urows)){
            $rs = $pdo->prepare("INSERT INTO Inventory VALUES(?,?)");
            $rs->execute(array($itemid, $amount));
            echo "</br>Successfully Updated Inventory";
            #output updated inventory
            $rs = $pdo->query("SELECT part_number, quantity_on_hand FROM Inventory WHERE part_number = '$itemid';");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            print_table($rows);
            $urows = NULL;
          }
          #if item is already in database update existing entry
          if (!empty($urows)){
            $rs = $pdo->query("UPDATE Inventory SET quantity_on_hand = quantity_on_hand + $amount WHERE part_number = '$itemid';");
            $urows = NULL;
            echo "</br>Successfully Updated Inventory";
            #output updated inventory
            $rs = $pdo->query("SELECT part_number, quantity_on_hand FROM Inventory WHERE part_number = '$itemid';");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            print_table($rows);
          }
        }
        #print list of current parts
        echo "<h2>Current Parts in Database</h2>";
        $rs = $lpdo->query("SELECT number, description, price, weight, pictureURL FROM parts;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        print_table($rows);
      }
      catch(PDOexception $e){
        echo "Connection to database failed: ". $e->getMessage();
      }
    ?>
  </body>
</html>
