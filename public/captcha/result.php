<?php

if(isset($_POST['captcha'])) 
{
    $code = $_POST['captcha'];

    session_start();

    if(isset($_SESSION['captcha']) && strtoupper($_SESSION['captcha']) == strtoupper($code) )
    {
        echo "Правильно!";
    } else {
        echo "Не Правильно!";
    }
    
    unset($_SESSION['captcha']);
    exit();
}
?>