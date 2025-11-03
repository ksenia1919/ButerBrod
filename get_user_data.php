<?php
session_start();
// Подключение к базе данных
$servername = "s3.serv00.com"; // Имя сервера базы данных
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$dbname = "m3715_buterbrod"; // Имя базы данных

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем текущий телефон пользователя из сессии
$userPhone = $_SESSION['phone'];

// Подготовка и выполнение запроса для получения данных пользователя
$sql = "SELECT имя, телефон, почта FROM Пользователи WHERE телефон = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userPhone);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Получаем данные пользователя
$userName = $user['имя'];
$userPhone = $user['телефон'];
$userEmail = $user['почта'];

// Выводим данные в формате JSON
echo json_encode(array("name" => $userName, "phone" => $userPhone, "email" => $userEmail));
?>