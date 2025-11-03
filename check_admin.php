<?php
session_start();

// Подключение к базе данных
$host = 's3.serv00.com';
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$database = 'm3715_buterbrod';

$connection = mysqli_connect($host, $username, $password, $database);

// Проверка подключения
if (!$connection) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

$response = array();

// Проверяем, авторизован ли пользователь
if (isset($_SESSION['phone'])) {
    $phone = $_SESSION['phone'];

    // Поиск пользователя в базе данных
    $check_query = "SELECT * FROM Пользователи WHERE телефон = '$phone' AND роль = 'админ'";
    $result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Если пользователь имеет роль "админ", добавляем соответствующий флаг в ответ
        $response['isAdmin'] = true;
    } else {
        // Если пользователь не имеет роль "админ", добавляем соответствующий флаг в ответ
        $response['isAdmin'] = false;
    }
} else {
    // Если пользователь не авторизован, добавляем соответствующий флаг в ответ
    $response['isAdmin'] = false;
}

// Закрываем соединение с базой данных
mysqli_close($connection);

// Возвращаем JSON-ответ
header('Content-Type: application/json');
echo json_encode($response);
?>