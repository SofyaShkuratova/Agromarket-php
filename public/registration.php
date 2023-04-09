<?php
session_start();
// var_dump($password + $login);
function clearString($str) {
    $str = trim($str);
    $str = strip_tags($str);
    $str = stripslashes($str);

    return $str;
}

    if (isset($_POST['go-reg'])) {
    
        //ФИО
        $nameError = '';
        $name = $_POST["name"];
        // clearString($name);
    
        if($name == '') {
            echo $nameError .= "Заполните поле. ";
        } else if(!preg_match('/^(\w{2,}+)\s(\w{2,}+)\s(\w{2,}+)\s?$/ui', $name)) {
            echo $nameError .= "Введенное имя не соответствует требованиям";
        }
    
    
    
        //ЛОГИН
    
        $loginError = '';
            $login = $_POST["login"];
            clearString($login);
    
            if ($login == '') {
                $loginError .= "Заполните поле. ";
    
            } else if(!preg_match('/^\w{5,31}$/u', $login)) {
                $loginError .= "Введенный логин не соответствует требованиям";
            } else {
                include 'database/db.php';
                $query = "SELECT id_user FROM users WHERE login='$login'";
                $result = mysqli_query($link, $query) or die ("Ошибка выполнения запроса1" .mysqli_error($link));
                if($result) {
                    $row = mysqli_fetch_row($result);
                    if(!empty($row[0])) $loginError .="Данный логин занят";
                }
        }
    
        //FIRST PASSWORD
    
        $firstPasswordError = '';
            $firstPassword = $_POST["first-password"]; 
            // clearString($firstPassword);
    
            if($firstPassword == '') {
                $firstPasswordError .= "Заполните поле";
            } else if(!preg_match('/(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z]).{8,}$/ui', $firstPassword)) {
                $firstPasswordError .= "Пароль должен содержать от 8 символов, прописные, заглавные, цифры, спецсимволы";
            }
    
        //SECOND PASSWORD
        $secondPasswordError = '';
            $secondPassword = $_POST["second-password"];
            // clearString($secondPassword);
    
            if($secondPassword == '') {
                $secondPasswordError .= "Заполните поле";
            } else if($secondPassword != $firstPassword) {
                $secondPasswordError .= "Пароли не совпадают";
            }
    
        //PHONE
        $phoneError = '';
            $phone = $_POST["phone"]; 
            // clearString($phone);
    
            if($phone == '' && empty($phone)) {
                $phoneError .= "Заполните поле";
            } else if(!preg_match('/^[+]\s?375\s?-?\(?[\d]{2}\)?\s?-?[\d]{2}\s?-?[\d]{2}\s?-?[\d]{3}\s?$/', $phone)) {
                $phoneError .= "Введенный телефон не соответствует требованиям";
            }
    
        
        
    }
    
    //CAPTCHA 
    if(checkCaptcha() == false) $captchaError = "Неверно введены символы";
    function checkCaptcha() {
        if ($_POST['captcha'] == $_SESSION['captcha']) {
            return true;
        } else {
            return false;
        }
    }
    
    
    //БД
    if($nameError.$loginError.$firstPasswordError.$secondPasswordError.$phoneError.$captchaError == '') 
    {
    // добавляем данные в БД и проходим регистрацию
    
        $password = $firstPassword;
        $salt = mt_rand(100, 999);
        $password = md5(md5($password).$salt);
        printLog(true);
        $rez = mysqli_query($link, $query);
        mysqli_close($link);
        include 'database/db.php';
        $query="INSERT INTO users (full_name, login, phone, password, id_role, salt) VALUES ('$name', '$login','$phone','$password', 0, $salt)";
        $result = mysqli_query($link, $query) or die("Ошибка 5 " .mysqli_error($link));
            
            if($result) 
            {
                include 'database/db.php';
                $query = "SELECT * FROM users WHERE login='$login'";
                $rez = mysqli_query($link, $query);
                if($rez)
                {
                    $row = mysqli_fetch_assoc($rez);
                    $_SESSION['name']=$row['name'];
                    mysqli_close($link);
    
                    // выводим сообщение об успешной регистрации и перезагружаем страницу
                    print "<script language='Javascript' type='text/javascript'>
                    alert('Вы успешно зарегистрировались! Спасибо!'); 
                    function reload(){top.location = 'login.php'};
                    reload();
                    </script>";
                } else {
                    print "<script language='Javascript' type='text/javascript'>
                    alert('Вы не были зарегистрированы.');
                    </script>";
                }
    
                }
            } else {
                printLog(false);
            }
    
    function printLog($success) {
        $currentDate = date("d.m.y");
        $currentTime = date("H:i:s");
        $file = fopen('logs.txt', 'a+');
        if($success) {
            $log = "Регистрация прошла успешно (дата: $currentDate, время: $currentTime) \n";
        } else {
            $log = "Регистрация заверешна ошибкой (дата: $currentDate, время: $currentTime) \n";
        }
    
        fwrite($file, $log);
        fclose($file);
    }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'partials/header.php' ?>
    
    <section class="main-section">
    <div class="container">
        <h2>Регистрация</h2>
        <div class="form-wrapper">
            <form action="registration.php" method="POST" class="form">
                <div class="box-input">
                    <label>Введите ФИО</label>
                    <input type="text" name="name" class="input" value="<?=@$name;?>" required placeholder="Шкуратова Софья Витальевна">
                    <span class="error"><?=@$nameError;?></span>
                </div>

                <div class="box-input">
                    <label >Введите логин</label>
                    <input type="text" name="login" class="input" value="<?=@$login;?>" required placeholder="iam_sonau">
                    <span class="error"><?=@$loginError;?></span>
                </div>

                <div class="box-input">
                    <label >Придумайте пароль</label>
                    <input type="password" name="first-password" class="input"  required placeholder="Soepub101">
                    <span class="error" style="color: red"><?=@$firstPasswordError;?></span>
                </div>

                <div class="box-input">
                    <label >Повторите пароль</label>
                    <input type="password" name="second-password" class="input"  required placeholder="Soepub101">
                    <span class="error"><?=@$secondPasswordError;?></span>
                </div>

                <div class="box-input">
                    <label >Введите номер телефона</label>
                    <input type="text" name="phone" class="input" value="<?=@$phone;?>" required placeholder="+375447924677">
                    <span class="error"><?=@$phoneError;?></span>
                </div>

                <div class="captcha">
                    <div class="captcha-img-btn">
                        <img id="captcha-image" class="captcha__image" src="captcha/captcha.php" width="200" alt="captcha">
                        <a href="javascript:void(0);" onclick="document.getElementById('captcha-image').src='captcha/captcha.php?rid='+ Math.random();">Обновить капчу</a>
                    </div>
                    <div class="box-input captcha-input">
                        <input type="text" name="captcha" class="input" placeholder="Код на картинке" required>
                        
                        <!-- <span class="error"><?=@$captchaError;?></span> -->
                    </div>
                </div> 

                <input type="hidden" name="go-reg" value="5">
                <input type="submit" name="submit-reg" value="Зарегестрироваться" class="button-submit">
            </form>
            <!-- <form action="login.php" method="post" class="reg-form"> -->
                Уже есть свой аккаунт?<a href='login.php'>Войти</a>
            <!-- </form> -->
        </div>
    </div>
</section>
<?php require 'partials/footer.php' ?>
</body>
</html>