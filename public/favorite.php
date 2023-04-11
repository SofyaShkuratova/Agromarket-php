
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/style.css">
    
    <title>Избранное</title>
</head>
<body>
    <?php 
session_start();
require 'partials/header.php';
    ?>
    <main>
    <h2 style="text-align:center">Ваше избранное</h2>
    <section id="products">
    <div class="product_cards">
    <?php 
    
    $link = mysqli_connect("localhost", "root", "root", "agromarket");
    
    if(isset($_SESSION['id_user'])) {
        $favQuery = "SELECT * FROM `favorites` WHERE id_user={$_SESSION['id_user']}";
        $favResult = mysqli_query($link, $favQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));
        
        $rowCount = $favResult->num_rows;

        if($rowCount > 0) {
            $sql = "SELECT title_product, image, price, description FROM products JOIN favorites ON favorites.id_product=products.id_product";
            $res = mysqli_query($link, $sql) or die("Ошибка выполнения запроса" . mysqli_error($link));

            while($row = mysqli_fetch_assoc($res)) {
                $image_path = "img/" . $row['image'] . ".png";
                echo '<div class="card">';
                echo '<img src="' . $image_path . '" alt="' . $row['title_product'] . '">';
                echo '<h4>' . $row['title_product'] . '</h4>';
                echo '<p>' . $row['description'] . '</p>';
                echo '<h4>' . $row['price'] . ' BYN</h4>'; 
                // $product = $row['id_product']; 
                echo '</div>';
            }
        }
    } else {
        echo "<h2 style='text-align:center'>Пользователь не зашел в личный кабинет</h2>";
    }
    
?>
    </div>
    </section>
    </main>
    <?php 
    require 'partials/footer.php';
    ?>
</body>
</html>

