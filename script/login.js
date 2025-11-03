// Функция для обработки авторизации пользователя
$(document).ready(function() {
    $('#authForm').submit(function(event) {
        event.preventDefault(); // Предотвращаем отправку формы по умолчанию

        // Получаем данные из формы
        var formData = {
            'phone': $('#loginPhone').val() // Изменяем 'login' на 'phone'
        };

        // Отправляем AJAX запрос на сервер для обработки авторизации
        $.ajax({
            type: 'POST',
            url: './php/login.php', // Путь к файлу обработчику авторизации на сервере
            data: formData,
            dataType: 'json',
            encode: true
        })
        .done(function(data) {
            // Выводим сообщение об успехе или ошибке
            $('#loginResult').html('<p>' + data.message + '</p>');
        });
    });
});
