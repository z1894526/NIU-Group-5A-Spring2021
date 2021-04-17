<!DOCTYPE html>
<html><head>
<title>Group 5A Product System</title>
<style>
* {
    font-family: 'Open Sans Condensed', sans-serif;
    text-transform: uppercase;
}
body {
   background-color: hsl(79, 75%, 87%);
}
.mainStyle {
    padding: 5px;
    align-items: center;
}
input[type=text], select {
	border: 2px solid #4D4D4D;
    width: 100%;
    padding: 12px 4px;
    margin: 6px 0;
    border-radius: 4px;
    box-sizing: border-box;
}
input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    border: 1px solid #4D4D4D;
    color: white;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-weight: bold;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
input[type=submit]:hover {
    background-color: #45a049;
}
label {
    font-size: large;
    font-weight: bold;
}
div {
    max-width: 500px;
    align-items: center;
    border-radius: 5px;
    background-color: rgba(42, 91, 139, 0.5);
    border: 4px solid #4D4D4D;
    padding: 40px;
}
h2 {
	font-size: 25px;
    text-align: center;
    font-weight: bold;
}
.smallerButton {
	max-width: 500px;
}
</style>
<body>

    <form class="smallerButton" method="POST" action="CustomerInterface.php">
        <input type="submit" class="buttonStyle" value="Customer"/>
    </form>

    <form class="smallerButton"method="POST" action="ReceivingDeskInterface.php">
        <input type="submit" class="buttonStyle" value="Receiving Desk"/>
    </form>

    <form class="smallerButton" method="POST" action="WarehouseInterface.php">
        <input type="submit" class="buttonStyle" value="Warehouse"/>
    </form>

    <form class="smallerButton" method="POST" action="Admin.php">
        <input type="submit" class="buttonStyle" value="Admin Console"/>
    </form>

    <!-- REMOVE BEFORE PRESENTATION -->
    </br>
    <form class="smallerButton" method="POST" action="DeveloperView.php">
        <input type="submit" class="buttonStyle" value="Developer ONLY Console"/>
    </form>

</body>
</html>