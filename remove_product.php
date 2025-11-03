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

// Получение идентификатора продукта для удаления из запроса
$productId = $_POST['productId'];

// SQL-запрос для удаления продукта из корзины
$sql = "DELETE FROM Корзина WHERE код_корзины = $productId";

if ($conn->query($sql) === TRUE) {
    // Если удаление прошло успешно, возвращаем успешный статус
    echo json_encode(array('status' => 'success'));
} else {
    // Если произошла ошибка при удалении, возвращаем сообщение об ошибке
    echo json_encode(array('status' => 'error', 'message' => $conn->error));
}

// Закрываем соединение с базой данных
$conn->close();
?>