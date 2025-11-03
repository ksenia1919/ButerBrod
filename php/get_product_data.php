<?php
// Подключение к базе данных
$servername = "s3.serv00.com"; // Имя сервера базы данных
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$dbname = "m3715_buterbrod"; // Имя базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Извлечение значения параметра productName из URL
$productName = $_GET['productName'];

// Подготовленный запрос для безопасного выполнения запроса с использованием параметров
$stmt = $conn->prepare("SELECT * FROM Продукты WHERE название_продукта = ?");
$stmt->bind_param("s", $productName);

// Выполнение подготовленного запроса
$stmt->execute();

// Получение результата запроса
$result = $stmt->get_result();

// Проверка наличия данных о продукте
if ($result->num_rows > 0) {
    // Извлечение данных о продукте
    $row = $result->fetch_assoc();
    $productData = array(
        "productId" => $row["код_продукта"], // Добавляем productId
        "name" => $row["название_продукта"],
        "image" => $row["картинка"],
        "description" => $row["описание_продукта"],
        "calories" => $row["калорийность"],
        "price" => $row["цена_за_штуку"],
        "discount" => $row["скидка"],
        "availability" => $row["наличие"]
    );
    // Вывод данных о продукте в формате JSON
    echo json_encode($productData);
} else {
    http_response_code(404);
    echo json_encode(array("error" => "Продукт не найден"));
}

// Закрытие подключения к базе данных
$stmt->close();
$conn->close();
?>