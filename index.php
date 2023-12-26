<?php
session_start();
require 'menu.html';
?>

<!DOCTYPE html>
    <body>
        <main>
            <div class="center">
                <p id="hint">Sign in to have access to create and view notes!</p>
                <div id ="buttons">
                    <button id = "create_note" onclick="location.href='createNote.php'" type="button">Create note</button>
                    <button id = "search_note" onclick="location.href='searchNote.php'" type="button">Search for note</button>
                    <button id = "go_schedule" onclick="location.href='shedule.php'" type="button">Go to shedule</button>
                </div>
                <?php
                    
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
                        $db_password = "password";
                        $conn = new mysqli($db_servername, $db_username, $db_password);
                        
                        $sqlFile = 'sql.sql';
                        $sql = file_get_contents($sqlFile);

                        // Execute the SQL statements
                        if ($conn->multi_query($sql)) {
                            $conn = new mysqli($db_servername, $db_username, $db_password, $db_title);
                        } else {
                            die("Error creating database and tables: "  . $conn->connect_error);
                        }

                        
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
                            document.getElementById('go_schedule').style.display = 'block';
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
                            document.getElementById('go_schedule').style.display = 'none';
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
                        $db_password = "password";


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