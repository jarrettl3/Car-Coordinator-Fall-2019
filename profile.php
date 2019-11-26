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

    $uid = $_SESSION['userID'];

    $sql = "SELECT Event.Event_Name, Host_ID FROM Event
        WHERE Host_ID = '$uid'
        UNION ALL
        SELECT Event.Event_Name, Host_ID FROM Event
        LEFT JOIN Invitation
        On Event.Event_ID = Invitation.Event_ID WHERE  Invited_User_ID = '$uid'
        ORDER BY Host_ID";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_all($result);
    $_SESSION['eventNames'] = json_encode($row);
    
    $sql2 = "SELECT * FROM Event
        WHERE Host_ID = '$uid'
        UNION ALL
        SELECT Event.* FROM Event
        LEFT JOIN Invitation
        On Event.Event_ID = Invitation.Event_ID WHERE  Invited_User_ID = '$uid'
        ORDER BY Host_ID";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_all($result2);
    $_SESSION['events'] = json_encode($row2);

    $sql3 = "SELECT User_ID, Firstname, Lastname FROM User
        LEFT JOIN Event
        ON User_ID = Event.Host_ID WHERE User_ID = '$uid' AND Event.Host_ID IS NOT NULL
        UNION ALL
        SELECT User_ID, Firstname, Lastname FROM User
        LEFT JOIN Event
        On User.User_ID = Event.Host_ID
        LEFT JOIN Invitation
        On Event.Event_ID = Invitation.Event_ID WHERE Invitation.Invited_User_ID = '$uid'
        ORDER BY User_ID";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_all($result3);
    $_SESSION['users'] = json_encode($row3);

    $sql4 = "SELECT * FROM Vehicle
            ORDER BY VIN";
    $result4 = mysqli_query($conn, $sql4);
    $row4 = mysqli_fetch_all($result4);
    $_SESSION['vehicles'] = json_encode($row4);

echo ' <!DOCTYPE html>
<html lang = "en">
<head>
	<title>Car Coordinator</title>
    <link rel="stylesheet" type ="text/css" href="ccstyle.css">

</head>
<script>
    function goToProf(){
        document.title = "Car Coordinator | My Profile";
        var page = document.getElementById("main");
        var vehicles = '.$_SESSION['vehicles'].';
        var vehicleList = "";
        for(var i = 0; i < vehicles.length; i++){
            if(vehicles[i][1] == '.$_SESSION['userID'].'){
                vehicleList += vehicles[i][4] + " " + vehicles[i][2] + " " + vehicles[i][3] + ", " + vehicles[i][5] + " seats, VIN " + vehicles[i][0] + ", License Plate Number: " + vehicles[i][7] + "<br>";
            }
        }
        if(vehicleList == ""){
            vehicleList = "None";
        }
        page.innerHTML = "' .$_SESSION['fname'] . ' ' .$_SESSION['lname'] . '<br> Username: '.$_SESSION['username']. '<br> Address: '.$_SESSION['address']. '<br>  Insurance Provider: '.$_SESSION['insurance']. '<br>  Policy Number: '.$_SESSION['policy'].' <br><button type = \"button\" onclick = \"editProfile()\">Edit</button><br><br>Vehicles:<br>" + vehicleList + " <button type = \"button\" onclick = \"newCar()\">Add Vehicle</button> <br><br> Joined Car Coordinator On: '.$_SESSION['dateAdded'].' ";
    }
    function goToEvents(){
        window.location.href = "events.php";
    }
    function newEvent(){
        window.location.replace("createEvent.php");
    }
    function newCar(){
        window.location.replace("newCar.php");
    }
    function logout(){
        window.location.replace("logout.php");
    }
    function editProfile(){
        window.location.replace("editProfile.php");
    }
</script>
<body  onload = "goToProf()">
	<div class = "sitename"><img src = "betterwheels2.png" alt = "Car Coordinator Logo"></div>
	<div class = "bar"><span class = "item" onclick = "goToProf()" >My Profile</span><span class = "item" onclick = "goToEvents()">Events</span><span class = "item" onclick = "newEvent()">New Event</span><span class = "item" onclick = "logout()">Logout</span></div>
	<div class = "main" id = "main"></div>
	
</body>';