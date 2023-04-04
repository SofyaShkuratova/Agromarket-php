<?php
session_start();
include 'database/db.php';

$errors = [];

if (empty($_POST['title'])) {
    $errors['title'] = 'Заголовок пуст';
}

if (empty($_POST['text'])) {
    $errors['text'] = 'Комментарий пуст';
}

if(isset($_SESSION['id_user'])){
    if (!empty($errors)) {
        $error = 1;
    } else {
        $error = 0;
    
        $query = "INSERT INTO `review` (`id_user`, `title_review`, `text_review`, `product_id`) VALUES ('{$_SESSION['id_user']}', '{$_POST['title']}', '{$_POST['text']}', '{$_POST['product_id']}')";
        $result = mysqli_query($link, $query) or die("Ошибка выполнения запроса" . mysqli_error($link));
    }
} else {
    $error = null;
}

echo json_encode(["error" => $error]);

?>