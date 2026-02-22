function getCart() {
	const formData = new FormData();
	fetch('./api/cart/get', {
		method: 'POST',
		body: formData
	})
	.then(response => {
		if (!response.ok) throw new Error(`${response.status}`);
		return response.json();
	})
	.then(data => {
		console.log("Корзина:", data["result"]);
		updateCartTotal(data.total);
	})
	.catch(err => console.error(err));
}

function updateCartTotal(total) {
	const totalElem = document.getElementById('cart-total-price');
	if (totalElem && total !== undefined) totalElem.textContent = total + " ₽";
}

function clearCart() {
	const formData = new FormData();
	fetch('./api/cart/clear', {
		method: 'POST',
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		console.log("Корзина очищена:", data);
		updateCartTotal(0);
		document.getElementById('cart-list').innerHTML = '';
	})
	.catch(err => console.error(err));
}

function removeFromCart(id) {
	const formData = new FormData();
	formData.append('id', id);

	fetch('./api/cart/delete', {
		method: 'POST',
		body: formData
	})
	.then(r => r.json())
	.then(data => {
		console.log("Удалено из корзины:", data);
		const item = document.querySelector(`.remove-item[data-id='${id}']`).closest('.content_card_prod');
		if (item) item.remove();
		if (data.total !== undefined) updateCartTotal(data.total);
	})
	.catch(err => console.error(err));
}

function changeCart(id, cost, enable = true, quantity = 1) {
	const formData = new FormData();
	formData.append('id', id);
	formData.append('cost', cost);
	formData.append('enable', enable ? 1 : 0);
	formData.append('quantity', quantity);

	fetch('./api/cart/change', {
		method: 'POST',
		body: formData
	})
	.then(response => {
		if (!response.ok) throw new Error(`${response.status}`);
		return response.json();
	})
	.then(data => {
		console.log("Обновлено в корзине:", data["result"]);
		if (data.total !== undefined) updateCartTotal(data.total);
	})
	.catch(err => console.error(err));
}

document.querySelectorAll('.add-to-cart').forEach(btn => {
	btn.addEventListener('click', () => {
		const card = btn.closest('.card');
		const id = card.dataset.id;
		const priceText = card.querySelector('.price_card').textContent;
		const cost = parseFloat(priceText.replace('₽','').trim());
		const quantity = parseInt(card.querySelector('.qty-number').textContent);

		changeCart(id, cost, true, quantity);
	});
});

document.querySelectorAll('.card').forEach(card => {
	const minus = card.querySelector('.qty-btn.minus');
	const plus = card.querySelector('.qty-btn.plus');
	const number = card.querySelector('.qty-number');

	if (minus && plus && number) {
		minus.addEventListener('click', () => {
			let qty = parseInt(number.textContent);
			if (qty > 1) number.textContent = qty - 1;
		});
		plus.addEventListener('click', () => {
			let qty = parseInt(number.textContent);
			number.textContent = qty + 1;
		});
	}
});

document.querySelectorAll('.remove-item').forEach(btn => {
	btn.addEventListener('click', () => {
		removeFromCart(btn.dataset.id);
	});
});

document.querySelectorAll('.change-enable').forEach(btn => {
	btn.addEventListener('click', () => {
		const id = btn.dataset.id;
		const cost = parseFloat(btn.dataset.cost);
		let enable = btn.dataset.enable === "1";

		enable = !enable;
		btn.dataset.enable = enable ? "1" : "0";

		changeCart(id, cost, enable);
	});
});

getCart();