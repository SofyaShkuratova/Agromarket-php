<?php
    session_start();
    unset($_SESSION["id_user"]);
    unset($_SESSION["full_name"]);
    print "<script language='Javascript' type='text/javascript'>
    function reload(){ top.location = 'login.php'};
    setTimeout('reload()', 0);
    </script>";
    session_destroy();
?>