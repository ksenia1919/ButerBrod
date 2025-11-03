<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container mt-5">
    <ul class="nav nav-tabs" id="adminTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users"
          aria-selected="true">Пользователи</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders"
          aria-selected="false">Заказы</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="order-contents-tab" data-toggle="tab" href="#order-contents" role="tab"
          aria-controls="order-contents" aria-selected="false">Содержание заказа</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products"
          aria-selected="false">Продукты</a>
      </li>
    </ul>
    <div class="tab-content" id="adminTabContent">
      <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
        <?php include 'users.php'; ?>
      </div>
      <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
        <?php include 'orders.php'; ?>
      </div>
      <div class="tab-pane fade" id="order-contents" role="tabpanel" aria-labelledby="order-contents-tab">
        <?php include 'order_contents.php'; ?>
      </div>
      <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
        <?php include 'products.php'; ?>
      </div>
    </div>
  </div>
</body>

</html>