<?php
$servername = "s3.serv00.com"; // Имя сервера базы данных
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$dbname = "m3715_buterbrod"; // Имя базы данных

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из POST-запроса
$id = $_POST['id'];
$field = $_POST['field'];
$value = $_POST['value'];

// Список допустимых полей для обновления
$validFields = [
    'название_продукта',
    'картинка',
    'описание_продукта',
    'название_категории',
    'калорийность',
    'цена_за_штуку',
    'наличие',
    'скидка'
];

// Проверка, что поле допустимо
if (!in_array($field, $validFields)) {
    die("Invalid field name");
}

// Используем подготовленные запросы для защиты от SQL-инъекций
$stmt = $conn->prepare("UPDATE Продукты SET $field = ? WHERE код_продукта = ?");
$stmt->bind_param("si", $value, $id);
$stmt->execute();

// Проверяем успешность выполнения запроса
if ($stmt->affected_rows > 0) {
    echo "Данные успешно обновлены";
} else {
    echo "Ошибка при обновлении данных: " . $conn->error;
}

$stmt->close();
$conn->close();
?>