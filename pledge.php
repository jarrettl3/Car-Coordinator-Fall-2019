<?php
session_start();
// Is the user logged in? 
if (!isset($_SESSION['userID']))
{
   header("location: loginCode.php");
   exit();
}

    $servername = "avl.cs.unca.edu";
    $username = "jlefler";
    $password = "sql4you";
    $conn = new mysqli($servername, $username, $password);

    mysqli_select_db($conn,"jleflerDB");

echo ' <!DOCTYPE html>
<html lang = "en">
<head>
	<title>Car Coordinator | Pledge Vehicle</title>
    <link rel="stylesheet" type ="text/css" href="ccstyle.css">

</head>
<script>
    
</script>
<body>
	<div class = "sitename"><img src = "logo2.png" alt = "Car Coordinator Logo"></div>
	<div class = "bar" style = "text-align: center"><span style = "color: powderblue;
			text-shadow: 2px 2px blue;
			border-bottom-color: coral;
			border-bottom-width: 5px;
			padding: 5px;
			padding-left: 25px;
			padding-right: 25px;">Pledge Vehicle</span></div>
	<div class = "main" id = "main" style = "text-align: center"> 
        <div style = "padding-left: 25%; text-align: justify">
            var myVehicles = '.$_SESSION['vehicles'].';
            var vehicleOpt = "";
            for(var z = 0; z<myVehicles.length; z++){
                if(myVehicles[z][1] == '.$_SESSION['userID'].'){
                    vehicleOpt += "<option value = \"" + myVehicles[z][0] + "\">" + myVehicles[z][4] + " " + myVehicles[z][2] + " " + myVehicles[z][3] + "</option>";
                }
            }
            if(vehicleOpt == ""){
                vehicleOpt = "<select id = \"vehicleList\"><option value = \"None\">None</option></select>"
            }else{
                vehicleOpt = "<select name = \"vehicleList\">" + vehicleOpt + "</select>";
            }
            <span style = "padding-left: 100px;"><form action = "" method = "post">
                <label>Make: </label><input type = "text" name = "make" class = "contain"/><br>
                <label>Model: </label><input type = "text" name = "model" class = "contain"/><br>
                <label>Year: </label><input type = "int" name = "year"/><br>
                <label>License Plate: </label><input type = "text"name = "platenum"/><br>
                <label>Description: </label><br><textarea name="desc" rows="10" cols="50"></textarea><br>
                <div style = "text-align: left"><input type = "submit" value = " Submit "/></div><br />
            </form></span>
        <div style = "text-align: left"><a href = "carcoordinator.html">Cancel</a></div>
        </div>
    </div>
	
</body>';