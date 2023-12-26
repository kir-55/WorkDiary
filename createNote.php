
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
    require "addNote.html";
?>
