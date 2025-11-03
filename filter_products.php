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

$category = isset($_GET['category']) ? $_GET['category'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';

$sql = "SELECT p.*, c.название_категории AS название_категории FROM Продукты p LEFT JOIN Категория c ON p.код_категории = c.код_категории WHERE 1=1";
$params = [];

if (!empty($category)) {
    $sql .= " AND c.название_категории = ?";
    $params[] = $category;
}

if (!empty($name)) {
    $sql .= " AND p.название_продукта LIKE ?";
    $params[] = "%$name%";
}

$stmt = $conn->prepare($sql);

if ($params) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
echo "<tr>
        <td>{$row['код_продукта']}</td>
        <td contenteditable='true'>{$row['название_продукта']}</td>
        <td contenteditable='true'>{$row['картинка']}</td>
        <td contenteditable='true'>{$row['описание_продукта']}</td>
        <td>{$row['код_категории']}</td>
        <td contenteditable='true'>{$row['калорийность']}</td>
        <td contenteditable='true'>{$row['цена_за_штуку']}</td>
        <td contenteditable='true'>{$row['наличие']}</td>
        <td>{$row['скидка']}</td>
        <td>{$row['название_категории']}</td>
        <td><button class='btn btn-danger delete-product' data-id='{$row['код_продукта']}'>Удалить</button></td>
      </tr>";

}

$stmt->close();
$conn->close();
?>