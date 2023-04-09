<?php
session_start();
include 'database/db.php';

if(empty($_POST['product_id'])) {
    echo "Нету id товара";
} else {
    $product_id = $_POST['comment_id'];

    $commentQuery = "SELECT name_user, title_review, text_review FROM review WHERE id_product={$_POST['product_id']}";
    $commentResult = mysqli_query($link, $commentQuery) or die("Ошибка выполнения запроса " . mysqli_error($link));
    $rowCount = $commentResult->num_rows;
}


if($rowCount > 0) {
    // echo "Cюда тоже";
    while($row = mysqli_fetch_assoc($commentResult)) {
    echo "<div class='row'>";
    echo "<h4>" . $row['title_review'] . "</h4>";
    echo "<p>" . $row['text_review'] .  "</p>";
    echo "<p style='margin-top:10px'>Пользователь: " .$row['name_user'] ."</p>";
    echo "</div>";
    }
    $link->close(); 
} else {
    echo "Комментарии товара отсутствуют";
}

?>
