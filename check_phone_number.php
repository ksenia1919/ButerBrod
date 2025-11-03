<?php
// Подключение к базе данных
$host = 's3.serv00.com';
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$database = 'm3715_buterbrod';

// Подключение к серверу базы данных
$conn = new mysqli($host, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение телефона из POST-запроса
$phone = $_POST['phone'];

// Подготовка SQL-запроса для проверки уникальности телефона
$stmt = $conn->prepare("SELECT * FROM Пользователи WHERE телефон = ?");
$stmt->bind_param("s", $phone);

// Выполнение запроса
$stmt->execute();

// Получение результатов запроса
$result = $stmt->get_result();

// Проверка наличия телефона в базе данных
if ($result->num_rows > 0) {
    // Телефон уже занят, отправляем сообщение об ошибке
    echo "Такой телефон уже занят";
} else {
    // Телефон свободен
    echo "";
}

// Закрытие запроса и соединения
$stmt->close();
$conn->close();
?>