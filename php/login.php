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

// Получение данных из POST запроса
$телефон = $_POST['phone'];

// Поиск пользователя в базе данных
$check_query = "SELECT * FROM Пользователи WHERE телефон = '$телефон'";
$result = mysqli_query($connection, $check_query);

if (mysqli_num_rows($result) > 0) {
    // Пользователь найден, устанавливаем сессию
    $row = mysqli_fetch_assoc($result);
    $_SESSION['phone'] = $телефон; // Устанавливаем сессию с номером телефона пользователя

    // Отправляем true в формате JSON для успешной авторизации
    echo json_encode(true);
} else {
    // Пользователь не найден
    $message = "Не найден пользователь с таким номером"; // Определение сообщения об успешной авторизации

    // Формирование массива с данными
    $response = array('message' => $message);

    // Отправляем данные в формате JSON
    echo json_encode($response);
}

// Закрытие соединения с базой данных
mysqli_close($connection);
?>