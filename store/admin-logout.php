
<?php
    
    session_start();
    session_destroy();
    
    echo '<meta http-equiv="refresh" content="1; url=index.php">';
    echo '<br><br>';
    echo '<center>You Are Now Logged Out! Redirecting...</center>';
    
    ?>
