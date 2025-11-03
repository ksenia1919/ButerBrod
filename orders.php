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

// Получение всех заказов
$sql = "SELECT * FROM Заказ";
$result = $conn->query($sql);
?>
<div class="container">
    <h2 style="margin-top:20px">Заказы</h2>
    <label for="filterDate">Фильтрация по дате:</label>
    <input type="date" id="filterDate" class="form-control">

    <div id="addOrderForm" style="display: none;">
        <h3>Добавить новый заказ</h3>
        <form id="orderForm">
            <div class="form-group">
                <label for="orderDate">Дата:</label>
                <input type="date" class="form-control" id="orderDate" name="orderDate" required>
            </div>
            <div class="form-group">
                <label for="orderStatus">Состояние:</label>
                <select class="form-control" id="orderStatus" name="orderStatus" required>
                    <option value="Идет готовка">Идет готовка</option>
                    <option value="Уже в пути">Уже в пути</option>
                    <option value="Готов">Готов</option>
                </select>
            </div>
            <button style="margin:10px 0" type="submit" class="btn btn-success">Добавить</button>
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Код</th>
                <th>Дата</th>
                <th>Состояние</th>
            </tr>
        </thead>
        <tbody id="ordersTable">
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['номер_заказа']; ?></td>
                <td><?php echo $row['дата_заказа']; ?></td>
                <td>
                    <select class="form-control order-status" data-id="<?php echo $row['номер_заказа']; ?>">
                        <option value="Идет готовка"
                            <?php echo $row['состояние'] == 'Идет готовка' ? 'selected' : ''; ?>>Идет
                            готовка</option>
                        <option value="Уже в пути" <?php echo $row['состояние'] == 'Уже в пути' ? 'selected' : ''; ?>>
                            Уже в пути
                        </option>
                        <option value="Готов" <?php echo $row['состояние'] == 'Готов' ? 'selected' : ''; ?>>Готов
                        </option>
                    </select>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#filterDate').change(function() {
        const date = $(this).val();
        $.get('filter_orders.php', {
            date: date
        }, function(data) {
            $('#ordersTable').html(data);
        });
    });

    $('.order-status').change(function() {
        const status = $(this).val();
        const orderId = $(this).data('id');
        $.post('update_order_status.php', {
            id: orderId,
            status: status
        }, function(response) {
            location.reload();
        });
    });

    $('#toggleAddOrderForm').click(function() {
        $('#addOrderForm').toggle();
    });

    $('#orderForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.post('add_order.php', formData, function(response) {
            alert(response); // Отображаем сообщение об успешном добавлении заказа
            location.reload(); // Перезагружаем страницу для обновления таблицы
        });
    });
});
</script>