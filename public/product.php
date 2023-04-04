<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/product.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    
    <title>Страница товара</title>
</head>
<body>
<?php 
session_start();
include 'database/db.php';
require 'partials/header.php';
$product_id = $_GET['id'];
$user_id = $_SESSION['id_user'];

?>
    <main>
        <h2>Страница товара</h2>
<?php        
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id_product = $id";
    $result = mysqli_query($link, $query);
    $product = mysqli_fetch_assoc($result);
}

if ($product) {
    $image_path = "img/" . $product['id_product'] . ".png";
    echo '<div class="product" id_product='.$product_id.'>';
        echo '<div class="image">';
            echo '<img src="' . $image_path . '" alt="' . $product['title_product'] . '">';
        echo '</div>';
        echo '<div class="about">';
            echo '<h4>' . $product['title_product'] . '</h4>';
            echo '<p>' . $product['description'] . '</p>';
            echo '<h4>' . $product['price'] . ' BYN</h4>';
        echo '</div>';
    echo '</div>';
} else {
    echo "Product not found.";
}
?>

    </main>

    <section class="commentaries">
        <h2 style="text-align:center">Оставь комментарий</h2>
        
        <div class="comment_block">
            <div class="com_form">
                <div id="name-group" class="form-group">
                    <label for="comment_title">Введите заголовок комментария</label>
                    <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    placeholder="Заголовок" 
                    class="box"/>
                </div>
                
                <div id="email-group" class="form-group">
                    <label for="comment_text">Введите комментарий</label>
                <input 
                    type="text" 
                    name="text" 
                    id="comment" 
                    placeholder="Введите комментарий" 
                    class="box second"/>
                </div>

                <input 
                    type="submit" 
                    name="add_com"  
                    class="btn-success"
                    value="Отправить" />
            </div>
        </div>

        <h2 style="text-align:center">Комментарии пользователей</h2>
        <div class="row-cont">
    <?php
    
    $commentQuery = "SELECT full_name, title_review, text_review FROM review JOIN users ON review.id_user=users.id_user WHERE product_id={$product_id}";
    $commentResult = mysqli_query($link, $commentQuery) or die("Ошибка выполнения запроса " . mysqli_error($link));
    $rowCount = $commentResult->num_rows;
    
    if($rowCount > 0) {
        while($row = mysqli_fetch_assoc($commentResult)) {
        echo "<div class='row'>";
        echo "<h4>" . $row['title_review'] . "</h4>";
        echo "<p>" . $row['text_review'] .  "</p>";
        echo "<p style='margin-top:10px'>Пользователь оставивший комментарий: " .$row['full_name'] ."</p>";
        ?>
        <!-- <input type="submit" value="edit" class="edit" name="edit"> -->
        <?php
        echo "</div>";
        }
        $link->close(); 
    } else {
        echo "Комментарии товара отсутствуют";
    }

    // if($_POST['edit']) {
    //     $editQuery = "SELECT * FROM `review` WHERE product_id={$product_id}";
    //     $editResult = mysqli_query($link, $commentQuery) or die("Ошибка выполнения запроса " . mysqli_error($link));
    // }
    ?>
        </div>
    </section>
    
    <?php require 'partials/footer.php' ?>
    <script src="js/comment.js"></script>
</body>
</html>
