<?php
// Проверяем, был ли отправлен POST-запрос
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из тела запроса
    $data = json_decode(file_get_contents("php://input"));

    // Подключаемся к базе данных (здесь нужно указать ваши реальные данные для подключения)
    $servername = "s3.serv00.com"; // Имя сервера базы данных
    $username = "m3715_buterbrod"; // Имя пользователя базы данных
    $password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
    $dbname = "m3715_buterbrod"; // Имя базы данных

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверяем соединение
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Готовим SQL-запрос для вставки новой записи
    $stmt = $conn->prepare("INSERT INTO Продукты (название_продукта, картинка, описание_продукта, код_категории, калорийность, цена_за_штуку, наличие, скидка) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiidii", $data->название_продукта, $data->картинка, $data->описание_продукта, $data->код_категории, $data->калорийность, $data->цена_за_штуку, $data->наличие, $data->скидка);

    // Выполняем подготовленный запрос
    if ($stmt->execute() === TRUE) {
        // Возвращаем успешный ответ
        echo json_encode(array("success" => true));
    } else {
        // Если произошла ошибка при выполнении запроса
        echo json_encode(array("success" => false, "error" => "Ошибка при добавлении продукта: " . $conn->error));
    }

    // Закрываем соединение с базой данных
    $stmt->close();
    $conn->close();
} else {
    // Если не все необходимые поля были переданы
    echo json_encode(array("success" => false, "error" => "Недостаточно данных для добавления продукта."));
}
?>