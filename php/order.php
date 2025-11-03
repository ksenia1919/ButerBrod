<?php
session_start();

// Подключение к базе данных
$host = 's3.serv00.com';
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$database = 'm3715_buterbrod';
$conn = new mysqli($host, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Получаем код пользователя из сессии
if (!isset($_SESSION['phone'])) {
    echo json_encode(["error" => "Не удалось найти телефон пользователя в сессии"]);
    exit;
}

$phone = $_SESSION['phone'];

// Получаем данные из GET-запроса
if(isset($_GET['address']) && isset($_GET['paymentMethod'])) {
    $address = $_GET['address']; // адрес доставки
    $paymentMethod = $_GET['paymentMethod']; // способ оплаты
} else {
    echo json_encode(["error" => "Пожалуйста, заполните адрес доставки и выберите способ оплаты"]);
    exit;
}

// Оформление заказа
$date = date('Y-m-d H:i:s'); // текущая дата и время
$state = 'Идет готовка'; // состояние заказа

// Ищем пользователя по телефону и получаем его код
$stmt = $conn->prepare("SELECT код_пользователя FROM Пользователи WHERE телефон = ?");
$stmt->bind_param('s', $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["error" => "Пользователь с таким телефоном не найден"]);
    exit;
}

$user = $result->fetch_assoc();
$userCode = $user['код_пользователя'];

// Создаем заказ
$stmt = $conn->prepare("INSERT INTO Заказ (код_пользователя, дата_заказа, состояние, адрес_доставки, способ_оплаты) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('issss', $userCode, $date, $state, $address, $paymentMethod);
if (!$stmt->execute()) {
    echo json_encode(["error" => "Ошибка при оформлении заказа: " . $stmt->error]);
    exit;
}

$orderId = $stmt->insert_id; // Получаем номер заказа

// Получаем данные о товарах в корзине пользователя
$stmt_cart = $conn->prepare("SELECT код_продукта, количество_заказываемого FROM Корзина WHERE код_пользователя = ?");
$stmt_cart->bind_param('i', $userCode);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

if ($result_cart->num_rows > 0) {
    // Для каждой записи в корзине пользователя
    while ($row_cart = $result_cart->fetch_assoc()) {
        $productCode = $row_cart['код_продукта'];
        $quantity = $row_cart['количество_заказываемого'];

        // Вставляем запись в таблицу Содержание заказа
        $stmt_insert = $conn->prepare("INSERT INTO СодержаниеЗаказа (номер_заказа, код_продукта, количество) VALUES (?, ?, ?)");
        $stmt_insert->bind_param('iii', $orderId, $productCode, $quantity);
        
        if (!$stmt_insert->execute()) {
            // Возникла ошибка при выполнении запроса
            echo json_encode(["error" => "Ошибка при добавлении записи в таблицу 'СодержаниеЗаказа': " . $stmt_insert->error]);
            exit;
        }
    }
}

// Удаляем товары из корзины пользователя после успешного оформления заказа
$stmt_delete = $conn->prepare("DELETE FROM Корзина WHERE код_пользователя = ?");
$stmt_delete->bind_param('i', $userCode);

if (!$stmt_delete->execute()) {
    // В случае ошибки при удалении товаров из корзины
    echo json_encode(["error" => "Ошибка при удалении товаров из корзины: " . $stmt_delete->error]);
    exit;
}

// Обновляем таблицу Корзина после удаления товаров
$stmt_update_cart = $conn->prepare("UPDATE Корзина SET обновлено = CURRENT_TIMESTAMP WHERE код_пользователя = ?");
$stmt_update_cart->bind_param('i', $userCode);

if (!$stmt_update_cart->execute()) {
    // В случае ошибки при обновлении таблицы Корзина
    echo json_encode(["error" => "Ошибка при обновлении таблицы Корзина: " . $stmt_update_cart->error]);
    exit;
}


// Отправляем успешный ответ клиенту
echo json_encode(["success" => true]);

// Закрываем соединение
$conn->close();

?>