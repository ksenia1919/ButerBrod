<?php
// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Подключение к базе данных
    $host = 's3.serv00.com';
$username = "m3715_buterbrod"; // Имя пользователя базы данных
$password = "9^pH7WAbZqySDSKLDEN2"; // Пароль пользователя базы данных
$database = 'm3715_buterbrod';

    $connection = mysqli_connect($host, $username, $password, $database);

    // Проверка подключения
    if (!$connection) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }

    // Получение данных из POST запроса
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Проверка наличия пользователя с такой почтой
    $check_email_query = "SELECT * FROM Пользователи WHERE почта = '$email'";
    $result_email = mysqli_query($connection, $check_email_query);

    // Проверка наличия пользователя с таким телефоном
    $check_phone_query = "SELECT * FROM Пользователи WHERE телефон = '$phone'";
    $result_phone = mysqli_query($connection, $check_phone_query);

    if (mysqli_num_rows($result_email) > 0) {
        // Пользователь с такой почтой уже существует
        die("Пользователь с такой почтой уже существует");
    } elseif (mysqli_num_rows($result_phone) > 0) {
        // Пользователь с таким телефоном уже существует
        die("Пользователь с таким телефоном уже существует");
    } else {
        // Вставка новой записи в таблицу
        $insert_query = "INSERT INTO Пользователи (имя, почта, телефон, роль) VALUES ('$name', '$email', '$phone', 'пользователь')";
        if (mysqli_query($connection, $insert_query)) {
            // Пользователь успешно зарегистрирован
            die("Регистрация успешна");
        } else {
            // Ошибка при выполнении запроса
            die("Ошибка при выполнении регистрации");
        }
    }
}
?>