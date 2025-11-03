<?php
// Подключение к базе данных
$servername = "s3.serv00.com"; // Имя сервера базы данных
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$dbname = "m3715_buterbrod"; // Имя базы данных

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Запрос к базе данных для получения продуктов по категориям 1, 2 или 3
$sql = "SELECT * FROM Продукты WHERE код_категории IN (1, 2, 3)";
$result = $conn->query($sql);

// Формирование массива данных о продуктах
$products = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Проверка на наличие поля "наличие" и его значения
        if (isset($row["наличие"]) && $row["наличие"] === 'есть') {
            $product = array(
                "name" => $row["название_продукта"],
                "price" => $row["цена_за_штуку"],
                "image" => $row["картинка"]
            );
            $products[] = $product;
        }
    }
}

// Возвращаем данные в формате JSON
echo json_encode($products);

$conn->close();
?>