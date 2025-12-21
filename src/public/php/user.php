<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="../css/full.css">

</head>
<body class="body_user">
    <div class="user-container">
        <!-- Шапка -->
        <header class="user-header">
            <h1>Личный кабинет</h1>
            <nav class="breadcrumb">
                <a href="../index.html">Главная</a> /
                <a href="catalog.html">Магазин</a> /
                <span>Личный кабинет</span>
            </nav>
        </header>

        <!-- Основной контент -->
        <main class="user-main">
            <!-- Секция заказа -->
            <section class="order-section">
                <!-- Информация о пользователе -->
                <div class="user-profile-section">
                    <h2>Профиль пользователя</h2>
                    <div class="profile-editor">
                        <div class="avatar-section">
                            <div class="user-avatar">
                                <img src="../images/Group.png" alt="Аватар пользователя" id="avatar-img">
                                <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
                            </div>
                            <button id="change-avatar" class="edit-avatar-btn">
                                <span class="btn-text">Изменить аватар</span>
                                <span class="btn-icon">📷</span>
                            </button>
                        </div>
                        
                        <div class="profile-details">
                            <div class="profile-field">
                                <label for="user-name-display">Имя:</label>
                                <span id="user-name" class="profile-value">Пользователь</span>
                                <button class="edit-field-btn" data-field="name" aria-label="Редактировать имя">
                                    <span class="btn-icon">✏️</span>
                                    <span class="btn-text">Изменить</span>
                                </button>
                            </div>
                            
                            <div class="profile-field">
                                <label for="user-phone-display">Телефон:</label>
                                <span id="user-phone" class="profile-value blurred">+7 (XXX) XXX-XX-XX</span>
                                <button class="edit-field-btn" data-field="phone" aria-label="Редактировать телефон">
                                    <span class="btn-icon">✏️</span>
                                    <span class="btn-text">Изменить</span>
                                </button>
                            </div>
                            
                            <div class="profile-field">
                                <label for="user-email-display">Email:</label>
                                <span id="user-email" class="profile-value blurred">user@example.com</span>
                                <button class="edit-field-btn" data-field="email" aria-label="Редактировать email">
                                    <span class="btn-icon">✏️</span>
                                    <span class="btn-text">Изменить</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Дополнительная информация -->
                <div class="additional-info">
                    <div class="info-item">
                        <img src="../images/mdi_sale-outline.png" alt="Скидка">
                        <span>Ваша скидка: <span id="discount-value">0%</span></span>
                    </div>
                    <div class="info-item">
                        <img src="../images/Vector.png" alt="Корзина">
                        <span>Корзина: <span id="cart-count">0 товаров</span></span>
                    </div>
                    <div class="info-item">
                        <img src="../images/Vector (1).png" alt="Избранное">
                        <span>Избранное: <span id="favorite-count">0 товаров</span></span>
                    </div>
                </div>

                <!-- Адрес доставки -->
                <div class="delivery-address">
                    <p><strong>Адрес доставки:</strong> <span id="current-address">не указан</span></p>
                    <button id="edit-address" class="edit-btn">Указать адрес</button>
                </div>

                <!-- Пример товара для добавления 
                <div class="sample-product">
                    <h3>Добавить товар для тестирования</h3>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="../images/wine1.jpg" alt="Вино Luigi Bosca">
                        </div>
                        <div class="product-info">
                            <h4>Вино Luigi Bosca, 2024</h4>
                            <p class="product-price">2990₽</p>
                            <div class="product-actions">
                                <button class="add-to-cart-btn" data-product='{"id":1,"name":"Вино Luigi Bosca, 2024","price":2990,"image":"../images/wine1.jpg"}'>
                                    В корзину
                                </button>
                                <button class="add-to-favorite-btn" data-product='{"id":1,"name":"Вино Luigi Bosca, 2024","price":2990,"image":"../images/wine1.jpg"}'>
                                    ❤️ В избранное
                                </button>
                            </div>
                        </div>
                    </div>
                </div>-->
            </section>

            <!-- Секция корзины -->
            <section class="cart-section">
                <h2>Товары в корзине</h2>
                <!-- Информация о заказе (появляется после подтверждения адреса) -->
                <div id="order-info" class="order-info-card" style="display: none;">
                    <h3>Информация о заказе</h3>
                    <p><strong>Номер заказа:</strong> <span id="order-number">-</span></p>
                    <p><strong>Дата оформления:</strong> <span id="order-date">-</span></p>
                    <p><strong>Адрес доставки:</strong> <span id="order-address">-</span></p>
                </div>

                <div class="cart-items" id="cart-items-container">
                    <p class="empty-cart">Ваша корзина пуста</p>
                </div>
                <div class="cart-total">
                    <p><strong>Сумма:</strong> <span id="total-amount">0₽</span></p>
                    <button id="checkout-btn" class="checkout-btn" disabled>Перейти к оплате</button>
                </div>

                <!-- Секция избранного -->
                <div class="favorites-section">
                    <h3>Избранные товары</h3>
                    <div class="favorite-items" id="favorite-items-container">
                        <p class="empty-favorites">У вас нет избранных товаров</p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Модальное окно изменения адреса -->
    <div id="address-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Указание адреса доставки</h2>
            <form id="address-form">
                <label for="address">Адрес доставки:</label>
                <input type="text" id="address" name="address" placeholder="Введите ваш адрес" required>
                <p class="note">Примечание: Адрес можно изменить только один раз после первого указания</p>
                <button type="submit" id="save-address">Сохранить адрес</button>
            </form>
        </div>
    </div>

    <!-- Модальное окно редактирования профиля -->
    <div id="profile-modal" class="modal">
        <div class="profile-modal-content">
            <span class="close">&times;</span>
            <h2 id="profile-modal-title">Редактирование профиля</h2>
            
            <div class="profile-form-container">
                <!-- Поле имени -->
                <div id="name-field" class="form-field-group" style="display: none;">
                    <label for="edit-name">Имя и фамилия:</label>
                    <input type="text" id="edit-name" class="form-field-input name-input" 
                          placeholder="Введите ваше имя и фамилию" required
                          minlength="2" maxlength="50">
                    <div class="form-hint">Минимум 2 символа, максимум 50 символов</div>
                    <div class="form-error" id="name-error">Пожалуйста, введите корректное имя</div>
                </div>
                
                <!-- Поле телефона -->
                <div id="phone-field" class="form-field-group" style="display: none;">
                    <label for="edit-phone">Номер телефона:</label>
                    <input type="tel" id="edit-phone" class="form-field-input phone-input" 
                          placeholder="+7 (XXX) XXX-XX-XX" required
                          pattern="\+7\s?[\(]{0,1}[0-9]{3}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}">
                    <div class="form-hint">Формат: +7 (XXX) XXX-XX-XX</div>
                    <div class="form-error" id="phone-error">Пожалуйста, введите корректный номер телефона</div>
                </div>
                
                <!-- Поле email -->
                <div id="email-field" class="form-field-group" style="display: none;">
                    <label for="edit-email">Email адрес:</label>
                    <input type="email" id="edit-email" class="form-field-input email-input" 
                          placeholder="your@email.com" required
                          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    <div class="form-hint">Введите действительный email адрес</div>
                    <div class="form-error" id="email-error">Пожалуйста, введите корректный email адрес</div>
                </div>
                
                <div class="form-buttons">
                    <button type="button" class="cancel-profile-btn">Отмена</button>
                    <button type="submit" id="save-profile" class="save-profile-btn">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/user.js"></script>
</body>
</html>