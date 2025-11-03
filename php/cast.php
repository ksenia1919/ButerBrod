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

// SQL-запрос для получения данных из таблицы "Корзина" и связанных таблиц
// SQL-запрос для получения данных из таблицы "Корзина" и связанных таблиц
// SQL-запрос для получения данных из таблицы "Корзина" и связанных таблиц
$sql = "SELECT c.*, p.код_продукта, p.название_продукта, p.цена_за_штуку, p.калорийность, p.картинка, p.скидка
        FROM Корзина c
        INNER JOIN Продукты p ON c.код_продукта = p.код_продукта";
$result = $conn->query($sql);

// Создаем массив для хранения данных о продуктах в корзине
$cart_items = [];

// Формируем массив данных
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
}



// Закрываем соединение с базой данных
$conn->close();

// Отправляем данные в формате JSON
header('Content-Type: application/json');
echo json_encode($cart_items);
?>