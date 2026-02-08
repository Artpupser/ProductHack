function get() {
	const formData = new FormData();
	fetch('./api/cart/get', {
		method: 'POST',
		body: formData
	}).then(response => {
		if (!response.ok) {
			throw new Error(`${response.status}`);
		}
		return response.json();
	})
	.then(data => {
		console.log(data["result"])
	});
}


document.querySelectorAll('.remove-item').forEach(btn => {
	btn.addEventListener('click', () => {
		remove(btn.dataset.id);
	});
});

function remove(id) {
	const formData = new FormData();
	formData.append('id', id);

	fetch('./api/cart/delete', {
		method: 'POST',
		body: formData
	})
	.then(r => r.json())
	.then(data => {
		console.log(data);

		location.reload();
	})
	.catch(err => console.error(err));
}

document.querySelectorAll('.change-enable').forEach(btn => {
	btn.addEventListener('click', () => {
		const id = btn.dataset.id;
		const cost = parseFloat(btn.dataset.cost);  
		let enable = btn.dataset.enable === "1";     

		enable = !enable;
		btn.dataset.enable = enable ? "1" : "0";

		change(id, cost, enable);
	});
});

function change(id, cost, enable) {
	const formData = new FormData();
	formData.append('id', id);
	formData.append('cost', cost);
	formData.append('enable', enable ? 1 : 0);

	fetch('./api/cart/change', {
		method: 'POST',
		body: formData
	})
	.then(response => {
		if (!response.ok) throw new Error(`${response.status}`);
		return response.json();
	})
	.then(data => {
		console.log(data["result"]);

		if (data.total !== undefined) {
			const totalElem = document.getElementById('cart-total-price');
			totalElem.textContent = data.total + " ₽";
		}
	})
	.catch(err => console.error(err));
}

function clear() {
	const formData = new FormData();
	fetch('./api/cart/clear', {
		method: 'POST',
		body: formData
	}).then(response => {
		if (!response.ok) {
			throw new Error(`${response.status}`);
		}
		return response.json();
	});
}

clear();
change("1", 1, true);
clear();
change("1", 1, false);
get();


