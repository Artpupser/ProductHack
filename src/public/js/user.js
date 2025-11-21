/*Генерация номера заказа*/
document.getElementById("orderNumber").textContent =
    Math.floor(Math.random() * 90000) + 10000;


/*Сохранить профиль*/
function saveProfile() {
    alert("Профиль сохранён!");
}


/*Подтвердить доставку*/
function confirmDelivery() {
    let input = document.getElementById("deliveryAddress");

    if (input.value.trim() === "") {
        alert("Введите адрес доставки.");
        return;
    }

    input.disabled = true;

    // Дата заказа
    let today = new Date().toLocaleDateString();
    document.getElementById("orderDate").textContent = today;

    alert("Адрес подтверждён!");
}


/*Корзина / сумма*/

let cart = []; // Пока товаров нет!

function updateSum() {
    if (cart.length === 0) {
        document.getElementById("orderSumBlock").style.display = "none";
        return;
    }

    let total = cart.reduce((acc, item) => acc + item.price, 0);

    document.getElementById("orderSum").textContent = total;
    document.getElementById("orderSumBlock").style.display = "block";
}

updateSum();