$(document).ready(function () {
	// Получаем текущий URL страницы
	var currentPageUrl = window.location.href

	// Устанавливаем текущий URL в скрытом поле
	$('#redirectUrl').val(currentPageUrl)

	// Обработка регистрации
	$('#registrationForm').submit(function (event) {
		event.preventDefault()
		$.ajax({
			type: 'POST',
			url: 'php/register.php',
			data: $(this).serialize(),
			success: function (response) {
				if (response === 'success') {
					// Если регистрация прошла успешно, перенаправляем на index.html
					window.location.href = '../index.html'
				} else {
					// Если есть какие-то ошибки, отображаем их
					$('#registrationResult').text(response)
				}
			},
		})
	})

	// Обработка авторизации
	$(document).ready(function () {
		// Обработка авторизации
		$('#authForm').submit(function (event) {
			event.preventDefault()
			$.ajax({
				type: 'POST',
				url: 'php/login.php',
				data: $(this).serialize(),
				success: function (response) {
					console.log(response) // Выводим ответ в консоль для проверки
					if (response === true) {
						// Перезагружаем страницу
						console.log('Попытка перезагрузить страницу')
						window.location.reload()
					} else {
						// Выводим сообщение об ошибке
						$('#loginResult').text('Ошибка авторизации')
					}
				},
				error: function (xhr, status, error) {
					console.error(xhr.responseText)
					console.error(status)
					console.error(error)
				},
				dataType: 'json', // Указываем ожидаемый тип данных
			})
		})
	})
})
