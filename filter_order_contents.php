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

$orderNumber = isset($_GET['orderNumber']) ? $_GET['orderNumber'] : '';

if ($orderNumber) {
    $sql = "
        SELECT СодержаниеЗаказа.номер_заказа, Продукты.название_продукта, СодержаниеЗаказа.количество
        FROM СодержаниеЗаказа
        JOIN Продукты ON СодержаниеЗаказа.код_продукта = Продукты.код_продукта
        WHERE СодержаниеЗаказа.номер_заказа = $orderNumber
    ";
} else {
    $sql = "
        SELECT СодержаниеЗаказа.номер_заказа, Продукты.название_продукта, СодержаниеЗаказа.количество
        FROM СодержаниеЗаказа
        JOIN Продукты ON СодержаниеЗаказа.код_продукта = Продукты.код_продукта
    ";
}

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['номер_заказа']}</td>
            <td>{$row['название_продукта']}</td>
            <td>{$row['количество']}</td>
          </tr>";
}
?>