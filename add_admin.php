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

// Получаем данные из POST-запроса
$name = $_POST['adminName'];
$email = $_POST['adminEmail'];
$phone = $_POST['adminPhone'];
$role = $_POST['adminRole'];

// Подготавливаем SQL-запрос для добавления нового администратора
$stmt = $conn->prepare("INSERT INTO Пользователи (имя, почта, телефон, роль) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $phone, $role);

if ($stmt->execute()) {
    echo "Новый администратор успешно добавлен";
} else {
    echo "Ошибка: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>