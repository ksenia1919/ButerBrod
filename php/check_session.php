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

if (isset($_SESSION['phone'])) {
    $phone = $_SESSION['phone'];

    // Получаем номер телефона из сессии
    $response['phone'] = $phone;

    // Проверка наличия номера телефона в базе данных
    $check_query = "SELECT * FROM Пользователи WHERE телефон = '$phone'";
    $result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Номер телефона найден в базе данных
        $row = mysqli_fetch_assoc($result);
        $response['authenticated'] = true;
        // Добавляем имя пользователя или его первую букву в данные
        if (!empty($row['имя'])) {
            $response['name'] = mb_substr($row['имя'], 0, 1); // Получаем первую букву имени
        } else {
            $response['name'] = ''; // Если имя не указано, оставляем пустую строку
        }
    } else {
        // Номер телефона не найден в базе данных, удаляем сессию
        unset($_SESSION['phone']);
        $response['authenticated'] = false;
    }
} else {
    $response['authenticated'] = false;
}

// Закрываем соединение с базой данных
mysqli_close($connection);

header('Content-Type: application/json');
echo json_encode($response);
?>