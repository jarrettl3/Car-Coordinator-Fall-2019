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

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $newEventName = mysqli_real_escape_string($conn,$_POST['name']);
        $newEventAddress = mysqli_real_escape_string($conn,$_POST['address']);
        $newEventDate = mysqli_real_escape_string($conn, $_POST['date']);
        $newEventTime = mysqli_real_escape_string($conn, $_POST['time']);
        $newEventDesc = mysqli_real_escape_string($conn, $_POST['desc']);
        
        $sql = "SELECT * FROM Event ORDER BY Event_ID";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_all($result);
        $users = json_encode($row);
        $numEvents = mysqli_num_rows($result);
        
        $i = 1;
        $toLoop = True;
        while($i <= $numEvents && $toLoop){
            if($i == $row[$i-1][0]){
                $i++;
            }else{
                $toLoop = False;
            }
        }
        
        $todayDate = date("Y-m-d");
        
        $user = $_SESSION['userID'];
        $sql2 = "INSERT INTO Event VALUES ('$i', '$user', '$newEventDate', '$newEventTime', '$newEventName', '$newEventDesc', '$newEventAddress', '$todayDate')";
        
        if ($conn->query($sql2) === TRUE) {
            echo "New record created successfully! Redirecting...";
            print "<script> window.location.replace(\"webpage.php\") </script>";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }

    $uid = $_SESSION['userID'];

echo ' <!DOCTYPE html>
<html lang = "en">
<head>
	<title>Car Coordinator | Create Event</title>
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
			padding-right: 25px;">New Event</span></div>
	<div class = "main" id = "main" style = "text-align: center"> 
        <div style = "padding-left: 25%; text-align: justify">
            <span style = "padding-left: 100px;"><form action = "" method = "post">
                <label>Event Name: </label><input type = "text" name = "name" class = "contain"/><br>
                <label>Address: </label><input type = "text" name = "address" class = "contain"/><br>
                <label>Date: </label><input type = "date" name = "date"/><br>
                <label> Time: </label><input type = "time"name = "time"/><br>
                <label>Description: </label><br><textarea name="desc" rows="10" cols="50"></textarea><br>
                <div style = "text-align: left"><input type = "submit" value = " Submit "/></div><br />
            </form></span>
        <div style = "text-align: left"><a href = "carcoordinator.html">Cancel</a></div>
        </div>
    </div>
	
</body>';