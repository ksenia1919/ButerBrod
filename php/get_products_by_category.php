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

// Получение id категории из запроса
$category = $_GET['category'];

// Запрос к базе данных для получения продуктов по категории с условием "наличие = 'есть'"
$sql = "SELECT * FROM Продукты WHERE код_категории = '$category' AND наличие = 'есть'";
$result = $conn->query($sql);

// Формирование массива данных о продуктах
$products = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $product = array(
            "name" => $row["название_продукта"],
            "price" => $row["цена_за_штуку"],
            "image" => $row["картинка"],
            "calories" => $row["калорийность"],
            "code" => $row["код_продукта"]
        );
        $products[] = $product;
    }
}

// Возвращаем данные в формате JSON
echo json_encode($products);

$conn->close();
?>