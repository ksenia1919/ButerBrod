// Функция для обработки регистрации пользователя
$(document).ready(function() {
    $('#registrationForm').submit(function(event) {
        event.preventDefault(); // Предотвращаем отправку формы по умолчанию

        // Получаем данные из формы
        var formData = {
            'name': $('#name').val(),
            'login': $('#login').val(),
            'password': $('#password').val()
        };

        // Отправляем AJAX запрос на сервер для обработки регистрации
        $.ajax({
            type: 'POST',
            url: './php/register.php', // Путь к файлу обработчику регистрации на сервере
            data: formData,
            dataType: 'json',
            encode: true
        })
        .done(function(data) {
            // Выводим сообщение об успехе или ошибке
            $('#registrationResult').html('<p>' + data.message + '</p>');
        });
    });
});
