<?php
session_start();
include 'database/db.php';
function clearString($str) {
    $str = trim($str);
    $str = strip_tags($str);
    $str = stripslashes($str);

    return $str;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/userpage.css">
    <title>Admin</title>
</head>
<body>
<header>
    <div class="nav">
        <div class="icon__nav">
            <a href="index.php"><img src="img/logo.svg" class="logo" alt="logo" width="45px"></a>
        </div>
        <div class="but__container">
            <a href="logout.php" class="p__text button__nav acent__but">
                Выйти из аккаунта
            </a>
        </div>
    </div>
</header>
<main>
    <h4 style="text-align:center">Добро пожаловать, <?= $_SESSION['full_name']?></h4>
    <h2 style="text-align:center">Панель администратора</h2>
    <div class="user_room">
        <div class="name_user col">
            <b>Ваше имя:</b> <?= $_SESSION['full_name']?>
            <br><b>Список пользователей:</b>
            <?php

            $usersListQuery = "SELECT * FROM users";
            $usersListResult = mysqli_query($link, $usersListQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));

            if($usersListResult = $link->query($usersListQuery)){
                $rowsCount = $usersListResult->num_rows; // количество полученных строк
                echo "<p>Получено объектов: $rowsCount</p>";
                echo "<table style='border-spacing: 24px'><tr><th>ID</th><th>Имя пользователя</th><th>ID категории</th></tr>";
                foreach($usersListResult as $row){
                    echo "<tr>";
                    echo "<td>" . $row["id_user"] . "</td>";
                    echo "<td>" . $row["full_name"] . "</td>";
                    echo "<td>" . $row["login"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                $usersListResult->free();
            } else{
                echo "Ошибка: " . $link->error;
            }


            if(isset($_POST["del-user"])) {
                //delete User
                $delUserError = '';
                $id_del = $_POST["del-user"];

                $delUserQuery = "DELETE FROM `users` WHERE id_user = {$id_del}";
                $delUserResult = mysqli_query($link, $delUserQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));

                print "<script language='Javascript' type='text/javascript'>
                        function reload(){top.location = 'admin.php'};
                        reload();
                        </script>";
            }
            ?>
            Удаление пользователя:
            <form action="admin.php" method="post">
                <input type="text" name="del-user" id="" placeholder="Введите id_user">
                <span class="error"><?=@$delUserError;?></span>
                <input type="hidden" name="delete-user" value="">
                <input type="submit" name="deleteUser" value="Удалить имя">
            </form>
        </div>
        <div class="name_user col">
            <br><b>Список товаров:</b>
            <?php
            $productsListQuery = "SELECT * FROM products";
            $productsListResult = mysqli_query($link, $usersListQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));

            if($productsListResult = $link->query($productsListQuery)){
                $rowsCount = $productsListResult->num_rows; // количество полученных строк
                echo "<p>Получено объектов: $rowsCount</p>";
                echo "<table style='border-spacing: 24px'><tr><th>Id</th><th>Наименование товара</th><th>ID категории</th><th>Стоимость</th></tr>";
                foreach($productsListResult as $row){
                    echo "<tr>";
                    echo "<td>" . $row["id_product"] . "</td>";
                    echo "<td>" . $row["title_product"] . "</td>";
                    echo "<td>" . $row["id_category"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                $productsListResult->free();
            } else{
                echo "Ошибка: " . $link->error;
            }

            if(isset($_POST["del-tov"])) {
                //delete User
                $delTovError = '';
                $id_del = $_POST["del-tov"];

                $delTovQuery = "DELETE FROM `products` WHERE id_product = {$id_del}";
                $delTovResult = mysqli_query($link, $delTovQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));

                print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location = 'admin.php'};
                    reload();
                    </script>";

            }
            ?>
            Удаление товара:
            <form action="admin.php" method="post">
                <input type="text" name="del-tov" id="" placeholder="Введите id_product">
                <span class="error"><?=@$delTovError;?></span>
                <input type="hidden" name="delete-tovar" value="">
                <input type="submit" name="deleteTovar" value="Удалить товар">
            </form>
        </div>
        <div class="name_user col">
            <br><b>Список категорий:</b>
            <?php
            $categoryListQuery = "SELECT * FROM categories";
            $categoryListResult = mysqli_query($link, $categoryListQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));

            if($categoryListResult = $link->query($categoryListQuery)){
                $rowsCount = $categoryListResult->num_rows; // количество полученных строк
                echo "<p>Получено объектов: $rowsCount</p>";
                echo "<table style='border-spacing: 24px'><tr><th>Id</th><th>Наименование категории</th></tr>";
                foreach($categoryListResult as $row){
                    echo "<tr>";
                    echo "<td>" . $row["id_category"] . "</td>";
                    echo "<td>" . $row["title_category"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                $productsListResult->free();
            } else{
                echo "Ошибка: " . $link->error;
            }

            if(isset($_POST["del-cat"])) {
                //delete Category
                $delCAtError = '';
                $id_del = $_POST["del-cat"];

                $delCatQuery = "DELETE FROM `categories` WHERE id_category = {$id_del}";
                $delCatResult = mysqli_query($link, $delCatQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));

                print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location = 'admin.php'};
                    reload();
                    </script>";

            }
            ?>
            Удаление категории:
            <form action="admin.php" method="post">
                <input type="text" name="del-cat" id="" placeholder="Введите id_category">
                <span class="error"><?=@$delCatError;?></span>
                <input type="hidden" name="delete-category" value="">
                <input type="submit" name="deleteCategory" value="Удалить товар">
            </form>
        </div>
    </div>
    <div class="user_room">
        <div class="name_user col">
            <br><b>Добавить товар</b>
            <?php
            
            if(isset($_POST['addTov'])) {
                if(isset($_POST['name-tovar']) && isset($_POST['id-cat']) && isset($_POST['id-img']) && isset($_POST['costTov']) && isset($_POST['descr-tov'])) {
                //Назнание
                $nameTovarerror = '';
                $nameTov = $_POST['name-tovar'];
                clearString($nameTov);

                if($nameTov == ''){
                    $nameTovarerror .= "Заполните поле.";
                }

                //Категория
                $idCategoryerror = '';
                $idCategoryTov = $_POST['id-cat'];
                clearString($idCategoryTov);

                if($idCategoryTov == ''){
                    $idCategoryerror .= "Заполните поле.";
                } else {
                    $queryTovCat = "SELECT id_category FROM categories WHERE id_category='$idCategoryTov'";
                    $resultTovCat = mysqli_query($link, $queryTovCat) or die ("Ошибка выполнения запроса1" .mysqli_error($link));
                    
                    if($resultTovCat) {
                        $row = mysqli_fetch_row($resultTovCat);
                        if(empty($row[0])) $idCategoryerror .="Данной категории не существует";
                    }
                }

                //Изображение
                $idImgError = '';
                $idImageTov = $_POST['id-img'];
                clearString($idImageTov);

                if($idImageTov == '') {
                    $idImgError .= "Заполните поле. ";
                } else {
                    $queryTovIMG = "SELECT `image` FROM products WHERE `image`='$idImageTov'";
                    $resultTovIMG = mysqli_query($link, $queryTovIMG) or die ("Ошибка выполнения запроса1" .mysqli_error($link));

                    if($resultTovIMG) {
                        $row = mysqli_fetch_row($resultTovIMG);
                        if(!empty($row[0])) $idImgError .="Данная фотография уже используется";
                    }
                }

                //Стоимость
                $costTovError = '';
                $costTov = $_POST['costTov'];
                clearString($costTov);

                if($costTov == 0) {
                    $costTovError .= "Заполните поле. ";
                }

                //Описание
                $descrTovError = '';
                $descrTov = $_POST['descr-tov'];
                clearString($descrTov);

                if($descrTov == '') {
                    $descrTovError .= "Заполните поле. ";
                }

                if($nameTovarerror.$idCategoryerror.$idImgError.$costTovError.$descrTovError == '') {
                    $query="INSERT INTO `products` (`title_product`, `id_category`, `image`, `price`, `description`) VALUES ('$nameTov', '$idCategoryTov', '$idImageTov', '$costTov', '$descrTov')";
                    $result = mysqli_query($link, $query) or die("Ошибка 5 " .mysqli_error($link));
                    if($result) 
                    {
                        mysqli_close($link);
                        print "<script language='Javascript' type='text/javascript'>
                        alert('Вы успешно добавили товар'); 
                        function reload(){top.location = 'admin.php'};
                        reload();
                        </script>";
                    } else {
                        print "<script language='Javascript' type='text/javascript'>
                        alert('Вы не добавили товар');
                        </script>";
                    }
                }
                
                } else {
                    printLog(false);
                }
            }
            ?>

            <br>Добавление товара:
            <form action="admin.php" method="post">
               
                <br>Наименование товара
                <input type="text" name="name-tovar" id="" placeholder="Наименование товара">
                <span class="error"><?=@$nameTovarerror;?></span>
                <br>ID категории
                <input type="text" name="id-cat" id="" placeholder="ID категории">
                <span class="error"><?=@$idCategoryerror;?></span>
                <br>ID изображения
                <input type="number" name="id-img" id="" placeholder="ID изображения">
                <span class="error"><?=@$idImgError;?></span>
                <br>Стоимость товара
                <input type="number" name="costTov" id="" placeholder="Стоимость товара">
                <span class="error"><?=@$costTovError;?></span>
                <br>Описание товара
                <input type="text" name="descr-tov" id="" placeholder="Описание товара">
                <span class="error"><?=@$descrTovError;?></span>

                <input type="hidden" name="add-tovar" value="5">
                <input type="submit" name="addTov" value="Добавить товар">
            </form>
        </div>
        <div class="name_user col">
        <br><b>Добавить категорию</b>
        <?php
            if(isset($_POST['add-category'])) {
                if(isset($_POST['name-tovar'])) {
                    $nameCAtegError = '';
                    $nameCategoryadd = $_POST['add-category'];
                    clearString($nameCategoryadd);

                    if($nameCategoryadd == '') {
                        $nameCAtegError .= "Заполните поле. ";
                    }

                    if($nameCAtegError == '') {
                        $nameCategory = $_POST['name-tovar'];
                        include 'database/db.php';
                        $query="INSERT INTO `categories` (`title_category`) VALUES ('$nameCategory')";
                        $result = mysqli_query($link, $query) or die("Ошибка 5 " .mysqli_error($link));
                            if($result) 
                            {
                                mysqli_close($link);
                                print "<script language='Javascript' type='text/javascript'>
                                alert('Вы успешно добавили категорию'); 
                                function reload(){top.location = 'admin.php'};
                                reload();
                                </script>";
                            } else {
                                print "<script language='Javascript' type='text/javascript'>
                                alert('Вы не добавили товар');
                                </script>";
                            }
                    }


                }
            }
        ?>
        <br>Добавление категории:
            <form action="admin.php" method="post">
               
                <br>Наименование категории
                <input type="text" name="name-tovar" id="" placeholder="Наименование товара">
                <span class="error"><?=@$nameCAtegError;?></span>

                <input type="hidden" name="add-category" value="5">
                <input type="submit" name="addCat" value="Добавить товар">
            </form>
        </div>
    </div>
</main>
</body>
</html>