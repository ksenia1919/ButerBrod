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

// Получение всех продуктов
$sql = "SELECT p.*, c.название_категории AS название_категории FROM Продукты p LEFT JOIN Категория c ON p.код_категории = c.код_категории";
$result = $conn->query($sql);
?>
<div class="mt-12">
    <h2 style="margin-top:20px">Продукты</h2>
    <label for="filterCategory">Фильтрация по категории:</label>
    <select id="filterCategory" class="form-control">
        <option value="">Все категории</option>
        <?php
        // Получение всех категорий
        $categories = $conn->query("SELECT * FROM Категория");
        while($cat = $categories->fetch_assoc()):
        ?>
        <option value="<?php echo $cat['название_категории']; ?>"><?php echo $cat['название_категории']; ?></option>
        <?php endwhile; ?>
    </select>
    <label for="filterProductName">Фильтрация по названию продукта:</label>
    <input type="text" id="filterProductName" class="form-control">

    <button id="addProduct" class="btn btn-success mt-3">Добавить продукт</button>
    <div id="addProductForm" style="display: none;">
        <h3>Добавить продукт</h3>
        <form id="productForm" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Название:</label>
                <input type="text" class="form-control" id="productName" name="productName">
            </div>
            <div class="form-group">
                <label for="productImage">Картинка:</label>
                <input type="file" class="form-control" id="productImage" name="productImage">
            </div>
            <div class="form-group">
                <label for="productDescription">Описание:</label>
                <input type="text" class="form-control" id="productDescription" name="productDescription">
            </div>
            <div class="form-group">
                <label for="productCategory">Категория:</label>
                <select class="form-control" id="productCategory" name="productCategory">
                    <?php
                    // Получение всех категорий
                    $categories = $conn->query("SELECT * FROM Категория");
                    while($cat = $categories->fetch_assoc()):
                ?>
                    <option value="<?php echo $cat['код_категории']; ?>"><?php echo $cat['название_категории']; ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="productCalories">Калорийность:</label>
                <input type="text" class="form-control" id="productCalories" name="productCalories">
            </div>
            <div class="form-group">
                <label for="productPrice">Цена за штуку:</label>
                <input type="text" class="form-control" id="productPrice" name="productPrice">
            </div>
            <div class="form-group">
                <label for="productAvailability">Наличие:</label>
                <input type="text" class="form-control" id="productAvailability" name="productAvailability">
            </div>
            <div class="form-group">
                <label for="productDiscount">Скидка:</label>
                <input type="text" class="form-control" id="productDiscount" name="productDiscount">
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Код</th>
                <th>Название</th>
                <th>Картинка</th>
                <th>Описание</th>
                <th>Категория</th>
                <th>Калорийность</th>
                <th>Цена</th>
                <th>Наличие</th>
                <th>Скидка</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody id="productsTable">
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td contenteditable="true"><?php echo $row['код_продукта']; ?></td>
                <td contenteditable="true"><?php echo $row['название_продукта']; ?></td>
                <td contenteditable="true"><?php echo $row['картинка']; ?></td>
                <td contenteditable="true"><?php echo $row['описание_продукта']; ?></td>
                <td contenteditable="true"><?php echo $row['название_категории']; ?></td>
                <td contenteditable="true"><?php echo $row['калорийность']; ?></td>
                <td contenteditable="true"><?php echo $row['цена_за_штуку']; ?></td>
                <td contenteditable="true"><?php echo $row['наличие']; ?></td>
                <td contenteditable="true"><?php echo $row['скидка']; ?></td>
                <td>
                    <button class="btn btn-danger delete-product"
                        data-id="<?php echo $row['код_продукта']; ?>">Удалить</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#filterCategory').change(function() {
        const category = $(this).val();
        $.get('filter_products.php', {
            category: category
        }, function(data) {
            $('#productsTable').html(data);
        });
    });

    $('#filterProductName').keyup(function() {
        const name = $(this).val();
        $.get('filter_products.php', {
            name: name
        }, function(data) {
            $('#productsTable').html(data);
        });
    });

    $('#addProduct').click(function() {
        $('#addProductForm').show();
    });

    $('#productForm').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'add_product_2.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response); // Отображаем сообщение об успешном добавлении продукта
                location.reload(); // Перезагружаем страницу для обновления таблицы
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown); // Выводим ошибки в консоль
            }
        });
    });

    $('#productsTable').on('click', '.delete-product', function() {
        const productId = $(this).data('id');
        $.post('delete_product.php', {
            id: productId
        }, function(response) {
            location.reload();
        });
    });

    $(document).ready(function() {
        $('#productsTable').on('blur', 'td[contenteditable=true]', function() {
            const productId = $(this).closest('tr').find('.delete-product').data('id');
            const fieldIndex = $(this).index();
            const fieldNames = ['код_продукта', 'название_продукта', 'картинка',
                'описание_продукта', 'название_категории', 'калорийность', 'цена_за_штуку',
                'наличие', 'скидка'
            ];
            const field = fieldNames[fieldIndex];
            const value = $(this).text();

            // Обновляем только если изменилось поле, кроме 'код_продукта'
            if (field !== 'код_продукта') {
                $.post('update_product.php', {
                    id: productId,
                    field: field,
                    value: value
                }, function(response) {
                    console.log(response); // Отладка ответа
                });
            }
        });
    });



});
</script>