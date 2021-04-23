<!DOCTYPE html>
<html>
<title>Group 5A: Product System</title>
<style>
<?php include 'style.css'; ?>
</style>
<body>
    <div class="centerContainer" style="padding: 20px;">
        <form class="smallerButton" method="POST" action="CustomerInterface.php">
            <input type="submit" class="buttonStyle" value="Customer"/>
        </form>
        </br>
        <form class="smallerButton"method="POST" action="ReceivingDesk.php">
            <input type="submit" class="buttonStyle" value="Receiving Desk"/>
        </form>
        </br>
        <form class="smallerButton" method="POST" action="WarehouseInterface.php">
            <input type="submit" class="buttonStyle" value="Warehouse"/>
        </form>
        </br>
        <form class="smallerButton" method="POST" action="AdminConsoleInterface.php">
            <input type="submit" class="buttonStyle" value="Admin Console"/>
        </form>
    </div>
</body>
</html>
