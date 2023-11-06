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

        <main>
            <div class="center">
                <p id="hint">Sign in to have access to create and view notes!</p>
                <div id ="buttons">
                    <button id = "create_note" onclick="location.href='createNote.php'" type="button">Create note</button>
                    <button id = "search_note" onclick="location.href='searchNote.php'" type="button">Search for note</button>
                </div>
                <?php
                    session_start();
                    if(isset($_POST) && isset($_POST["login"]) && isset($_POST["password"])){
                        $login= $_POST['login'];
                        $_SESSION["login"] = $login;
                        $password = md5($_POST['password']);
                        $_SESSION["password"] = $password;
                    }else if(isset($_SESSION["login"]) && isset($_SESSION["password"])){
                        $login = $_SESSION["login"];
                        $password = $_SESSION["password"];
                    }
                    else{
                        unset($_SESSION["login"]);
                        unset($_SESSION["password"]);
                        unset($_SESSION["username"]);
                    }
                    
                    if (isset($login) && isset($password))  {
                        $db_title = "users_data";
                        $db_servername = "localhost";
                        $db_username = "root";
                        $db_password = "root";

                        $conn = new mysqli($db_servername, $db_username, $db_password, $db_title);
                        if ($conn->connect_error) {
                            die("<p>Connection failed: " . $conn->connect_error . "</p>");
                        }

                        $sql = "SELECT Username FROM Users WHERE Login = '$login' AND Password = '$password'";
                        $result = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($result) > 0){
                            $row = mysqli_fetch_assoc($result); 
                            echo "<label>You are successfully logged in as ", $row['Username'], "</label>";
                            echo "<script>
                            document.getElementById('username').textContent = '",$row['Username'],"';
                            document.getElementById('create_note').style.display = 'block'; 
                            document.getElementById('search_note').style.display = 'block'; 
                            document.getElementById('hint').style.display = 'none'; 
                            </script>";
                            $_SESSION['username'] = $row['Username'];
                        }  
                        else{
                            unset($_SESSION["login"]);
                            unset($_SESSION["password"]);
                            unset($_SESSION["username"]);
                            echo '<label>Our database does not contain your username :/</label><br>
                                    <label>try to:</label><br><a href="signUp.html">sign up</a><br><br>';
                            echo "<script>
                            document.getElementById('username').textContent = 'Not logged in';
                            document.getElementById('hint').style.display = 'none'; 
                            document.getElementById('create_note').style.display = 'none';
                            document.getElementById('search_note').style.display = 'none'; 
                            </script>";
                        }   
                    }
                ?>
                
                <?php
                    if(isset($_SESSION["login"]) && isset($_SESSION["password"])){
                        echo "<h2>Notes:</h2>";

                        $db_title = "users_data";
                        $db_servername = "localhost";
                        $db_username = "root";
                        $db_password = "root";

                        $sql = "SELECT * FROM Notes ORDER BY  Id DESC;";
                        if ($result = mysqli_query($conn, $sql)) {
                            while ($row = $result->fetch_assoc()) {
                                $curr_id = $row["Id"];
                                $curr_username = $row["Author"];
                                $curr_datetime = $row["DataTime"];
                                $curr_title = $row["Title"];
                                $curr_tags = $row["Tags"];
                                $curr_people = $row["Peaple"];
                                $curr_content = $row["Content"];

                                echo "
                                <div class = \"note\">
                                    <label>Author: $curr_username</label><br>
                                    <label>DateTime: $curr_datetime</label><br>
                                    <label>Title: $curr_title</label><br>
                                    <label>Tags: $curr_tags</label><br>
                                    <label>People: $curr_people</label><br>
                                    <p>Content: $curr_content</p>
                                </div>";
                            }
                            echo "</tbody></table>";
                        }

                        mysqli_close($conn);
                    }
                    
                ?>

            </div>
        </main>
    </body>
</html>