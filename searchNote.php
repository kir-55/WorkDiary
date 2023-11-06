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
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                    <select name="search_options">
                        <option value="Author">Author</option>
                        <option value="DataTime">DateTime</option>
                        <option value="Title">Title</option>
                        <option value="Tags">Tags</option>
                        <option value="Peaple">People</option>
                        <option value="Content">Content</option>
                    </select>
                    <input type="search" name="search_prompt" placeholder = "Search for..." id = "search">
                    <input type="submit" value="Search" class="button">
                </form>
                
                <?php

                    session_start();
                    echo "<script>
                        document.getElementById('username').textContent = '",$_SESSION['username'],
                    "';</script>";
                    if(isset($_SESSION["login"]) && isset($_SESSION["password"]) && isset($_POST['search_prompt']) 
                    && isset($_POST['search_options'])){
                        echo "<h2>Notes:</h2>";

                        $db_title = "users_data";
                        $db_servername = "localhost";
                        $db_username = "root";
                        $db_password = "root";
                        
                        $search_options = $_POST['search_options'];
                        $search_prompt = $_POST['search_prompt'];

                        $conn = new mysqli($db_servername, $db_username, $db_password, $db_title);

                        $sql = "SELECT * FROM Notes WHERE $search_options LIKE '$search_prompt%';";
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