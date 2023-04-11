<?php
session_start();
include 'database/db.php';

$user_id = $_SESSION['id_user'];


if(isset($_POST['go-login'])) {
    //login
    $loginError = '';
    $newlogin = $_POST["login"];

    $query = "SELECT * FROM users WHERE login = '{$newlogin}'";
    $result = mysqli_query($link, $query) or die ("Ошибка выполнения запроса1" .mysqli_error($link));
    $rows = mysqli_num_rows($result);
    
    if(!preg_match('/^\w{5,31}$/u', $newlogin)) {
        $loginError .= "Не соответствует требованиям";
    } else {
        
        if($rows > 0){
            $row = mysqli_fetch_row($result);
            if(!empty($row[0])) $loginError .="Данный логин занят";
        } else {
            $newloginQuery = "UPDATE users SET login ='{$newlogin}' WHERE id_user={$user_id}";
            
            if (mysqli_query($link, $newloginQuery)) {
                $_SESSION["login"] = $newlogin;
                print "<script language='Javascript' type='text/javascript'>
                        function reload(){top.location = 'userpage.php'};
                        reload();
                        </script>";
                } else {
                    echo "Error updating login: " . mysqli_error($link);
            }
        }
        
    }
}

if(isset($_POST["phone"])) {
    //phone
    $phoneError = '';
    $newphone = $_POST["phone"];

    $newphoneQuery = "UPDATE users SET phone='$newphone' WHERE id_user='$user_id'";
    if(!preg_match('/^[+]\s?375\s?-?\(?[\d]{2}\)?\s?-?[\d]{2}\s?-?[\d]{2}\s?-?[\d]{3}\s?$/', $newphone)) {
        $phoneError .= "Не соответствует требованиям";
    } else {
        if (mysqli_query($link, $newphoneQuery)) {

            $_SESSION["phone"] = $newphone;
            print "<script language='Javascript' type='text/javascript'>
                        function reload(){top.location = 'userpage.php'};
                        reload();
                        </script>";
        } else {
            echo "Error updating login: " . mysqli_error($link);
        }
    }
}

if(isset($_POST["name"])) {
    //name
    $nameError = '';
    $newname = $_POST["name"];

    $newnameQuery = "UPDATE users SET full_name='$newname' WHERE id_user='$user_id'";
    if(!preg_match('/^(\w{2,}+)\s(\w{2,}+)\s(\w{2,}+)\s?$/ui', $newname)) {
        $nameError .= "Не соответствует требованиям";
    } else {
        if (mysqli_query($link, $newnameQuery)) {

            $_SESSION['full_name'] = $newname;
            print "<script language='Javascript' type='text/javascript'>
                        function reload(){top.location = 'userpage.php'};
                        reload();
                        </script>";
        } else {
            echo "Error updating name: " . mysqli_error($link);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/userpage.css">
    <title>Личный кабинет</title>
</head>
<body>
<div class="pre__header">
</div>
<header>
    <div class="nav">
        <div class="icon__nav">
            <a href="index.php"><img src="img/logo.svg" class="logo" alt="logo" width="45px"></a>
        </div>
        
        <div class="but__container">
            <a href="favorite.php" class="p__text button__nav">
                <svg class="svg-icon" width="19" height="17" viewBox="0 0 19 17" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.2516 1.4842C16.7827 1.01343 16.226 0.640034 15.6133 0.385368C15.0005 0.130701 14.3439 -0.00024965 13.6807 3.57305e-07C13.0176 0.000250364 12.361 0.131696 11.7485 0.386825C11.1359 0.641953 10.5795 1.01576 10.1109 1.48689L9.4993 2.10844L8.89276 1.48824L8.88882 1.48428C8.42013 1.01373 7.86371 0.64046 7.25134 0.385797C6.63897 0.131134 5.98263 6.03124e-05 5.31981 6.03124e-05C4.65698 6.03124e-05 4.00064 0.131134 3.38827 0.385797C2.7759 0.64046 2.21948 1.01373 1.7508 1.48428L1.47832 1.75784C0.531768 2.70816 0 3.99708 0 5.34103C0 6.68499 0.531768 7.9739 1.47832 8.92422L8.66969 16.1441L9.4818 16.9984L9.50116 16.9789L9.52218 17L10.2831 16.194L17.5241 8.9241C18.4692 7.97302 19 6.6844 19 5.34091C19 3.99743 18.4692 2.7088 17.5241 1.75772L17.2516 1.4842ZM16.6316 8.02832L9.50116 15.1873L2.37051 8.02832C1.6606 7.31558 1.26178 6.3489 1.26178 5.34093C1.26178 4.33297 1.6606 3.36629 2.37051 2.65355L2.64303 2.37998C3.3526 1.6676 4.31487 1.26722 5.31835 1.26684C6.32182 1.26646 7.28439 1.66611 7.99449 2.37797L9.49658 3.91351L11.0058 2.37998C11.3573 2.02707 11.7746 1.74712 12.2339 1.55612C12.6932 1.36512 13.1855 1.26682 13.6826 1.26682C14.1797 1.26682 14.6719 1.36512 15.1312 1.55612C15.5905 1.74712 16.0078 2.02707 16.3593 2.37998L16.6318 2.65351C17.3406 3.36683 17.7387 4.33332 17.7387 5.34095C17.7387 6.34857 17.3405 7.31503 16.6316 8.02832Z"/>
                </svg>
                Избранное
            </a>
        
            <a href="cart.php" class="p__text button__nav">
                <svg class="svg-icon" width="17" height="18" viewBox="0 0 17 18"  xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_274_661)">
                    <path class="path" d="M5.11683 2.84407V3.98114H15.919V6.23201L14.6576 10.235H4.75908L3.33773 0H0V1.13707H2.34763L3.76897 11.3721H15.4915L17.0561 6.40691V2.84407H5.11683Z" />
                    <path d="M5.72043 12.52C5.1175 12.5207 4.53947 12.7605 4.11313 13.1869C3.68679 13.6132 3.44698 14.1912 3.44629 14.7942C3.44629 15.3973 3.68589 15.9757 4.11237 16.4022C4.53886 16.8287 5.11729 17.0683 5.72043 17.0683C6.32358 17.0683 6.90201 16.8287 7.3285 16.4022C7.75498 15.9757 7.99458 15.3973 7.99458 14.7942C7.9939 14.1912 7.75409 13.6132 7.32775 13.1868C6.90141 12.7605 6.32337 12.5207 5.72043 12.52ZM5.72043 15.9312C5.49554 15.9312 5.2757 15.8645 5.08871 15.7396C4.90172 15.6147 4.75598 15.4371 4.66992 15.2293C4.58385 15.0215 4.56134 14.7929 4.60521 14.5723C4.64908 14.3518 4.75738 14.1492 4.9164 13.9901C5.07543 13.8311 5.27803 13.7228 5.4986 13.6789C5.71917 13.6351 5.9478 13.6576 6.15557 13.7436C6.36335 13.8297 6.54093 13.9755 6.66588 14.1624C6.79082 14.3494 6.85751 14.5693 6.85751 14.7942C6.85715 15.0956 6.73724 15.3846 6.52407 15.5978C6.31091 15.811 6.02189 15.9309 5.72043 15.9312Z" />
                    <path d="M13.6799 12.52C13.077 12.5207 12.4989 12.7605 12.0726 13.1869C11.6463 13.6132 11.4064 14.1912 11.4058 14.7942C11.4058 15.3973 11.6454 15.9757 12.0718 16.4022C12.4983 16.8287 13.0768 17.0683 13.6799 17.0683C14.283 17.0683 14.8615 16.8287 15.288 16.4022C15.7145 15.9757 15.9541 15.3973 15.9541 14.7942C15.9534 14.1912 15.7136 13.6132 15.2872 13.1868C14.8609 12.7605 14.2828 12.5207 13.6799 12.52ZM13.6799 15.9312C13.455 15.9312 13.2352 15.8645 13.0482 15.7396C12.8612 15.6147 12.7155 15.4371 12.6294 15.2293C12.5433 15.0215 12.5208 14.7929 12.5647 14.5723C12.6086 14.3518 12.7169 14.1492 12.8759 13.9901C13.0349 13.8311 13.2375 13.7228 13.4581 13.6789C13.6786 13.6351 13.9073 13.6576 14.115 13.7436C14.3228 13.8297 14.5004 13.9755 14.6253 14.1624C14.7503 14.3494 14.817 14.5693 14.817 14.7942C14.8166 15.0956 14.6967 15.3846 14.4835 15.5978C14.2704 15.811 13.9814 15.9309 13.6799 15.9312Z" />
                    </g>
                    <defs>
                        <clipPath id="clip0_274_661">
                            <rect width="17" height="18" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
                Корзина
            </a>

            <a href="logout.php" class="p__text button__nav acent__but">
                Выйти из аккаунта
            </a>
        </div>
    </div>
</header>
<main>
    <h4 style="text-align:center">Добро пожаловать, <?= $_SESSION['full_name']?></h4>
    <h2 style="text-align:center">Личный кабинет</h2>

    <div class="user_room">
        <div class="name_user col">
            <b>Ваше имя:</b> <?= $_SESSION['full_name']?>
            <br>Введите новое имя:<br>
            <form action="userpage.php" method="post">
                <input type="text" name="name" id="">
                <span class="error"><?=@$nameError;?></span>
                <input type="hidden" name="go-name" value="5">
                <input type="submit" name="changename" value="Изменить имя">
            </form>
        </div>
        <div class="login_user col">
            <b>Ваш логин:</b> <?= $_SESSION['login']?>
            <br>Введите новый логин:<br>
            <form action="userpage.php" method="post">
                <input type="text" name="login" id="">
                <span class="error"><?=@$loginError;?></span>
                <input type="hidden" name="go-login" value="5">
                <input type="submit" name="changelogin" value="Изменить логин">
            </form>
        </div>
        <div class="phone_user col">
            <b>Ваш номер телефона:</b> <?= $_SESSION['phone'] ?>
            <br>Введите новый номер телефона:<br>
            <form action="userpage.php" method="post">
                <input type="text" name="phone" id="">
                <span class="error"><?=@$phoneError;?></span>
                <input type="hidden" name="go-phone" value="5">
                <input type="submit" name="changephone" value="Изменить номер">
            </form>
        </div>
    </div>
</main>
</body>
</html>