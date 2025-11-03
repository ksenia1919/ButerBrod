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

// Получаем новые данные из формы
$newName = $_POST['name'];
$newPhone = $_POST['phone'];
$newEmail = $_POST['email'];

// Подготовка и выполнение запроса на обновление данных пользователя
$sql = "UPDATE Пользователи SET имя=?, телефон=?, почта=? WHERE телефон=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $newName, $newPhone, $newEmail, $userPhone);
$stmt->execute();

// Обновляем телефон в сессии, если он был изменен
$_SESSION['phone'] = $newPhone;

// Перенаправляем пользователя на страницу аккаунта после обновления данных
header("Location: account.html");
exit();
?>