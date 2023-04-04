
<?php 
session_start();
include 'database/db.php';

$cardQuery = "SELECT * FROM products";
$cardResult = mysqli_query($link, $cardQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));

if(isset($_GET['action']) && $_GET['action']=="add"){
    $id=intval($_GET['id']); //3
    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $sql_s="SELECT * FROM products WHERE id_product={$id}";
        $query_s= mysqli_query($link, $sql_s) or die("Ошибка выполнения запроса" . mysqli_error($link));
        if(mysqli_num_rows($query_s)!=0){
            $row_s=mysqli_fetch_array($query_s);

            $_SESSION['cart'][$row_s['id_product']]=array(
                "quantity" => 1,
                "price" => $row_s['price']
            );
        } else {
            $message="This product id it's invalid!";
        }
    }
}

while ($row = mysqli_fetch_assoc($cardResult)) {
    $image_path = "img/" . $row['id_product'] . ".png";
    echo '<div class="card">';
    echo '<img src="' . $image_path . '" alt="' . $row['title_product'] . '">';
    echo '<h4>' . $row['title_product'] . '</h4>';
    echo '<p>' . $row['description'] . '</p>';
    echo '<h4>' . $row['price'] . ' BYN</h4>'; 
    $product = $row['id_product'];?>
    <!-- echo '<a href="category.php" class="button-submit ">
    Добавить в корзину
    </a>'; -->
    <form method="post" action="orders.php">
        <!-- <input type="submit" name="add_favorites" value="Добавить в корзину" class="button__nav cards_but acent__but"> -->
    </form>
    <form class="favorite_form">
        <input type="hidden" name="id_product" value="<?php echo $product ?>">
        <input type="submit" name="add_favorites" value="Добавить в избранное"
        class=" button__nav cards_but">
    </form>
    <a href="index.php?page=products&action=add&id=<?php echo $row['id_product'] ?>">Add to cart</a>
    <a href="product.php?id=<?php echo $product['id_product']; ?>">View Product</a>
    <a href="cart.php">Go to cart</a>
    <?php
    echo '</div>';
}
?>

