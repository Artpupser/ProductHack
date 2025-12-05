// JavaScript для личного кабинета пользователя

document.addEventListener('DOMContentLoaded', function() {
    // Элементы модальных окон
    const addressModal = document.getElementById('address-modal');
    const profileModal = document.getElementById('profile-modal');
    const editAddressBtn = document.getElementById('edit-address');
    const closeButtons = document.querySelectorAll('.close');
    const saveAddressBtn = document.getElementById('save-address');
    const addressForm = document.getElementById('address-form');
    const profileForm = document.getElementById('profile-form');
    const checkoutBtn = document.getElementById('checkout-btn');
    
    // Элементы для редактирования профиля
    const changeAvatarBtn = document.getElementById('change-avatar');
    const avatarUpload = document.getElementById('avatar-upload');
    const avatarImg = document.getElementById('avatar-img');
    const editFieldBtns = document.querySelectorAll('.edit-field-btn');
    
    // Элементы информации о заказе
    const orderInfoCard = document.getElementById('order-info');
    const orderNumber = document.getElementById('order-number');
    const orderDate = document.getElementById('order-date');
    const orderAddress = document.getElementById('order-address');
    
    // Элементы для работы с товарами
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    const addToFavoriteBtns = document.querySelectorAll('.add-to-favorite-btn');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const favoriteItemsContainer = document.getElementById('favorite-items-container');
    const cartCountElement = document.getElementById('cart-count');
    const favoriteCountElement = document.getElementById('favorite-count');
    const discountValueElement = document.getElementById('discount-value');
    
    // Проверка, был ли уже изменен адрес
    let addressChanged = localStorage.getItem('addressChanged') === 'true';
    let currentEditingField = null;

    // Инициализация страницы
    initPage();

    // Обработчики событий
    editAddressBtn.addEventListener('click', openAddressModal);
    closeButtons.forEach(btn => btn.addEventListener('click', closeModals));
    addressForm.addEventListener('submit', saveAddress);
    profileForm.addEventListener('submit', saveProfile);
    changeAvatarBtn.addEventListener('click', triggerAvatarUpload);
    avatarUpload.addEventListener('change', handleAvatarUpload);
    editFieldBtns.forEach(btn => btn.addEventListener('click', openProfileModal));
    
    // Обработчики для товаров
    addToCartBtns.forEach(btn => btn.addEventListener('click', addToCart));
    addToFavoriteBtns.forEach(btn => btn.addEventListener('click', addToFavorite));
    
    // Закрытие модальных окон при клике вне их
    window.addEventListener('click', function(event) {
        if (event.target === addressModal) closeModals();
        if (event.target === profileModal) closeModals();
    });

    // Инициализация состояния страницы
    function initPage() {
        // Загрузка данных пользователя из localStorage
        loadUserData();
        
        // Блокировка кнопки изменения адреса, если адрес уже был изменен
        if (addressChanged) {
            disableAddressEditing();
        }
        
        // Загрузка товаров в корзине и избранном
        loadCartItems();
        loadFavoriteItems();
        updateCounters();
        updateDiscount();
    }

    // Загрузка данных пользователя
    function loadUserData() {
        const userName = localStorage.getItem('userName') || 'Пользователь';
        const userPhone = localStorage.getItem('userPhone') || '+7 (XXX) XXX-XX-XX';
        const userEmail = localStorage.getItem('userEmail') || 'user@example.com';
        const userAvatar = localStorage.getItem('userAvatar');
        const userAddress = localStorage.getItem('userAddress');
        
        // Установка значений
        document.getElementById('user-name').textContent = userName;
        document.getElementById('user-phone').textContent = userPhone;
        document.getElementById('user-email').textContent = userEmail;
        if (userAvatar) avatarImg.src = userAvatar;
        if (userAddress) {
            document.getElementById('current-address').textContent = userAddress;
            // Показываем информацию о заказе, если адрес уже указан
            showOrderInfo();
        }
    }

    // Открытие модального окна изменения адреса
    function openAddressModal() {
        if (!addressChanged) {
            addressModal.style.display = 'block';
        }
    }

    // Обновленные функции для работы с модальными окнами профиля

    // Открытие модального окна редактирования профиля
    function openProfileModal(event) {
        const field = event.target.getAttribute('data-field');
        currentEditingField = field;
        
        // Скрываем все поля формы
        document.querySelectorAll('.form-field-group').forEach(field => {
            field.style.display = 'none';
        });
        
        // Показываем нужное поле
        const fieldElement = document.getElementById(`${field}-field`);
        fieldElement.style.display = 'block';
        
        // Устанавливаем заголовок модального окна
        const modalTitle = document.getElementById('profile-modal-title');
        modalTitle.textContent = `Редактирование ${getFieldLabel(field)}`;
        
        // Заполняем поле текущим значением и настраиваем валидацию
        const currentValue = document.getElementById(`user-${field}`).textContent;
        const inputElement = document.getElementById(`edit-${field}`);
        
        inputElement.value = currentValue;
        inputElement.classList.remove('error');
        document.getElementById(`${field}-error`).style.display = 'none';
        
        // Настраиваем специфические параметры для каждого поля
        setupFieldValidation(field, inputElement);
        
        // Фокус на поле ввода
        setTimeout(() => {
            inputElement.focus();
            // Для телефона перемещаем курсор в конец
            if (field === 'phone') {
                inputElement.setSelectionRange(inputElement.value.length, inputElement.value.length);
            }
        }, 100);
        
        profileModal.style.display = 'block';
    }

    // Настройка валидации для разных полей
    function setupFieldValidation(field, inputElement) {
        // Очищаем предыдущие обработчики
        inputElement.oninput = null;
        inputElement.onblur = null;
        
        switch(field) {
            case 'name':
                setupNameValidation(inputElement);
                break;
            case 'phone':
                setupPhoneValidation(inputElement);
                break;
            case 'email':
                setupEmailValidation(inputElement);
                break;
        }
    }

    // Валидация имени
    function setupNameValidation(inputElement) {
        inputElement.oninput = function() {
            // Убираем лишние пробелы
            this.value = this.value.replace(/\s+/g, ' ').trimStart();
            
            // Проверяем валидность
            const isValid = this.value.length >= 2 && this.value.length <= 50;
            updateFieldValidity('name', isValid);
        };
        
        inputElement.onblur = function() {
            // Убираем пробелы в начале и конце
            this.value = this.value.trim();
            const isValid = this.value.length >= 2 && this.value.length <= 50;
            updateFieldValidity('name', isValid);
        };
    }

    // Валидация телефона
    function setupPhoneValidation(inputElement) {
        inputElement.oninput = function() {
            // Форматирование телефона в реальном времени
            let value = this.value.replace(/\D/g, '');
            
            if (value.startsWith('7') || value.startsWith('8')) {
                value = value.substring(1);
            }
            
            let formattedValue = '+7 (';
            
            if (value.length > 0) {
                formattedValue += value.substring(0, 3);
            }
            if (value.length > 3) {
                formattedValue += ') ' + value.substring(3, 6);
            }
            if (value.length > 6) {
                formattedValue += '-' + value.substring(6, 8);
            }
            if (value.length > 8) {
                formattedValue += '-' + value.substring(8, 10);
            }
            
            this.value = formattedValue;
            
            // Проверяем валидность
            const phoneRegex = /\+7\s?[\(]{0,1}[0-9]{3}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}/;
            const isValid = phoneRegex.test(this.value) && this.value.replace(/\D/g, '').length === 11;
            updateFieldValidity('phone', isValid);
        };
    }

    // Валидация email
    function setupEmailValidation(inputElement) {
        inputElement.oninput = function() {
            // Приводим к нижнему регистру
            this.value = this.value.toLowerCase();
            
            // Проверяем валидность
            const emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
            const isValid = emailRegex.test(this.value);
            updateFieldValidity('email', isValid);
        };
    }

    // Обновление состояния валидации поля
    function updateFieldValidity(field, isValid) {
        const inputElement = document.getElementById(`edit-${field}`);
        const errorElement = document.getElementById(`${field}-error`);
        const saveButton = document.getElementById('save-profile');
        
        if (isValid) {
            inputElement.classList.remove('error');
            errorElement.style.display = 'none';
            saveButton.disabled = false;
        } else {
            inputElement.classList.add('error');
            errorElement.style.display = 'block';
            saveButton.disabled = true;
        }
    }

    // Закрытие всех модальных окон
    function closeModals() {
        addressModal.style.display = 'none';
        profileModal.style.display = 'none';
        
        // Сбрасываем состояния полей
        document.querySelectorAll('.form-field-input').forEach(input => {
            input.classList.remove('error');
        });
        document.querySelectorAll('.form-error').forEach(error => {
            error.style.display = 'none';
        });
    }

    // Сохранение данных профиля
    function saveProfile(e) {
        e.preventDefault();
        
        if (!currentEditingField) return;
        
        const inputElement = document.getElementById(`edit-${currentEditingField}`);
        const inputValue = inputElement.value.trim();
        
        // Финальная проверка валидности
        let isValid = false;
        
        switch(currentEditingField) {
            case 'name':
                isValid = inputValue.length >= 2 && inputValue.length <= 50;
                break;
            case 'phone':
                const phoneRegex = /\+7\s?[\(]{0,1}[0-9]{3}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}/;
                isValid = phoneRegex.test(inputValue) && inputValue.replace(/\D/g, '').length === 11;
                break;
            case 'email':
                const emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
                isValid = emailRegex.test(inputValue);
                break;
        }
        
        if (!isValid) {
            updateFieldValidity(currentEditingField, false);
            inputElement.focus();
            return;
        }
        
        if (inputValue) {
            // Сохранение в localStorage
            localStorage.setItem(`user${currentEditingField.charAt(0).toUpperCase() + currentEditingField.slice(1)}`, inputValue);
            
            // Обновление отображаемого значения
            const displayElement = document.getElementById(`user-${currentEditingField}`);
            displayElement.textContent = inputValue;
            
            // Убираем размытие, если поле было размыто
            displayElement.classList.remove('blurred');
            
            // Закрываем модальное окно
            closeModals();
            
            // Показываем сообщение об успехе
            showNotification('Данные успешно сохранены!', 'success');
        }
    }

    // Функция для показа уведомлений
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            background: ${type === 'success' ? '#4caf50' : '#2196f3'};
            color: white;
            border-radius: 5px;
            z-index: 1001;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            animation: slideInRight 0.3s ease-out;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Добавляем CSS для анимации уведомлений
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    // Обновляем обработчики событий в initPage()
    function initPage() {
        // ... существующий код ...
        
        // Добавляем обработчики для кнопок отмены
        document.querySelector('.cancel-profile-btn').addEventListener('click', closeModals);
        
        // Добавляем обработчик для клавиши Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModals();
            }
        });
    }

    // Получение читаемого названия поля
    function getFieldLabel(field) {
        const labels = {
            'name': 'имени',
            'phone': 'телефона',
            'email': 'email'
        };
        return labels[field] || 'поля';
    }

    // Закрытие всех модальных окон
    function closeModals() {
        addressModal.style.display = 'none';
        profileModal.style.display = 'none';
    }

    // Сохранение адреса
    function saveAddress(e) {
        e.preventDefault();
        
        const addressInput = document.getElementById('address');
        const newAddress = addressInput.value.trim();
        
        if (newAddress) {
            // Сохранение адреса в localStorage
            localStorage.setItem('userAddress', newAddress);
            document.getElementById('current-address').textContent = newAddress;
            
            // Отмечаем, что адрес был изменен
            addressChanged = true;
            localStorage.setItem('addressChanged', 'true');
            
            // Блокируем дальнейшее редактирование адреса
            disableAddressEditing();
            
            // Закрываем модальное окно
            closeModals();
            
            // Показываем информацию о заказе
            showOrderInfo();
            
            // Показываем сообщение об успехе
            alert('Адрес успешно сохранен!');
        }
    }

    // Блокировка редактирования адреса
    function disableAddressEditing() {
        editAddressBtn.disabled = true;
        editAddressBtn.textContent = 'Адрес сохранен';
        editAddressBtn.style.backgroundColor = '#ccc';
    }

    // Сохранение данных профиля
    function saveProfile(e) {
        e.preventDefault();
        
        if (!currentEditingField) return;
        
        const inputValue = document.getElementById(`edit-${currentEditingField}`).value.trim();
        
        if (inputValue) {
            // Сохранение в localStorage
            localStorage.setItem(`user${currentEditingField.charAt(0).toUpperCase() + currentEditingField.slice(1)}`, inputValue);
            
            // Обновление отображаемого значения
            document.getElementById(`user-${currentEditingField}`).textContent = inputValue;
            
            // Убираем размытие, если поле было размыто
            document.getElementById(`user-${currentEditingField}`).classList.remove('blurred');
            
            // Закрываем модальное окно
            closeModals();
            
            // Показываем сообщение об успехе
            alert('Данные успешно сохранены!');
        }
    }

    // Загрузка аватара
    function triggerAvatarUpload() {
        avatarUpload.click();
    }

    function handleAvatarUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Сохранение аватара в localStorage
                localStorage.setItem('userAvatar', e.target.result);
                avatarImg.src = e.target.result;
                alert('Аватар успешно изменен!');
            };
            reader.readAsDataURL(file);
        }
    }

    // Показ информации о заказе
    function showOrderInfo() {
        const address = localStorage.getItem('userAddress');
        if (address) {
            // Генерация номера заказа (в реальном приложении это делается на сервере)
            const generatedOrderNumber = 'ORD' + Date.now().toString().slice(-6);
            const currentDate = new Date().toLocaleDateString('ru-RU');
            
            orderNumber.textContent = generatedOrderNumber;
            orderDate.textContent = currentDate;
            orderAddress.textContent = address;
            
            orderInfoCard.style.display = 'block';
        }
    }

    // Добавление товара в корзину
    function addToCart(event) {
        const productData = JSON.parse(event.target.getAttribute('data-product'));
        
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        
        // Проверяем, есть ли товар уже в корзине
        const existingItemIndex = cartItems.findIndex(item => item.id === productData.id);
        
        if (existingItemIndex !== -1) {
            // Увеличиваем количество, если товар уже есть
            cartItems[existingItemIndex].quantity += 1;
        } else {
            // Добавляем новый товар
            cartItems.push({
                ...productData,
                quantity: 1
            });
        }
        
        // Сохраняем в localStorage
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        
        // Обновляем отображение корзины
        loadCartItems();
        updateCounters();
        updateDiscount();
        
        alert('Товар добавлен в корзину!');
    }

    // Добавление товара в избранное
    function addToFavorite(event) {
        const productData = JSON.parse(event.target.getAttribute('data-product'));
        
        let favoriteItems = JSON.parse(localStorage.getItem('favoriteItems')) || [];
        
        // Проверяем, есть ли товар уже в избранном
        const existingItemIndex = favoriteItems.findIndex(item => item.id === productData.id);
        
        if (existingItemIndex === -1) {
            // Добавляем новый товар
            favoriteItems.push({
                ...productData,
                addedDate: new Date().toISOString()
            });
            
            // Сохраняем в localStorage
            localStorage.setItem('favoriteItems', JSON.stringify(favoriteItems));
            
            // Обновляем отображение избранного
            loadFavoriteItems();
            updateCounters();
            
            alert('Товар добавлен в избранное!');
        } else {
            alert('Этот товар уже в избранном!');
        }
    }

    // Изменение количества товара в корзине
    function updateCartQuantity(productId, change) {
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const itemIndex = cartItems.findIndex(item => item.id === productId);
        
        if (itemIndex !== -1) {
            cartItems[itemIndex].quantity += change;
            
            // Удаляем товар, если количество стало 0 или меньше
            if (cartItems[itemIndex].quantity <= 0) {
                cartItems.splice(itemIndex, 1);
            }
            
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            loadCartItems();
            updateCounters();
            updateDiscount();
        }
    }

    // Перемещение товара из корзины в избранное
    function moveToFavorites(productId) {
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        let favoriteItems = JSON.parse(localStorage.getItem('favoriteItems')) || [];
        
        const itemIndex = cartItems.findIndex(item => item.id === productId);
        
        if (itemIndex !== -1) {
            const item = cartItems[itemIndex];
            
            // Проверяем, нет ли уже этого товара в избранном
            const existsInFavorites = favoriteItems.some(favItem => favItem.id === productId);
            
            if (!existsInFavorites) {
                // Добавляем в избранное
                favoriteItems.push({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    image: item.image,
                    addedDate: new Date().toISOString()
                });
                
                localStorage.setItem('favoriteItems', JSON.stringify(favoriteItems));
            }
            
            // Удаляем из корзины
            cartItems.splice(itemIndex, 1);
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            
            // Обновляем отображение
            loadCartItems();
            loadFavoriteItems();
            updateCounters();
            updateDiscount();
            
            alert('Товар перемещен в избранное!');
        }
    }

    // Добавление товара из избранного в корзину
    function addToCartFromFavorites(productId) {
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        let favoriteItems = JSON.parse(localStorage.getItem('favoriteItems')) || [];
        
        const itemIndex = favoriteItems.findIndex(item => item.id === productId);
        
        if (itemIndex !== -1) {
            const item = favoriteItems[itemIndex];
            
            // Проверяем, есть ли товар уже в корзине
            const existingCartItemIndex = cartItems.findIndex(cartItem => cartItem.id === productId);
            
            if (existingCartItemIndex !== -1) {
                // Увеличиваем количество
                cartItems[existingCartItemIndex].quantity += 1;
            } else {
                // Добавляем новый товар
                cartItems.push({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    image: item.image,
                    quantity: 1
                });
            }
            
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            loadCartItems();
            updateCounters();
            updateDiscount();
            
            alert('Товар добавлен в корзину!');
        }
    }

    // Удаление товара из корзины
    function removeFromCart(productId) {
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        cartItems = cartItems.filter(item => item.id !== productId);
        
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        loadCartItems();
        updateCounters();
        updateDiscount();
    }

    // Удаление товара из избранного
    function removeFromFavorite(productId) {
        let favoriteItems = JSON.parse(localStorage.getItem('favoriteItems')) || [];
        favoriteItems = favoriteItems.filter(item => item.id !== productId);
        
        localStorage.setItem('favoriteItems', JSON.stringify(favoriteItems));
        loadFavoriteItems();
        updateCounters();
    }

    // Загрузка товаров в корзине
    function loadCartItems() {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        
        if (cartItems.length > 0) {
            // Очищаем сообщение о пустой корзине
            cartItemsContainer.innerHTML = '';
            
            // Добавляем товары в корзину
            let total = 0;
            
            cartItems.forEach(item => {
                const cartItemElement = document.createElement('div');
                cartItemElement.className = 'cart-item';
                cartItemElement.innerHTML = `
                    <div class="cart-item-image">
                        <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="cart-item-info">
                        <h4>${item.name}</h4>
                        <p class="cart-item-price">${item.price}₽</p>
                        <div class="cart-item-quantity">
                            <button class="quantity-btn minus-btn" data-id="${item.id}">-</button>
                            <span class="quantity-value">${item.quantity}</span>
                            <button class="quantity-btn plus-btn" data-id="${item.id}">+</button>
                        </div>
                    </div>
                    <div class="cart-item-actions">
                        <button class="move-to-favorites-btn" data-id="${item.id}">В избранное</button>
                        <button class="remove-from-cart-btn" data-id="${item.id}">Удалить</button>
                    </div>
                `;
                cartItemsContainer.appendChild(cartItemElement);
                
                total += item.price * item.quantity;
            });
            
            // Добавляем обработчики для кнопок
            document.querySelectorAll('.minus-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    updateCartQuantity(productId, -1);
                });
            });
            
            document.querySelectorAll('.plus-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    updateCartQuantity(productId, 1);
                });
            });
            
            document.querySelectorAll('.move-to-favorites-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    moveToFavorites(productId);
                });
            });
            
            document.querySelectorAll('.remove-from-cart-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    removeFromCart(productId);
                });
            });
            
            // Обновляем общую сумму
            document.getElementById('total-amount').textContent = total + '₽';
            
            // Активируем кнопку оформления заказа
            checkoutBtn.disabled = false;
        } else {
            // Показываем сообщение о пустой корзине
            cartItemsContainer.innerHTML = '<p class="empty-cart">Ваша корзина пуста</p>';
            document.getElementById('total-amount').textContent = '0₽';
            checkoutBtn.disabled = true;
        }
    }

    // Загрузка избранных товаров
    function loadFavoriteItems() {
        const favoriteItems = JSON.parse(localStorage.getItem('favoriteItems')) || [];
        
        if (favoriteItems.length > 0) {
            // Очищаем сообщение о пустом избранном
            favoriteItemsContainer.innerHTML = '';
            
            // Добавляем товары в избранное
            favoriteItems.forEach(item => {
                const favoriteItemElement = document.createElement('div');
                favoriteItemElement.className = 'favorite-item';
                favoriteItemElement.innerHTML = `
                    <div class="favorite-item-image">
                        <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="favorite-item-info">
                        <h4>${item.name}</h4>
                        <p class="favorite-item-price">${item.price}₽</p>
                    </div>
                    <div class="favorite-item-actions">
                        <button class="add-to-cart-from-fav-btn" data-id="${item.id}">В корзину</button>
                        <button class="remove-from-favorites-btn" data-id="${item.id}">Удалить</button>
                    </div>
                `;
                favoriteItemsContainer.appendChild(favoriteItemElement);
            });
            
            // Добавляем обработчики для кнопок
            document.querySelectorAll('.add-to-cart-from-fav-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    addToCartFromFavorites(productId);
                });
            });
            
            document.querySelectorAll('.remove-from-favorites-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    removeFromFavorite(productId);
                });
            });
        } else {
            // Показываем сообщение о пустом избранном
            favoriteItemsContainer.innerHTML = '<p class="empty-favorites">У вас нет избранных товаров</p>';
        }
    }

    // Обновление счетчиков
    function updateCounters() {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const favoriteItems = JSON.parse(localStorage.getItem('favoriteItems')) || [];
        
        const totalCartItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        const totalFavoriteItems = favoriteItems.length;
        
        cartCountElement.textContent = `${totalCartItems} ${getNoun(totalCartItems, 'товар', 'товара', 'товаров')}`;
        favoriteCountElement.textContent = `${totalFavoriteItems} ${getNoun(totalFavoriteItems, 'товар', 'товара', 'товаров')}`;
    }

    // Обновление скидки
    function updateDiscount() {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        
        // Простая логика скидки: чем больше товаров, тем больше скидка
        let discount = 0;
        if (totalItems >= 10) discount = 15;
        else if (totalItems >= 5) discount = 10;
        else if (totalItems >= 3) discount = 5;
        
        discountValueElement.textContent = `${discount}%`;
    }

    // Вспомогательная функция для склонения существительных
    function getNoun(number, one, two, five) {
        let n = Math.abs(number);
        n %= 100;
        if (n >= 5 && n <= 20) {
            return five;
        }
        n %= 10;
        if (n === 1) {
            return one;
        }
        if (n >= 2 && n <= 4) {
            return two;
        }
        return five;
    }

    // Обработчик кнопки оформления заказа
    checkoutBtn.addEventListener('click', function() {
        // В реальном приложении здесь был бы переход на страницу оплаты
        alert('Переход к оплате...');
        // window.location.href = 'payment.html';
    });

    // Функции для тестирования (можно удалить в продакшене)
    window.clearCart = function() {
        localStorage.removeItem('cartItems');
        loadCartItems();
        updateCounters();
        updateDiscount();
    };

    window.clearFavorites = function() {
        localStorage.removeItem('favoriteItems');
        loadFavoriteItems();
        updateCounters();
    };
});
// Функция для адаптивного поведения при добавлении товара
function handleResponsiveCartBehavior() {
    const cartSection = document.querySelector('.cart-section');
    const isMobile = window.innerWidth <= 900;
    
    if (isMobile) {
        // На мобильных устройствах добавляем анимацию к корзине
        cartSection.classList.add('highlight');
        
        // Прокручиваем к корзине
        setTimeout(() => {
            cartSection.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 300);
        
        // Убираем подсветку после анимации
        setTimeout(() => {
            cartSection.classList.remove('highlight');
        }, 2000);
    }
}

// Обновленная функция добавления в корзину
function addToCart(event) {
    const productData = JSON.parse(event.target.getAttribute('data-product'));
    
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    
    // Проверяем, есть ли товар уже в корзине
    const existingItemIndex = cartItems.findIndex(item => item.id === productData.id);
    
    if (existingItemIndex !== -1) {
        // Увеличиваем количество, если товар уже есть
        cartItems[existingItemIndex].quantity += 1;
    } else {
        // Добавляем новый товар
        cartItems.push({
            ...productData,
            quantity: 1
        });
    }
    
    // Сохраняем в localStorage
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    
    // Обновляем отображение корзины
    loadCartItems();
    updateCounters();
    updateDiscount();
    
    // Адаптивное поведение
    handleResponsiveCartBehavior();
    
    showNotification('Товар добавлен в корзину!', 'success');
}

// Обновленная функция добавления из избранного в корзину
function addToCartFromFavorites(productId) {
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    let favoriteItems = JSON.parse(localStorage.getItem('favoriteItems')) || [];
    
    const itemIndex = favoriteItems.findIndex(item => item.id === productId);
    
    if (itemIndex !== -1) {
        const item = favoriteItems[itemIndex];
        
        // Проверяем, есть ли товар уже в корзине
        const existingCartItemIndex = cartItems.findIndex(cartItem => cartItem.id === productId);
        
        if (existingCartItemIndex !== -1) {
            // Увеличиваем количество
            cartItems[existingCartItemIndex].quantity += 1;
        } else {
            // Добавляем новый товар
            cartItems.push({
                id: item.id,
                name: item.name,
                price: item.price,
                image: item.image,
                quantity: 1
            });
        }
        
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        loadCartItems();
        updateCounters();
        updateDiscount();
        
        // Адаптивное поведение
        handleResponsiveCartBehavior();
        
        showNotification('Товар добавлен в корзину!', 'success');
    }
}

// Функция для улучшенного взаимодействия с профилем
function enhanceProfileInteraction() {
    const profileFields = document.querySelectorAll('.profile-field');
    
    profileFields.forEach(field => {
        const spanElement = field.querySelector('span');
        const editButton = field.querySelector('.edit-field-btn');
        
        // Добавляем обработчик клика на все поле (кроме кнопки редактирования)
        field.addEventListener('click', (e) => {
            if (e.target !== editButton && !editButton.contains(e.target)) {
                if (spanElement.classList.contains('blurred')) {
                    // Временно показываем размытые данные
                    const originalFilter = spanElement.style.filter;
                    spanElement.style.filter = 'blur(0)';
                    
                    setTimeout(() => {
                        if (spanElement.style.filter === 'blur(0)') {
                            spanElement.style.filter = originalFilter;
                        }
                    }, 2000);
                }
            }
        });
        
        // Улучшенная доступность для кнопок редактирования
        editButton.setAttribute('aria-label', `Редактировать ${field.querySelector('label').textContent}`);
        editButton.setAttribute('title', `Редактировать ${field.querySelector('label').textContent}`);
    });
}

// Функция для обработки изменения размера окна
function handleWindowResize() {
    // Перезагружаем корзину при изменении размера для адаптивности
    loadCartItems();
    loadFavoriteItems();
}

// Обновленная функция инициализации
function initPage() {
    // Загрузка данных пользователя из localStorage
    loadUserData();
    
    // Блокировка кнопки изменения адреса, если адрес уже был изменен
    if (addressChanged) {
        disableAddressEditing();
    }
    
    // Загрузка товаров в корзине и избранном
    loadCartItems();
    loadFavoriteItems();
    updateCounters();
    updateDiscount();
    
    // Улучшенное взаимодействие с профилем
    enhanceProfileInteraction();
    
    // Обработчик изменения размера окна
    window.addEventListener('resize', handleWindowResize);
    
    // Добавляем обработчики для кнопок отмены
    document.querySelector('.cancel-profile-btn')?.addEventListener('click', closeModals);
    
    // Добавляем обработчик для клавиши Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModals();
        }
    });
}

// Функция для показа состояния загрузки
function setProfileFieldLoading(field, isLoading) {
    const fieldElement = document.querySelector(`[data-field="${field}"]`).closest('.profile-field');
    const spanElement = fieldElement.querySelector('span');
    const buttonElement = fieldElement.querySelector('.edit-field-btn');
    
    if (isLoading) {
        fieldElement.classList.add('loading');
        buttonElement.disabled = true;
        spanElement.textContent = 'Загрузка...';
    } else {
        fieldElement.classList.remove('loading');
        buttonElement.disabled = false;
    }
}

// Обновленная функция сохранения профиля с индикацией загрузки
function saveProfile(e) {
    e.preventDefault();
    
    if (!currentEditingField) return;
    
    const inputElement = document.getElementById(`edit-${currentEditingField}`);
    const inputValue = inputElement.value.trim();
    
    // Финальная проверка валидности
    let isValid = false;
    
    switch(currentEditingField) {
        case 'name':
            isValid = inputValue.length >= 2 && inputValue.length <= 50;
            break;
        case 'phone':
            const phoneRegex = /\+7\s?[\(]{0,1}[0-9]{3}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}/;
            isValid = phoneRegex.test(inputValue) && inputValue.replace(/\D/g, '').length === 11;
            break;
        case 'email':
            const emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
            isValid = emailRegex.test(inputValue);
            break;
    }
    
    if (!isValid) {
        updateFieldValidity(currentEditingField, false);
        inputElement.focus();
        return;
    }
    
    if (inputValue) {
        // Показываем состояние загрузки
        setProfileFieldLoading(currentEditingField, true);
        
        // Имитируем задержку сети (в реальном приложении здесь был бы запрос к серверу)
        setTimeout(() => {
            // Сохранение в localStorage
            localStorage.setItem(`user${currentEditingField.charAt(0).toUpperCase() + currentEditingField.slice(1)}`, inputValue);
            
            // Обновление отображаемого значения
            const displayElement = document.getElementById(`user-${currentEditingField}`);
            displayElement.textContent = inputValue;
            
            // Убираем размытие, если поле было размыто
            displayElement.classList.remove('blurred');
            
            // Сбрасываем состояние загрузки
            setProfileFieldLoading(currentEditingField, false);
            
            // Закрываем модальное окно
            closeModals();
            
            // Показываем сообщение об успехе
            showNotification('Данные успешно сохранены!', 'success');
        }, 800);
    }
}