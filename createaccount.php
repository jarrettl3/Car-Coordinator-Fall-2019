<?php
    session_start();

    $servername = "avl.cs.unca.edu";
    $username = "jlefler";
    $password = "sql4you";


    $conn = new mysqli($servername, $username, $password);

    mysqli_select_db($conn,"jleflerDB");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $fname = mysqli_real_escape_string($conn,$_POST['fname']);
        $lname = mysqli_real_escape_string($conn,$_POST['lname']);
        $address = mysqli_real_escape_string($conn,$_POST['address']);
        $provider = mysqli_real_escape_string($conn, $_POST['provider']);
        $polnum = mysqli_real_escape_string($conn, $_POST['polnum']);
        
        $sql = "SELECT * FROM User ORDER BY User_ID";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_all($result);
        $users = json_encode($row);
        $numUsers = mysqli_num_rows($result);
        
        $i = 1;
        $toLoop = True;
        while($i <= $numUsers && $toLoop){
            if($i == $row[$i-1][0]){
                $i++;
            }else{
                $toLoop = False;
            }
        } 
        //$today = getdate();
        $date = date("Y-m-d");
        
        $sql2 = "INSERT INTO User VALUES ('$i', '$username', '$password', '$fname', '$lname', '$date', '$address', '$provider', '$polnum')";
        
        if ($conn->query($sql2) === TRUE) {
            echo "New record created successfully! Redirecting...";
            print "<script> window.location.replace(\"loginCode.php\") </script>";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
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
        <div class = "bar"></div>
        <div class = "main">
            <form action = "" method = "post">
                <label>Username: </label><input type = "text" name = "username" class = "contain"/><br /><br />
                <label>Password: </label><input type = "password" name = "password" class = "contain"/><br/><br />
                <label>First Name: </label><input type = "text" name = "fname" class = "contain"/><br /><br />
                <label>Last Name: </label><input type = "text" name = "lname" class = "contain"/><br /><br />
                <label>Address: </label><input type = "text" name = "address" class = "contain"/><br /><br />
                <label>Insurance Provider: </label><input type = "text" name = "provider" class = "contain"/><br /><br />
                <label>Policy Number: </label><input type = "text" name = "polnum" class = "contain"/><br /><br />
                <input type = "submit" value = " Submit "/><br />
               </form>
            <a href = "loginCode.php">Cancel</a>
        </div>
    </body>
</HTML>