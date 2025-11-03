document.addEventListener('DOMContentLoaded', function () {
	document
		.getElementById('accountButton')
		.addEventListener('click', function () {
			document.getElementById('modal').style.display = 'block'
		})

	document
		.getElementById('mobileAccountButton')
		.addEventListener('click', function () {
			document.getElementById('modal').style.display = 'block'
		})

	document
		.getElementsByClassName('close')[0]
		.addEventListener('click', function () {
			document.getElementById('modal').style.display = 'none'
		})

	$(document).ready(function () {
		$('.close').click(function () {
			$(this).closest('.modal').hide()
		})
	})

	document
		.getElementById('loginLink')
		.addEventListener('click', function (event) {
			event.preventDefault()
			document.getElementById('registrationForm').reset()
			document.getElementById('modal').style.display = 'none'
			document.getElementById('loginForm').style.display = 'block'
		})

	document
		.getElementById('registerLink')
		.addEventListener('click', function (event) {
			event.preventDefault()
			document.getElementById('authForm').reset()
			document.getElementById('modal').style.display = 'block'
			document.getElementById('loginForm').style.display = 'none'
		})
})
