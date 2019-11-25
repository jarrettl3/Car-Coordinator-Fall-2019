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

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $newFirstName = mysqli_real_escape_string($conn,$_POST['fname']);
        $newLastName = mysqli_real_escape_string($conn,$_POST['lname']);
        $newAddress = mysqli_real_escape_string($conn, $_POST['address']);
        $newProvider = mysqli_real_escape_string($conn, $_POST['provider']);
        $newPolNum = mysqli_real_escape_string($conn, $_POST['polnum']);

        $user = $_SESSION['userID'];
        $sql = "UPDATE User
                SET Firstname = '$newFirstName', Lastname = '$newLastName', Address = '$newAddress', Insurance_Provider = '$newProvider', Policy_Number = '$newPolNum'
                WHERE User_ID = '$uid'";
        echo "<script>console.log($sql)</script>";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['fname'] = $newFirstName;
            $_SESSION['lname'] = $newLastName;
            $_SESSION['address'] = $newAddress;
            $_SESSION['insurance'] = $newProvider;
            $_SESSION['policy'] = $newPolNum;
            echo "Profile updated successfully! Redirecting...";
            print "<script> window.location.replace(\"profile.php\") </script>";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }

    

echo ' <!DOCTYPE html>
<html lang = "en">
<head>
	<title>Car Coordinator | Edit Profile</title>
    <link rel="stylesheet" type ="text/css" href="ccstyle.css">

</head>
<script>
    
</script>
<body>
	<div class = "sitename"><img src = "betterwheels2.png" alt = "Car Coordinator Logo"></div>
	<div class = "bar" style = "text-align: center"><span style = "color: powderblue;
			text-shadow: 2px 2px blue;
			border-bottom-color: coral;
			border-bottom-width: 5px;
			padding: 5px;
			padding-left: 25px;
			padding-right: 25px;">Edit Profile</span></div>
	<div class = "main" id = "main" style = "text-align: center"> 
        <span style = "padding-left: 100px;"><form action = "" method = "post">
            <label>First Name: </label><input type = "text" name = "fname" class = "contain" value = "'.$_SESSION['fname'].'"/><br>
            <label>Last Name: </label><input type = "text" name = "lname" class = "contain" value = "'.$_SESSION['lname'].'"/><br>
            <label>Address: </label><input type = "text" name = "address" value = "'.$_SESSION['address'].'"/><br>
            <label> Insurance Provider: </label><input type = "text" name = "provider" value = "'.$_SESSION['insurance'].'"/><br>
            <label>Policy Number: </label><input type = "text" name = "polnum" value = "'.$_SESSION['policy'].'"/><br><br>
            <div style = "text-align: center"><input type = "submit" value = " Save "/></div>
        </form></span>
        <div style = "text-align: center"><a href = "profile.php">Cancel</a></div>
    </div>
	
</body>';