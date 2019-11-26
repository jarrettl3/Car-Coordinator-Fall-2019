<?php
session_start();
// Is the user logged in? 
if (!isset($_SESSION['userID']))
{
    $url = $_SERVER['REQUEST_URI'];
    $event = explode('?',$url);
    if (count($event) > 1){
        header("location: loginCode.php?".$event[1]);
        exit();
    }else{
        header("location: loginCode.php");
        exit();
    }
}

    $servername = "avl.cs.unca.edu";
    $username = "jlefler";
    $password = "sql4you";
    $conn = new mysqli($servername, $username, $password);

    mysqli_select_db($conn,"jleflerDB");

    $uid = $_SESSION['userID'];

    $sql = "SELECT * FROM Event
        WHERE Host_ID = '$uid'
        UNION ALL
        SELECT Event.* FROM Event
        LEFT JOIN Invitation
        On Event.Event_ID = Invitation.Event_ID WHERE  Invited_User_ID = '$uid'
        ORDER BY Event_ID";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_all($result);
    $_SESSION['events'] = json_encode($row);

    $sql2 = "SELECT User_ID, Firstname, Lastname FROM User
        LEFT JOIN Event
        ON User_ID = Event.Host_ID WHERE User_ID = '$uid' AND Event.Host_ID IS NOT NULL
        UNION ALL
        SELECT User_ID, Firstname, Lastname FROM User
        LEFT JOIN Event
        On User.User_ID = Event.Host_ID
        LEFT JOIN Invitation
        On Event.Event_ID = Invitation.Event_ID WHERE Invitation.Invited_User_ID = '$uid'
        ORDER BY User_ID";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_all($result2);
    $_SESSION['users'] = json_encode($row2);

    $sql3 = "SELECT * FROM Invitation
            ORDER BY Event_ID";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_all($result3);
    $_SESSION['invites'] = json_encode($row3);

    $sql4 = "SELECT User_ID, Firstname, Lastname, Username, Email_Address FROM User
            ORDER BY User_ID";
    $result4 = mysqli_query($conn, $sql4);
    $row4 = mysqli_fetch_all($result4);
    $_SESSION['allUsers'] = json_encode($row4);

    $sql5 = "SELECT * FROM Vehicle_Pledge
            ORDER BY Pledge_ID";
    $result5 = mysqli_query($conn, $sql5);
    $row5 = mysqli_fetch_all($result5);
    $_SESSION['vehiclePledges'] = json_encode($row5);

    $sql6 = "SELECT * FROM Vehicle
            ORDER BY VIN";
    $result6 = mysqli_query($conn, $sql6);
    $row6 = mysqli_fetch_all($result6);
    $_SESSION['vehicles'] = json_encode($row6);

    $sql7 = "SELECT * FROM Seat_Claim
            ORDER BY Claim_ID";
    $result7 = mysqli_query($conn, $sql7);
    $row7 = mysqli_fetch_all($result7);
    $_SESSION['seatClaims'] = json_encode($row7);

    switch($_POST['whichForm']) {
        case 'invite': 
                echo "<script>console.log('started POST');</script>";
                $userInvite = mysqli_real_escape_string($conn,$_POST['userToInvite']);
                echo "<script>console.log('Username entered: " . $userInvite . "');</script>";
                $theUsers = $row4;
                echo "<script>console.log('Users: " . $theUsers . "');</script>";
                for($i = 1; $i < count($theUsers); $i++){
                    echo "<script>console.log('Username comparing to: " . $theUsers[$i-1][3]. "');</script>";
                    if(strcmp($userInvite, $theUsers[$i-1][3]) == 0){
                        echo "<script>console.log('Matching username');</script>";
                        $sql = "SELECT * FROM Invitation ORDER BY Invite_ID";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_all($result);
                        $users = json_encode($row);
                        $numInvites = mysqli_num_rows($result);
        
                        $e = 1;
                        $toLoop = True;
                        while($e <= $numInvites && $toLoop){
                            if($e == $row[$e-1][0]){
                                $e++;
                            }else{
                                $toLoop = False;
                            }
                        }
                        $addingUserId = $theUsers[$i-1][0];
                        $eventid = mysqli_real_escape_string($conn, $_POST['eventId']);
                        $eventname = mysqli_real_escape_string($conn, $_POST['eventName']);
                        $inviteSql = "INSERT INTO Invitation VALUES ('$e', '$eventid', '$addingUserId')";
                        if ($conn->query($inviteSql) === TRUE) {
                            mail($theUsers[$i-1][4], "New Invitation", "Hello, ".$theUsers[$i-1][3].". \n You have been invited to the event ".$eventname." on Car Coordinator! \n Click here to view the event: www.cs.unca.edu/~jlefler/carcoordinator/events.php?event=".$eventid, "FROM: <invites@carcoordinator>");
                            echo "Invite posted";
                            $sql4 = "SELECT User_ID, Firstname, Lastname, Username FROM User
                                ORDER BY User_ID";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_all($result4);
                            $_SESSION['allUsers'] = json_encode($row4);
                            echo "<meta http-equiv='refresh' content='1'>";
                            //echo "<script>goToSpecific('$eventname', $eventid);</script>";    
                        } else {
                            echo "<script>console.log('Problem');</script>";
                            echo "Error: " . $inviteSql . "<br>" . $conn->error;
                        }
                        echo "<script>console.log('Finished POST');</script>";
                        break;
                    }
                }
                echo "<script>console.log('Finished');</script>";
            break;
        case 'pledge':
                $g = 1;
                $sql = "SELECT * FROM Vehicle_Pledge
                    ORDER BY Pledge_ID";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_all($result);
                $numPledges = mysqli_num_rows($result);
                $toLoop = True;
                while($g <= $numPledges && $toLoop){
                    if($g == $row[$g-1][0]){
                        $g++;
                    }else{
                        $toLoop = False;
                    }
                }
                $eventid = mysqli_real_escape_string($conn, $_POST['eventId']);
                $todayDate = date("Y-m-d");
                $vehicleVIN = $_POST['vehicleList'];
                $pledgedesc = mysqli_real_escape_string($conn, $_POST['pledgedesc']);
                $pledgeSql = "INSERT INTO Vehicle_Pledge VALUES ('$g', '$vehicleVIN', '$eventid',  '$todayDate', '$pledgedesc')";
                if($conn->query($pledgeSql) === TRUE){
                    $sql5 = "SELECT * FROM Vehicle_Pledge
                        ORDER BY Pledge_ID";
                    $result5 = mysqli_query($conn, $sql5);
                    $row5 = mysqli_fetch_all($result5);
                    $_SESSION['vehiclePledges'] = json_encode($row5);
                    echo "<meta http-equiv='refresh' content = '1'>";
                } else {
                    echo "Error: " .$pledgeSql. "<br>" . $conn->error;
                }
            break;
        case 'claim':
            $f = 1;
            $sql = "SELECT * FROM Seat_Claim
                    ORDER BY Claim_ID";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_all($result);
            $numClaims = mysqli_num_rows($result);
            $toLoop = True;
            while($f <= $numClaims && $toLoop){
                if($f == $row[$f-1][0]){
                    $f++;
                }else{
                    $toLoop = False;
                }
            }
            $pledgeid = mysqli_real_escape_string($conn, $_POST['pledgeid']);
            $claimUser = $_SESSION['userID'];
            $claimSql = "INSERT INTO Seat_Claim VALUES ('$f', '$pledgeid', '$claimUser')";
            if($conn->query($claimSql) === TRUE){
                $sql7 = "SELECT * FROM Seat_Claim
                ORDER BY Claim_ID";
                $result7 = mysqli_query($conn, $sql7);
                $row7 = mysqli_fetch_all($result7);
                $_SESSION['seatClaims'] = json_encode($row7);
                $eid = $_POST['eventid'];
                echo "<script>goToSpecific($eid)</script>";
            }else{
                echo "Error: " .$claimSql. "<br>" . $conn->error;
            }
            break;
        case 'deleteClaim':
            $claimid = mysqli_real_escape_string($conn, $_POST['claimid']);
            deleteClaim($claimid, $conn);
            break;
        case 'deletePledge':
            $pledgeid = mysqli_real_escape_string($conn, $_POST['pledgeid']);
            deletePledge($pledgeid, $conn);
            break;
        case 'deleteInvite':
            $inviteid = mysqli_real_escape_string($conn, $_POST['inviteid']);
            deleteInvite($inviteid, $conn);
    }

    function deleteClaim($claimid, $conn){
        $sql = "DELETE FROM Seat_Claim WHERE Claim_ID = $claimid";
        if($conn->query($sql) === TRUE){
            $sql7 = "SELECT * FROM Seat_Claim
                ORDER BY Claim_ID";
            $result7 = mysqli_query($conn, $sql7);
            $row7 = mysqli_fetch_all($result7);
            $_SESSION['seatClaims'] = json_encode($row7);
            echo "<meta http-equiv='refresh' content = '1'>";
        }else{
            echo "Error: " .$sql. "<br>" . $conn->error;
        }
    }

    function deletePledge($pledgeid, $conn){
            $sql = "DELETE FROM Vehicle_Pledge WHERE Pledge_ID = $pledgeid";
            if($conn->query($sql) === TRUE){
                $sql7 = "SELECT * FROM Vehicle_Pledge
                    ORDER BY Pledge_ID";
                $result7 = mysqli_query($conn, $sql7);
                $row7 = mysqli_fetch_all($result7);
                $_SESSION['vehiclePledges'] = json_encode($row7);
                echo "<meta http-equiv='refresh' content = '1'>";
            }else{
                echo "Error: " .$sql7. "<br>" . $conn->error;
            }
        }

    function deleteInvite($inviteid, $conn){
        /*$sql7 = "SELECT * FROM Seat_Claim
            ORDER BY Claim_ID";
        $result7 = mysqli_query($conn, $sql7);
        $row7 = mysqli_fetch_all($result7);
        $numClaims = mysqli_num_rows($result7);
        $claims = $_SESSION['seatClaims'];
        $sql3 = "SELECT * FROM Invitation
            ORDER BY Event_ID";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_all($result3);
        $numInvites = mysqli_num_rows($result3);
        $invites = $_SESSION['invites'];
        $sql7 = "SELECT * FROM Vehicle_Pledge
            ORDER BY Pledge_ID";
        $result7 = mysqli_query($conn, $sql7);
        $row7 = mysqli_fetch_all($result7);
        $numPledges = mysqli_num_rows($result7);
        $pledges = $_SESSION['vehiclePledges'];
        
        for($e = 0; $e < $numInvites; $e++){
            if($invites[$e][0] == $inviteid){
                for($i = 0; $i < $numClaims; $i++){
                    if($claims[$i][2] == $invites[$e][2]){
                        for($z = 0; $z < $numPledges; $z++){
                            if($pledges[$z][2] == $invites[$e][1]){
                                deleteClaim($claims[$i][0], $conn); 
                            }
                        }
                    }
                }
            }
        }*/
        
        $sql = "DELETE FROM Invitation WHERE Invite_ID = $inviteid";
        if($conn->query($sql) === TRUE){
            $sql2 = "SELECT * FROM Invitation
                    ORDER BY Invite_ID";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_all($result2);
            $_SESSION['invites'] = json_encode($row2);
            echo "<meta http-equive='refresh' content = '1'>";
        }else{
            echo "Error: " .$sql2. "<br>" . $conn->error;
        }
    }

echo ' <!DOCTYPE html>
<html lang = "en">
<head>
	<title>Car Coordinator</title>
    <link rel="stylesheet" type ="text/css" href="ccstyle.css">

</head>
<script>
    function goToProf(){
        window.location.href = "profile.php";
    }
    function clearSelect(){
        window.location.href = "events.php";
        goToEvents();
    }
    function goToEvents(){
        document.title = "Car Coordinator | Events";
        var page = document.getElementById("main");
        var i = 0;
        var text = "";
        var en = '.$_SESSION['events'].';
        if(en != null){
            while(i < en.length){
                text += "<div class = \"vent\" id = \'" + en[i][4] + "\' onclick = \"setSelect(" + en[i][0]+ ")\">" + en[i][4] + "</div> <br>";
                i++;
            }
        }else{
            text = "no events";
        }
        
        page.innerHTML = text;
        
        var myurl = window.location.href;
        var eventSelect = myurl.split("?");
        if(eventSelect.length > 1){
            eventSelect = eventSelect[1].split("=")[1];
            goToSpecific(eventSelect);
        }
    }
    function setSelect(event){
        window.location.href = "events.php?event=" + event;
    }
    function goToSpecific(eventid){
        
        document.title = "Car Coordinator | EVENT";
        var events = '.$_SESSION['events'].';
        var x = 0;
        while(x < events.length){
            if(eventid == events[x][0]){
                var evrow = x;
            }
            x++;
        }
        var eventname = events[evrow][4];
        document.title = "Car Coordinator | " + eventname;
        
        var users = '.$_SESSION['users'].';
        var allUsers = '.$_SESSION['allUsers'].';
        var eid = Number(eventid);
        var uid = '.$_SESSION['userID'].';
        var date =  new Date(events[evrow][2]);
        var eventDate = (date.getMonth()+1) + "/" + (date.getDate()+1) + "/" + date.getFullYear();
        var time = events[evrow][3];
        time = time.split(":");
        var hours = Number(time[0]);
        var min = Number(time[1]);
        if(hours <= 12){
            var M = "AM";
        }else{
            hours -= 12;
            var M = "PM";
        }
        if(min < 10){
            min = "0" + min;
        }
        var eventTime = hours + ":" + min + " " + M;
        var page = document.getElementById("main");
        var invites = '.$_SESSION['invites'].';
        var inviteList = "";
        var numInvites = 0;
        for(var i = 0; i < invites.length; i++){
            if(Number(invites[i][1]) == (eid)){
                for(var e = 0; e < allUsers.length; e++) {
                    if(invites[i][2] == allUsers[e][0]){
                        inviteList += "<div style = \"text-indent: 50px; display: inline-block\">" + allUsers[e][1] + " " + allUsers[e][2] + "</div>";
                        numInvites++;
                        if(events[evrow][1] == uid){
                            inviteList += "<form style = \"display: inline\" action = \"\" method = \"post\"><input type = \"hidden\" value = \"deleteInvite\" name = \"whichForm\"><input type = \"hidden\" name = \"inviteid\" value = \"" + invites[i][0] + "\"><input type = \"submit\" value = \"Uninvite\" style = \"position: relative; left: 10px\"></form>"
                        }
                        inviteList += "<br>";
                    }
                }
            }
        }
        if(inviteList == ""){
            inviteList = "<div style =\"text-indent: 50px; display: inline-block\">No invitations yet</div>";
        }
        
        var pledges = '.$_SESSION['vehiclePledges'].';
        var vehicles = '.$_SESSION['vehicles'].';
        var claims = '.$_SESSION['seatClaims'].';
        var pledgeList = "";
        var numPledges = 0;
        for(var i =0; i < pledges.length; i++){
            if(pledges[i][2] == eid){
                    for(var e = 0; e < vehicles.length; e++){
                        if(vehicles[e][0] == pledges[i][1]){
                            var claimList = "";
                            var claimTotal = 0;
                            for(var x = 0; x < claims.length; x++){
                                if(claims[x][1] == pledges[i][0]){
                                    claimTotal++;
                                    for(var y = 0; y < allUsers.length; y++){
                                        if(claims[x][2] == allUsers[y][0]){
                                            claimList+= "<span style = \"text-indent: 75px; display: inline-block\">" + allUsers[y][1] + " " + allUsers[y][2] + "</span>";
                                            var uid = '.$_SESSION['userID'].';
                                            if(claims[x][2] == uid){
                                                claimList += "<form style = \"display: inline\" action = \"\" method = \"post\"><input type = \"hidden\" value = \"deleteClaim\" name = \"whichForm\"><input type = \"hidden\" name = \"claimid\" value = \"" + claims[x][0] + "\"><input type = \"submit\" value = \"Remove Claim\" style = \"position: relative; left: 10px\"></form>";
                                            }
                                            claimList += "<br>";
                                        }
                                    }
                                }
                            }
                            if(claimList == ""){
                                claimList = "<div style = \"text-indent: 75px;\">No seat claims yet</div>";
                            }
                            var claimId = "showClaim" + e;
                            var theClaimsId = "theClaims" + e;
                            var newText = "<div style = \"text-indent: 50px; display: inline-block\">" + allUsers[vehicles[e][1]-1][1] + " " + allUsers[vehicles[e][1]-1][2] + "\'s Vehicle -- " + claimTotal + "/" + vehicles[e][5] + " Passengers</div>"
                            if(vehicles[e][1] == uid){
                                newText += "<div style = \"text-indent: 50px\"><form action = \"\" method = \"post\"><input type = \"hidden\" value = \"deletePledge\" name = \"whichForm\"><input type = \"hidden\" name = \"pledgeid\" value = \"" + pledges[i][0] + "\"><input type = \"submit\" value = \"Remove Pledge\"></form></div>";
                             }
                            newText += "<div style = \"text-indent: 75px; font-style: italic\">" + pledges[i][4] + "</div> <div style = \"text-indent: 55px; display: inline-block\">Claimed Seats:</div> <span id = \'" + claimId + "\' class = \"vent\" onclick = \"showClaims(\'" + e + "\')\" style = \"color: gray\">(+)</span> <div style = \"display: none\"id = \'" + theClaimsId + "\'>" + claimList + "</div>";
                             numPledges++;
                        }
                    }
                
                pledgeList += newText + "<form action = \"\" method = \"post\"><input type = \"hidden\" name = \"eventid\" value =\"" + eventid+ "\"><input type = \"hidden\" value = \"claim\" name = \"whichForm\"><input type = \"hidden\" name = \"pledgeid\" value = \"" + pledges[i][0] + "\"><input type = \"submit\" value = \"Claim Seat\" style = \"position: relative; left: 75px\"></form><br>";
            }
        }
        if(pledgeList == ""){
            pledgeList = "<div style = \"text-indent: 50px; display: inline-block\">No vehicle pledges yet</div";
        }
        
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
        
        page.innerHTML = "<h1>"  + eventname + "</h1><h3>" + events[evrow][6] + "</h3><h3>" + eventDate + " at " + eventTime + "</h3><p> by " + allUsers[events[evrow][1]-1][1] + " " + allUsers[events[evrow][1]-1][2] + "<br><br> <p>" + events[evrow][5] +"</p> <BR><BR> Invited: [" + numInvites + " total]<span class = \"vent\" onclick=\"showInvites()\" style = \"color: gray\" id = \"showInvites\">(+)</span> <BR> <div id = \"theInvited\" style = \"display: none\">" + inviteList + "</div> <form action = \"\" method = \"post\"><label>Invite: </label> <input type = \"text\" name = \"userToInvite\" class = \"contain\"/><input type=\"hidden\" id=\"eventId\" name=\"eventId\" value=\"" + eid + "\"> <input type = \"hidden\" id = \"eventName\" name = \"eventName\" value=\"" + eventname + "\"><input type = \"hidden\" value = \"invite\" name = \"whichForm\"><input type = \"submit\" value = \"Invite\" id = \"sbmtbtn\"> </form> <BR>Vehicles: [" + numPledges + " total]<span class = \"vent\" onclick = \"showPledges()\" style = \"color: gray\" id = \"showPledges\">(+)</span><BR><div id = \"thePledges\" style = \"display: none\">" + pledgeList + "<\div> <BR> <form action = \"\" method = \"post\"><input type = \"hidden\" value = \"pledge\" name = \"whichForm\"><input type=\"hidden\" id=\"eventId\" name=\"eventId\" value=\"" + eid + "\"><label>Pledge Description: </label><BR><textarea name = \"pledgedesc\" rows=\"5\" cols=\"35\"></textarea><BR>" + vehicleOpt + "<input type=\"submit\" value=\"Pledge Vehicle\" id = \"sbmtbtn\"></form>";
    }
    

    function showInvites(){
        var invites = document.getElementById("theInvited");
        var show = document.getElementById("showInvites");
        if(invites.style.display === "none"){
            invites.style.display = "block";
            show.innerHTML = "(-)";
        }else{
            invites.style.display = "none";
            show.innerHTML = "(+)";
        }
    }
    function showClaims(id){
        var showId = "showClaim" + id;
        var show = document.getElementById(showId);
        var claimId = "theClaims" + id;
        var claim = document.getElementById(claimId);
        if(claim.style.display === "none"){
            claim.style.display = "block";
            show.innerHTML = "(-)";
        }else{
            claim.style.display = "none";
            show.innerHTML = "(+)";
        }
    }
    function showPledges(){
        var invites = document.getElementById("thePledges");
        var show = document.getElementById("showPledges");
        if(invites.style.display === "none"){
            invites.style.display = "block";
            show.innerHTML = "(-)";
        }else{
            invites.style.display = "none";
            show.innerHTML = "(+)";
        }
    }
    function pledgeVehicle(event){
        var list = document.getElementById("vehicleList");
        var selected = list.options[list.selectedIndex].value;
        if(selected == "None"){
            
        }else{
            
            var sqlString1 = "INSERT INTO Vehicle_Pledge VALUES (";
 
        }
    }
    function newEvent(){
        window.location.replace("createEvent.php");
    }
    function logout(){
        window.location.replace("logout.php");
    }
</script>
<body onload="goToEvents()">
	<div class = "sitename"><img src = "betterwheels2.png" alt = "Car Coordinator Logo"></div>
	<div class = "bar"><span class = "item" onclick = "goToProf()" >My Profile</span><span class = "item" onclick = "clearSelect()">Events</span><span class = "item" onclick = "newEvent()">New Event</span><span class = "item" onclick = "logout()">Logout</span></div>
	<div class = "main" id = "main"></div>
	
</body>';