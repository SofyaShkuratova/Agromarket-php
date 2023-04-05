<?php 
    session_start();
    include 'database/db.php';
    
    if(array_key_exists('id_user', $_SESSION) && array_key_exists('id_product', $_POST)){
        
        $favQuery = "SELECT id_product FROM favorites WHERE id_product={$_POST['id_product']}";
        $favResult = mysqli_query($link, $favQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));

        if($favResult->num_rows > 0) {
            echo json_encode(['flag'=>false, 'msg' => 'такой товар уже есть']);
        } else {
            echo json_encode(['flag'=>true, 'msg' => 'Товар успешно добавлен'] );
            $addQuery = "INSERT INTO `favorites` (`id_product`, `id_user`) VALUES ('{$_POST['id_product']}', '{$_SESSION['id_user']}')";
            $addResult = mysqli_query($link, $addQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));
        }
       
    }
    else{
        echo json_encode(['flag'=>false, 'msg' => 'Пользователь не авторизован']);
    }

?>