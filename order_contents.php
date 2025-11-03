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

// Получение всех содержаний заказов с названиями продуктов
$sql = "
    SELECT СодержаниеЗаказа.номер_заказа, Продукты.название_продукта, СодержаниеЗаказа.количество
    FROM СодержаниеЗаказа
    JOIN Продукты ON СодержаниеЗаказа.код_продукта = Продукты.код_продукта
";
$result = $conn->query($sql);
?>
<div class="container">
    <h2 style="margin-top:20px">Содержание заказа</h2>
    <label for="filterOrder">Фильтрация по номеру заказа:</label>
    <input type="number" id="filterOrder" class="form-control">
    <table class="table">
        <thead>
            <tr>
                <th>Номер заказа</th>
                <th>Продукт</th>
                <th>Количество</th>
            </tr>
        </thead>
        <tbody id="orderContentsTable">
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['номер_заказа']; ?></td>
                <td><?php echo $row['название_продукта']; ?></td>
                <td><?php echo $row['количество']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#filterOrder').change(function() {
        const orderNumber = $(this).val();
        $.get('filter_order_contents.php', {
            orderNumber: orderNumber
        }, function(data) {
            $('#orderContentsTable').html(data);
        });
    });
});
</script>