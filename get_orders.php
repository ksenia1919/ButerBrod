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

// Получаем код пользователя по телефону
$userSql = "SELECT код_пользователя FROM Пользователи WHERE телефон = ?";
$userStmt = $conn->prepare($userSql);
$userStmt->bind_param("s", $userPhone);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userData = $userResult->fetch_assoc();
$userId = $userData['код_пользователя'];

// Получаем заказы пользователя
$orderSql = "
    SELECT номер_заказа, дата_заказа, состояние, адрес_доставки, способ_оплаты
    FROM Заказ
    WHERE код_пользователя = ?
";
$orderStmt = $conn->prepare($orderSql);
$orderStmt->bind_param("i", $userId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

$orders = [];
while ($order = $orderResult->fetch_assoc()) {
    $orderId = $order['номер_заказа'];

    // Получаем содержимое заказа
    $contentSql = "
        SELECT код_продукта, количество
        FROM СодержаниеЗаказа
        WHERE номер_заказа = ?
    ";
    $contentStmt = $conn->prepare($contentSql);
    $contentStmt->bind_param("i", $orderId);
    $contentStmt->execute();
    $contentResult = $contentStmt->get_result();

    $contents = [];
   while ($content = $contentResult->fetch_assoc()) {
    $productId = $content['код_продукта'];

    // Получаем информацию о продукте
   $productSql = "
    SELECT название_продукта, описание_продукта, цена_за_штуку
    FROM Продукты
    WHERE код_продукта = ?
";
$productStmt = $conn->prepare($productSql);
$productStmt->bind_param("i", $productId);
$productStmt->execute();
$productResult = $productStmt->get_result();
$product = $productResult->fetch_assoc();

$content['название_продукта'] = $product['название_продукта'];
$content['описание_продукта'] = $product['описание_продукта']; // Добавлено
$content['цена_за_штуку'] = $product['цена_за_штуку'];
$content['стоимость'] = $content['цена_за_штуку'] * $content['количество'];
$contents[] = $content;

}

    $order['contents'] = $contents;
    $orders[] = $order;
}

header('Content-Type: application/json');
echo json_encode($orders);
?>