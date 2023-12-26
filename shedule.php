<!DOCTYPE html>
<body>
<?php
    require 'menu.html';
    session_start();
    echo "<script>
        document.getElementById('username').textContent = '",$_SESSION['username'],
    "';</script>";

    if(isset($_SESSION["login"]) && isset($_SESSION["password"])){
        if(isset($_GET['day'])){
            echo ('
            <form>
                <input type="text" placeholder="Enter event...">
                <input type="submit">
            </form>
            ');
        }
        else{
            require 'calendar.html';
        }
            
        
    }

    
?>
</body>
</html>