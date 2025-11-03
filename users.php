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

// Получение всех пользователей
$sql = "SELECT * FROM Пользователи";
$result = $conn->query($sql);
?>
<div class="container">
    <h2 style="margin-top:20px">Пользователи</h2>
    <button style="margin-top:20px; margin-bottom:10px" id="showAdmins" class="btn btn-primary">Показать только
        админов</button>
    <button style="margin-top:20px; margin-bottom:10px" id="toggleAddAdminForm" class="btn btn-success">Добавить нового
        администратора</button>
    <div id="addAdminFormContainer" style="display: none;">
        <h3>Добавить нового администратора</h3>
        <form id="addAdminForm">
            <div class="form-group">
                <label for="adminName">Имя:</label>
                <input type="text" class="form-control" id="adminName" name="adminName" required>
            </div>
            <div class="form-group">
                <label for="adminEmail">Почта:</label>
                <input type="email" class="form-control" id="adminEmail" name="adminEmail" required>
            </div>
            <div class="form-group">
                <label for="adminPhone">Телефон:</label>
                <input type="text" class="form-control" id="adminPhone" name="adminPhone" required>
            </div>
            <input type="hidden" name="adminRole" value="админ">
            <button style="margin:10px 0" type="submit" class="btn btn-success">Добавить</button>
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Код</th>
                <th>Имя</th>
                <th>Почта</th>
                <th>Телефон</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="user-row" data-role="<?php echo $row['роль']; ?>">
                <td><?php echo $row['код_пользователя']; ?></td>
                <td><?php echo $row['имя']; ?></td>
                <td><?php echo $row['почта']; ?></td>
                <td><?php echo $row['телефон']; ?></td>
                <td><?php echo $row['роль']; ?></td>
                <td>
                    <?php if($row['роль'] == 'админ'): ?>
                    <button class="btn btn-danger delete-user"
                        data-id="<?php echo $row['код_пользователя']; ?>">Удалить</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Модальное окно подтверждения удаления -->
<div class="modal" id="confirmDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Подтверждение удаления</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Вы точно хотите удалить администратора?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Удалить</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let deleteUserId;

    $('#showAdmins').click(function() {
        $('.user-row').hide();
        $('.user-row[data-role="админ"]').show();
    });

    $('#toggleAddAdminForm').click(function() {
        $('#addAdminFormContainer').toggle();
    });

    $('.delete-user').click(function() {
        deleteUserId = $(this).data('id');
        $('#confirmDeleteModal').modal('show');
    });

    $('#confirmDeleteButton').click(function() {
        $.post('delete_user.php', {
            id: deleteUserId
        }, function(response) {
            $('#confirmDeleteModal').modal('hide');
            location.reload();
        });
    });

    $('#addAdminForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.post('add_admin.php', formData, function(response) {
            alert(response); // Отображаем сообщение об успешном добавлении администратора
            location.reload(); // Перезагружаем страницу для обновления таблицы
        });
    });
});
</script>