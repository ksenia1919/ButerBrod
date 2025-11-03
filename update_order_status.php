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

$id = $_POST['id'];
$status = $_POST['status'];

// Используем подготовленные выражения для обновления данных
$stmt = $conn->prepare("UPDATE Заказ SET состояние = ? WHERE номер_заказа = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo "Order status updated successfully.";
} else {
    echo "Error updating order status: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>