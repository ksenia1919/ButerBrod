	// Извлечение значения параметра URL с именем продукта
			var urlParams = new URLSearchParams(window.location.search);
			var productName = urlParams.get('productName');

			function getProductData(productName) {
			    var xhttp = new XMLHttpRequest();
			    xhttp.onreadystatechange = function () {
			        if (this.readyState == 4) {
			            if (this.status == 200) {
			                var productData = JSON.parse(this.responseText);
			                displayProductData(productData);
			            } else {
			                var container = document.getElementById('product-description-container');
			                container.innerHTML = '<p>Произошла ошибка при получении данных о продукте.</p>';
			            }
			        }
			    };
			    xhttp.open(
			        'GET',
			        'php/get_product_data.php?productName=' +
			        encodeURIComponent(productName),
			        true
			    );
			    xhttp.send();
			}

			function displayProductData(productData) {
			    var container = document.getElementById('product-description-container');
			    container.innerHTML = `
			    <div class="product-image">
			        <img src="${productData.image}" alt="${productData.name}">
			    </div>
			    <div class="product-info">
			        <h2>${productData.name}</h2>
			        <p><strong>Стоимость <br></strong> ${productData.price} BYN</p>
			        <p style="font-size: 20px;
			            color: #707070;
			            font-weight: 400;
			            line-height: 32px;
			            margin-bottom: 32px;"><strong>Описание <br></strong> ${productData.description}</p>
			        <p style="font-size: 20px;
			            color: #707070;
			            font-weight: 400;
			            line-height: 32px;
			            margin-bottom: 32px;"><strong>Калорийность<br></strong> ${productData.calories}</p>
			        <p style="font-size: 20px;
			            color: #707070;
			            font-weight: 400;
			            line-height: 32px;
			            margin-bottom: 32px;"><strong>Скидка<br></strong> ${productData.discount}</p>
			        <div class="quantity-selector">
			            <label for="quantity">Количество:</label>
			            <input type="number" id="quantity" name="quantity" value="1" min="1">
			        </div>
			        <button id="addToCartButton">Добавить в корзину</button>
			    </div>
			`;

			    // Получаем кнопку "Добавить в корзину" после того, как она была добавлена в DOM
			    var addToCartButton = document.getElementById('addToCartButton');

			    // Добавляем обработчик события на кнопку
			    addToCartButton.addEventListener('click', function () {
			        // Получаем количество продукта из поля ввода
			        var quantity = parseInt(document.getElementById('quantity').value);

			        // Получаем номер телефона из PHP
			        var phoneNumber = '<?php echo $_SESSION['phone']; ?>';

			        // Вызываем функцию addToCart, передавая имя продукта, количество и номер телефона
			        addToCart(productName, quantity, phoneNumber);
			    });
			}

			function addToCart(productName, quantity, phoneNumber) {
			    console.log('Телефонный номер в сессии:', phoneNumber); // Выводим номер телефона в консоль для проверки
			    var xhttp = new XMLHttpRequest();
			    xhttp.onreadystatechange = function () {
			        if (this.readyState == 4) {
			            if (this.status == 200) {
			                var response = JSON.parse(this.responseText);
			                if (response.success) {
			                    alert('Товар успешно добавлен в корзину!');
			                } else {
			                    alert('Произошла ошибка при добавлении товара в корзину.');
			                }
			            } else {
			                alert('Произошла ошибка при отправке данных на сервер.');
			            }
			        }
			    };
			    xhttp.open('POST', 'php/add_to_cart.php', true);
			    xhttp.setRequestHeader(
			        'Content-Type',
			        'application/x-www-form-urlencoded'
			    );
			    xhttp.send(
			        'productName=' +
			        encodeURIComponent(productName) +
			        '&quantity=' +
			        encodeURIComponent(quantity) +
			        '&phoneNumber=' +
			        encodeURIComponent(phoneNumber)
			    );
			}

			// Вызываем функцию для получения данных о продукте
			getProductData(productName);