<!DOCTYPE html>
<html>
<title>Group 5A: Product System</title>
<style>
<?php include 'style.css'; ?>
</style>
<body>
<div class="container">
    <form class="smallerButton" method="POST" action="CustomerInterface.php">
        <input type="submit" class="buttonStyle" value="Customer"/>
    </form>
    </br>
    <form class="smallerButton"method="POST" action="ReceivingDeskInterface.php">
        <input type="submit" class="buttonStyle" value="Receiving Desk"/>
    </form>
    </br>
    <form class="smallerButton" method="POST" action="WarehouseInterface.php">
        <input type="submit" class="buttonStyle" value="Warehouse"/>
    </form>
    </br>
    <form class="smallerButton" method="POST" action="Admin.php">
        <input type="submit" class="buttonStyle" value="Admin Console"/>
    </form>
</div>
</body>
</html>