<?php
// Подключение к базе данных
$host = 's3.serv00.com';
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$database = 'm3715_buterbrod';

$conn = new mysqli($host, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем идентификатор продукта, который нужно удалить
$productId = $_POST['productId'];

// SQL-запрос для удаления продукта из корзины
$sql = "DELETE FROM Корзина WHERE код_корзины = $productId";

// Выполняем запрос
if ($conn->query($sql) === TRUE) {
    echo "Продукт успешно удален из корзины";
} else {
    echo "Ошибка при удалении продукта из корзины: " . $conn->error;
}

// Закрываем соединение с базой данных
$conn->close();
?>