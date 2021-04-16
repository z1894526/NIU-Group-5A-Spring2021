<html><head>
<title>Group 5A Product System</title>
<style>
input[type=submit] {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
input[type=submit]:hover {
  background-color: #45a049;
}
</style></head>
<body>

    <form method="POST" action="CustomerInterface.php">
        <input type="submit" class="buttonStyle" value="Customer"/>
    </form>

    <form method="POST" action="ReceivingDeskInterface.php">
        <input type="submit" class="buttonStyle" value="Receiving Desk"/>
    </form>

    <form method="POST" action="WarehouseInterface.php">
        <input type="submit" class="buttonStyle" value="Warehouse"/>
    </form>

    <form method="POST" action="AdminConsoleInterface.php">
        <input type="submit" class="buttonStyle" value="Admin Console"/>
    </form>

</body>
</html>