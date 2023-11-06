<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>WorkDiary</title>
    </head>
    <body>
        <header>
            <div class="menu">
                <a href="index.php"><h1>WorkDiary</h1></a>
                <ul class="menu">
                    <li id = "username">Not logged in</li>
                    <li><a href="signIn.html">Sign in</a></li>
                    <li><a href="signUp.html">Sign up</a></li>
                </ul>
            </div>
        </header>
        <?php
            $username = $_POST['username'];
            $login = $_POST['login'];
            $password = md5($_POST['password']);

            $db_title = "users_data";
            $db_servername = "localhost";
            $db_username = "root";
            $db_password = "root";

            $conn = new mysqli($db_servername, $db_username, $db_password, $db_title);


            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT Username FROM Users WHERE Login = '$login' Or Password = '$password'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0)
                echo '<label>The account with simular data was allrady created!</label><br>
                      <label>try to:</label><br>
                      <a href="signUp.html">change something</a><label> or <laber><a href="signIn.html">sign in</a>';
            else{
                $sql = "INSERT INTO Users (Username, Login, Password)
                VALUES ('$username', '$login', '$password')";

                if (mysqli_query($conn, $sql)) {
                    $sql = "SELECT * FROM Users";
                    if($result = mysqli_query($conn, $sql)){
                        echo '<table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Username</th>
                                        <th>Login</th>
                                        <th>Password</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while ($row = $result->fetch_assoc()) {
                            $curr_id = $row["Id"];
                            $curr_username = $row["Username"];
                            $curr_login = $row["Login"];
                            $curr_password = $row["Password"]; 
                    
                            echo '<tr> 
                                    <td>'.$curr_id.'</td> 
                                    <td>'.$curr_username.'</td> 
                                    <td>'.$curr_login.'</td> 
                                    <td>'.$curr_password.'</td> 
                                </tr>';
                        }
                        echo "</tbody></table>";
                    }
                    session_start();
                    $_SESSION['login'] = $login;
                    $_SESSION['password'] = $password;
                    echo '<div class="center"><a href="index.php">Go to the main page</a></div>';
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }

            }
            
            mysqli_close($conn);
        ?>
    </body>
</html>
