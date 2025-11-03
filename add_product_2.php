<?php
$servername = "s3.serv00.com";
$username = "m3715_buterbrod";
$password = "9^pH7WAbZqySDSKLDEN2";
$dbname = "m3715_buterbrod";

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем данные из POST-запроса
$name = isset($_POST['productName']) ? $_POST['productName'] : '';
$description = isset($_POST['productDescription']) ? $_POST['productDescription'] : '';
$category = isset($_POST['productCategory']) ? $_POST['productCategory'] : '';
$calories = isset($_POST['productCalories']) ? $_POST['productCalories'] : '';
$price = isset($_POST['productPrice']) ? $_POST['productPrice'] : '';
$availability = isset($_POST['productAvailability']) ? $_POST['productAvailability'] : '';
$discount = isset($_POST['productDiscount']) ? $_POST['productDiscount'] : '';

// Обработка загрузки изображения
$target_dir = "image/";
$target_file = $target_dir . basename($_FILES["productImage"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$uploadOk = 1;

// Проверка типа файла
$check = getimagesize($_FILES["productImage"]["tmp_name"]);
if($check !== false) {
    $uploadOk = 1;
} else {
    echo "Файл не является изображением.";
    $uploadOk = 0;
}

// Проверка, существует ли файл уже
if (file_exists($target_file)) {
    echo "Извините, файл уже существует.";
    $uploadOk = 0;
}

// Проверка размера файла
if ($_FILES["productImage"]["size"] > 500000) {
    echo "Извините, ваш файл слишком большой.";
    $uploadOk = 0;
}

// Разрешенные форматы файлов
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Извините, только JPG, JPEG, PNG и GIF файлы разрешены.";
    $uploadOk = 0;
}

// Проверка, если $uploadOk равно 0 из-за ошибки
if ($uploadOk == 0) {
    echo "Извините, ваш файл не был загружен.";
// Если все проверки пройдены, пытаемся загрузить файл
} else {
    if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
        $image = $target_file;
    } else {
        echo "Извините, произошла ошибка при загрузке вашего файла.";
    }
}

// Подготавливаем SQL-запрос для добавления нового продукта
$sql = "INSERT INTO Продукты (название_продукта, картинка, описание_продукта, код_категории, калорийность, цена_за_штуку, наличие, скидка)
VALUES ('$name', '$image', '$description', '$category', '$calories', '$price', '$availability', '$discount')";

if ($conn->query($sql) === TRUE) {
    echo "Новый продукт успешно добавлен";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>