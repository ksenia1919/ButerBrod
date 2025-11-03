<?php

$servername = "s3.serv00.com"; // Имя сервера базы данных
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$dbname = "m3715_buterbrod"; // Имя базы данных

// Создание соединения с базой данных
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Проверка соединения
if (!$conn) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Получение данных из сессии
session_start();
if (isset($_SESSION['phone'])) {
    $userPhone = $_SESSION['phone'];
} else {
    // Обработка случая, когда телефон пользователя не найден в сессии
    exit('Вы не вошли в аккаунт');
}

// SQL запрос для получения кода пользователя по его телефону
$sql = "SELECT код_пользователя FROM Пользователи WHERE телефон = '$userPhone'";
$result = mysqli_query($conn, $sql);

// Проверка наличия результата запроса
if (mysqli_num_rows($result) > 0) {
    // Получение данных о пользователе
    $row = mysqli_fetch_assoc($result);
    $userId = $row['код_пользователя'];
} else {
    // Обработка случая, когда пользователя с таким телефоном не найден
    exit('Ошибка: пользователь с указанным телефоном не найден.');
}

// Получение данных из поля ввода
// Получение данных из поля ввода
$productName = isset($_POST['productName']) ? $_POST['productName'] : '';
if (empty($productName)) {
    // Обработка случая, когда название продукта не передано
    exit('Ошибка: не передано название продукта.');
}


// Получение данных из поля ввода
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

// SQL запрос для получения кода продукта по его имени
$sql = "SELECT код_продукта FROM Продукты WHERE название_продукта = '$productName'";
$result = mysqli_query($conn, $sql);

// Проверка наличия результата запроса
if (mysqli_num_rows($result) > 0) {
    // Получение данных о продукте
    $row = mysqli_fetch_assoc($result);
    $productId = $row['код_продукта'];

    // SQL запрос для добавления данных в таблицу "Корзина"
    $sql = "INSERT INTO Корзина (код_пользователя, код_продукта, количество_заказываемого) 
            VALUES ('$userId', '$productId', '$quantity')";

    // Выполнение SQL запроса
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'error' => 'Ошибка при добавлении данных в корзину: ' . mysqli_error($conn)));
    }
} else {
    // Обработка случая, когда продукт с указанным именем не найден
    echo json_encode(array('success' => false, 'error' => 'Ошибка: продукт с указанным именем не найден.'));
}

// Закрытие соединения с базой данных
mysqli_close($conn);

?>