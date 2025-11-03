<?php
$host = 's3.serv00.com';
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$database = 'm3715_buterbrod';
session_start();
// Создание соединения
$conn = new mysqli($host, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверяем, был ли установлен идентификатор сессии и его значение
if (!isset($_SESSION['phone'])) {
    // Если идентификатор сессии не установлен или значение не установлено, отправляем ошибку
    echo json_encode(["error" => "Не удалось найти телефон пользователя в сессии"]);
    exit; // Прерываем выполнение скрипта
}

// Получаем телефон пользователя из сессии
$phone = $_SESSION['phone'];

// Получаем идентификатор продукта и новое количество из POST-запроса
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, были ли переданы обязательные параметры
    if (!isset($_POST["productId"]) || !isset($_POST["quantity"])) {
        // Если не были переданы обязательные параметры, отправляем ошибку
        echo json_encode(["error" => "Не удалось получить идентификатор продукта или количество"]);
        exit; // Прерываем выполнение скрипта
    }

    // Получаем идентификатор продукта и количество из POST-запроса
    $productId = $_POST["productId"];
    $quantity = $_POST["quantity"];

    // Проверяем, принадлежит ли продукт пользователю
    $stmt = $conn->prepare("SELECT код_корзины FROM Корзина WHERE код_корзины = ? AND код_пользователя IN (SELECT код_пользователя FROM Пользователи WHERE телефон = ?)");
    $stmt->bind_param('ss', $productId, $phone);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    // Если продукт не принадлежит пользователю, отправляем ошибку
    if (!$result) {
        echo json_encode(["error" => "Продукт не найден или не принадлежит текущему пользователю"]);
        exit; // Прерываем выполнение скрипта
    }

    // Выполняем SQL-запрос для обновления количества продукта в базе данных
    $stmt = $conn->prepare("UPDATE Корзина SET количество_заказываемого = ? WHERE код_корзины = ?");
    $stmt->bind_param('ss', $quantity, $productId);
    $stmt->execute();

    // Отправляем успешный ответ клиенту
    echo json_encode(["success" => true]);
}

// Закрываем соединение
$conn->close();
?>