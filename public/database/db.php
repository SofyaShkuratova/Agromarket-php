<?php

$link = mysqli_connect("localhost", "root", "root", "agromarket");

if(!$link) {
    die("Ошибка: " . mysqli_connect_error());
}

if (!mysqli_set_charset($link, "utf8mb4")) {
    echo "Ошибка при загрузке набора символов utf8mb4 ";
    mysqli_error($link);
    exit();
}
?>