
<?php
    require 'menu.html';
    session_start();
    echo "<script>
        document.getElementById('username').textContent = '",$_SESSION['username'],
    "';</script>";

    if(isset($_POST) && isset($_POST['username']) && isset($_POST['datetime']) && isset($_POST['title'])
    && isset($_POST['tags']) && isset($_POST['people']) && isset($_POST['content'])){
        $username = $_POST['username'];
        $date_time = $_POST['datetime'];
        $title = $_POST['title'];
        $tags = $_POST['tags'];
        $people = $_POST['people'];
        $content = $_POST['content'];
        //echo '<label>test</label>';

        $db_title = "users_data";
        $db_servername = "localhost";
        $db_username = "root";
        $db_password = "password";
    
        $conn = new mysqli($db_servername, $db_username, $db_password, $db_title);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT Id FROM Notes WHERE Title = '$title'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0)
            echo '<label>The note with simular title was allrady created!</label>';
        else{
            $sql = "INSERT INTO Notes (Author, DataTime, Title, Tags, Peaple, Content)
            VALUES ('$username', '$date_time', '$title', '$tags', '$people', '$content')";
            if(mysqli_query($conn, $sql)){
                echo "<label>success!</label>";
                unset($_POST['datetime']);
                unset($_POST['title']);
                unset($_POST['tags']);
                unset($_POST['people']);
                unset($_POST['content']);
            }
        }
    }
?>
<!DOCTYPE html>
    <body>
        <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <fieldset>
                <legend>Note</legend>
                <label for="username">Author:</label><br>
                <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" readonly><br>

                <label for="datetime">Date/Time:</label><br>
                <input type="text" id="datetime" name="datetime" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly><br>

                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title" value="Note#<?php echo date('m-d'); ?>" placeholder="Enter Title..." require><br>

                <label for="tags">Tags and related words:</label><br>
                <input type="text" id="tags" name="tags" require><br>

                <label for="people">Related people:</label><br>
                <input type="text" id="people" name="people" require><br>

                <label for="content">Content:</label><br>
                <textarea id="content" name="content" rows="8" cols="125"></textarea><br><br>

                <input type="submit" value="Submit" class="button">
            </fieldset>
        </form>
    </body>
</html>