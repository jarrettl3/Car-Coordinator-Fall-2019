<?php
    session_start();

    $servername = "avl.cs.unca.edu";
    $username = "jlefler";
    $password = "sql4you";


    $conn = new mysqli($servername, $username, $password);

    mysqli_select_db($conn,"jleflerDB");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $make = mysqli_real_escape_string($conn,$_POST['make']);
        $model = mysqli_real_escape_string($conn,$_POST['model']);
        $color = mysqli_real_escape_string($conn,$_POST['color']);
        $numseats = mysqli_real_escape_string($conn,$_POST['numseats']);
        $vin = mysqli_real_escape_string($conn,$_POST['vin']);
        $uid = $_SESSION['userID'];
        
        $date = date("Y-m-d");
        
        $sql = "INSERT INTO Vehicle VALUES ('$vin', '$uid', '$make', '$model', '$color', '$numseats', '$date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully! Redirecting...";
            print "<script> window.location.replace(\"profile.php\") </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
?>
<HTML lang="en_US">
    <head>
        <title>Car Coordinator | Create Account</title>
        <link rel="stylesheet" type ="text/css" href="ccstyle.css">
    </head>
    
    <body>
        <div class = "sitename">
            <h1>CAR COORDINATOR</h1>
        </div>
        <div class = "main">
            <form action = "" method = "post">
                <label>Make: </label><input type = "text" name = "make" class = "contain"/><br /><br />
                <label>Model: </label><input type = "text" name = "model" class = "contain"/><br/><br />
                <label>Color: </label><input type = "text" name = "color" class = "contain"/><br /><br />
                <label>Number of Passenger Seats: </label><input type = "text" name = "numseats" class = "contain"/><br /><br />
                <label>VIN: </label><input type = "text" name = "vin" class = "contain"/><br /><br />
                <input type = "submit" value = " Submit "/><br />
               </form>
            <a href = "profile.php">Cancel</a>
        </div>
    </body>
</HTML>