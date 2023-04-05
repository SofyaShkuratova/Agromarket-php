
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
        $pr_id = '';
        // var_dump(($_SESSION['cart']));
        if(isset($_SESSION["id_user"])) {
            if(isset($_SESSION['cart'])) {
                $sql="SELECT * FROM products WHERE id_product IN (";
        
                foreach($_SESSION['cart'] as $id => $value) {
                    $sql.=$id.",";
                }
        
                $sql=substr($sql, 0, -1).") ORDER BY 'title_product' ASC";
                $query=mysqli_query($link,$sql);

                // $query = mysqli_query($link,$sql);
                // var_dump(mysqli_error($query));

                
                    $totalprice = 0;
                    while($row=mysqli_fetch_array($query)){
                        $subtotal=$_SESSION['cart'][$row['id_product']]['quantity']*$row['price'];
                        $pr_id .= $row['id_product']." ";
                        $stroke .= $row['title_product']." "; 
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
</form>
<form action="cart.php" method="POST">
    <button class="button-submit" type="submit" name="order">Оформить заказ</button>
</form>

<?php
if(isset($_POST['order'])){
   
    $num_ord = rand(100, 999);
    $Ordquery = "INSERT INTO `orders` (`number_ord`, `id_user`, `id_product`, `status`) VALUES ('{$num_ord}', '{$_SESSION["id_user"]}', '{$pr_id}', 'done')";
    $Ordresult=mysqli_query($link,$Ordquery);

    if($Ordresult) {
        $_SESSION['cart'][$row['id_product']]['quantity'] = 0;
        print "<script language='Javascript' type='text/javascript'>
                        alert(`Вы оформили заказ!`);
                        function reload(){top.location = 'cart.php'};
                        reload();
                        </script>";
    } else {
        echo 'Корзина пуста';
    }
    
} else {
    // echo "Нажмите на кнопку чтобы оформить заказ";
}
?>
</main>

<?php include 'partials/footer.php'?>
</body>
</html>