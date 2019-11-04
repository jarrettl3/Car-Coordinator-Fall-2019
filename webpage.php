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

    $_SESSION['status'] = "neutral";

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

    $sql4 = "SELECT User_ID, Firstname, Lastname, Username FROM User
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
    

/**/

//echo ' '
;