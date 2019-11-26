<?php
                session_start();
                ob_start();

                $servername = "avl.cs.unca.edu";
                $username = "jlefler";
                $password = "sql4you";


                $conn = new mysqli($servername, $username, $password);
                



                if($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

        
                mysqli_select_db($conn,"jleflerDB");
        
                if($_SERVER["REQUEST_METHOD"] == "POST") {

      
                    $myusername = mysqli_real_escape_string($conn,$_POST['username']);
                    $mypassword = mysqli_real_escape_string($conn,$_POST['password']); 
      
                    $sql = "SELECT User_ID FROM User WHERE username = '$myusername' and password = '$mypassword'";
                    $result = mysqli_query($conn,$sql);
                    if (!$result) {
                        //printf("Error: %s\n", mysqli_error($conn));
                        exit();
                    }
                    $uid = mysqli_fetch_row($result)[0]; //getting the User_ID associated with the username and password entered

                    $row = mysqli_fetch_array($uid,MYSQLI_ASSOC);
                    $active = $row['active'];
      
                    $count = mysqli_num_rows($result);
      
                    
                    $sql2 = "SELECT Firstname FROM User WHERE User_ID = '$uid'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_array($result2);
                    $firstname = $row2[0]; 
                    //getting the user's first name from the database as associated with the User_ID
                    
                    $sql3 = "SELECT Lastname FROM User WHERE User_ID = '$uid'";
                    $result3 = mysqli_query($conn, $sql3);
                    $row3 = mysqli_fetch_array($result3);
                    $lastname = $row3[0]; 
                    //getting the user's last name from the database as associated with the User_ID
                    
                    $sql4 = "SELECT Address FROM User WHERE User_ID = '$uid'";
                    $result4 = mysqli_query($conn, $sql4);
                    $row4 = mysqli_fetch_array($result4);
                    $address = $row4[0]; 
                    //getting the user's address from the database as associated with the User_ID
                    
                    $sql5 = "SELECT Insurance_Provider FROM User WHERE User_ID = '$uid'";
                    $result5 = mysqli_query($conn, $sql5);
                    $row5 = mysqli_fetch_array($result5);
                    $insprov = $row5[0]; 
                    //getting the user's insurance provider from the database as associated with the User_ID
                    
                    $sql6 = "SELECT Policy_Number FROM User WHERE User_ID = '$uid'";
                    $result6 = mysqli_query($conn, $sql6);
                    $row6 = mysqli_fetch_array($result6);
                    $polnum = $row6[0]; 
                    //getting the user's policy number from the database as associated with the User_ID
                    
                    $sql7 = "SELECT Username FROM User WHERE User_ID = '$uid'";
                    $result7 = mysqli_query($conn, $sql7);
                    $row7 = mysqli_fetch_array($result7);
                    $uname = $row7[0]; 
                    //getting the user's username from the database as associated with the User_ID
                    
                    $sql8 = "SELECT Date_added FROM User WHERE User_ID = '$uid'";
                    $result8 = mysqli_query($conn, $sql8);
                    $row8 = mysqli_fetch_array($result8);
                    $dateAdded = date_create($row8[0]);
                    //getting the user's date added from the database as associated with the User_ID

		
                    if($count == 1) {
                        if (headers_sent()) {
                            echo "Welcome, " . $result2. "!"; //Why isn't this showing up properly? username will echo properly but not fist_name?
                            //header("Location: www.google.com")
                            //or die("failed to connect to webpage");
                            
                        }
                        else{
                            $_SESSION['userID'] = $uid;
                            $_SESSION['fname'] = $firstname;
                            $_SESSION['lname'] = $lastname;
                            $_SESSION['address'] = $address;
                            $_SESSION['insurance'] = $insprov;
                            $_SESSION['policy'] = $polnum;
                            $_SESSION['username'] = $uname;
                            $_SESSION['dateAdded'] = date_format($dateAdded, 'm-d-Y');
                            
                            $url = $_SERVER['REQUEST_URI'];
                            $event = explode('?',$url);
                            if (count($event) > 1){
                                header("location: events.php?".$event[1]);
                                exit();
                            }else{
                                header("location: carcoordinator.html");
                                exit();
                            }
                             echo '<script> var myurl = window.location.href;
                                var eventSelect = myurl.split("?");
                                if(eventSelect.length > 1){
                                    eventSelect = eventSelect[1].split("=")[1];
                                    window.location.href = "events.php?event=" + eventSelect;
                                }else{
                                    window.location.href = "carcoordinator.html";
                                }
                                </script>';
                        }
                    }else {
                            $message = "invalid login";
                            echo "<script type='text/javascript'>alert('$message');</script>";
                        //$error = "Your Login Name or Password is invalid";
                    }
                }
            ?>

<HTML lang = "en_US">
    <head>
        <Title>Car Coordinator | Login</Title>
        <link rel="stylesheet" type ="text/css" href="ccstyle.css">
		<style>
            .main{
                text-align: center;
		      }
        </style>
    </head>

    <body>
        <div class = "sitename">
            <img src = "betterwheels2.png" alt = "Car Coordinator Logo">
        </div>
        <div class = "bar"><span></span></div>
        <div class = "main">
            <span class = "tagline" style = "display: inline-block">Go places. Together. <br></span>
            <hr><br>
            <div><form action = "" method = "post">
                  <label>Username: </label><input type = "text" name = "username" class = "contain"/><br /><br />
                  <label>Password: </label><input type = "password" name = "password" class = "contain" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
            </form>
            </div><br>
                <a href = "createaccount.php">Create an account</a>
        </div>
    </body>
</HTML>