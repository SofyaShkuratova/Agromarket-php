
<?php
session_start();
$link = mysqli_connect("localhost", "root", "root", "agromarket");

if(isset($_POST['submit'])){

    foreach($_POST['quantity'] as $key => $val) {
        if($val==0) {
            unset($_SESSION['cart'][$key]);
        }else{
            $_SESSION['cart'][$key]['quantity']=$val;
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
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/product.css">
    <title>Корзина</title>
</head>
<body>
    <?php include 'partials/header.php'?>
    
<main>
<h2>Корзина</h2>
<!-- <a href="index.php?page=products">Go back to products page</a> -->
<form method="post" action="cart.php">
    <table>
        <tr  style="background: #afbdbd;">
            <th>Наименование товара</th>
            <th>Количество</th>
            <th>Цена за 1 шт</th>
            <th>Цена за количество шт</th>
        </tr>

        <?php
        if(isset($_SESSION["id_user"])) {
            if(isset($_SESSION['cart'])) {
                $sql="SELECT * FROM products WHERE id_product IN (";
      
              foreach($_SESSION['cart'] as $id => $value) {
                  $sql.=$id.",";
              }
      
              $sql=substr($sql, 0, -1).") ORDER BY 'title_product' ASC";
              $query=mysqli_query($link,$sql) or die("Ошибка выполнения запроса" . mysqli_error($link));
              $totalprice = 0;
              while($row=mysqli_fetch_array($query)){
                  $subtotal=$_SESSION['cart'][$row['id_product']]['quantity']*$row['price'];
                  $totalprice+=$subtotal;
                  ?>
                  <tr>
                      <td><?php echo $row['title_product'] ?></td>
                      <td><input type="text" name="quantity[<?php echo $row['id_product'] ?>]" size="5" value="<?php echo $_SESSION['cart'][$row['id_product']]['quantity'] ?>" /></td>
                      <td><?php echo $row['price'] ?> BYN</td>
                      <td><?php echo $_SESSION['cart'][$row['id_product']]['quantity']*$row['price'] ?> BYN</td>
                  </tr>
                  <?php
              }
                
              } 
        } else {
            echo "<h2 style='text-align:center'>Пользователь не авторизирован!</h2>";
        }
        
        ?>
        
        <tr>
            <td colspan="4" style="background: #afbdbd; border-radius: 0 0 20px 20px">Итоговая стоимость: <?php echo $totalprice ?> BYN</td>
        </tr>

    </table>
    
    <button class="button-submit" type="submit" name="submit">Перезагрузить корзину</button>
</form>
<!-- <p>Чтобы удалить продукт, введите 0 в количество </p> -->
</main>
<section class="comment">
    <h2>Комментарии продукта</h2>
</section>



<?php include 'partials/footer.php'?>
</body>
</html>