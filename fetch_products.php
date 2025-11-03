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

$category = intval($_GET['category']);

$sql = "SELECT * FROM Продукты WHERE код_категории = $category";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Добавляем свойство 'category' к каждому объекту 'product'
        $row['category'] = $category;
        $products[] = $row;
    }
}

$conn->close();

echo json_encode($products);
?>