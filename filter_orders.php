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

$date = $_GET['date'];
$sql = "SELECT * FROM Заказ WHERE DATE(дата_заказа) = '$date'";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['номер_заказа']}</td>
            <td>{$row['дата_заказа']}</td>
            <td>
                <select class='form-control order-status' data-id='{$row['номер_заказа']}'>
                    <option value='Оформлен' " . ($row['состояние'] == 'Оформлен' ? 'selected' : '') . ">Оформлен</option>
                    <option value='Идет готовка' " . ($row['состояние'] == 'Идет готовка' ? 'selected' : '') . ">Идет готовка</option>
                    <option value='Уже в пути' " . ($row['состояние'] == 'Уже в пути' ? 'selected' : '') . ">Уже в пути</option>
                    <option value='Готов' " . ($row['состояние'] == 'Готов' ? 'selected' : '') . ">Готов</option>
                </select>
            </td>
          </tr>";
}
?>