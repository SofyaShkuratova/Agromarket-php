<?php 
session_start();
include 'database/db.php';
require 'partials/header.php';

$product_id = $_GET['id'];
$user_id = $_SESSION['id_user'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id_product = $id";
    $result = mysqli_query($link, $query);
    $product = mysqli_fetch_assoc($result);
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
    <link rel="stylesheet" href="css/product.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    
    <title>Страница товара</title>
</head>
<body>
    <main>
        <h2>Страница товара</h2>
<?php        
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
            ?>
            <form class="favorite_form">
                <input type="hidden" name="id_product" value="<?php echo $product['id_product'] ?>">
                <input type="submit" name="add_favorites" value="Добавить в избранное"
                class=" button__nav cards_but">
            </form>
            <?php
        echo '</div>';
    echo '</div>';
} else {
    echo "Product not found.";
}
?>
    </main>
    <section class="commentaries">
        <h2 style="text-align:center">Оставь комментарий</h2>
        
        <div id="comment_form" class="comment_block">
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

        <h2 style="text-align:center">Комментарии пользователей</h2>
        <span  id="comment_message"></span>
        <div id="display_comment"></div>
    </section>
    <?php require 'partials/footer.php' ?>
    <script src="js/comment.js"></script>
</body>
</html>
