
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

function remove(id) {
	const formData = new FormData();
	formData.append('id', id);
	fetch('./api/cart/delete', {
		method: 'POST',
		body: formData
	}).then(response => {
		if (!response.ok) {
			throw new Error(`${response.status}`);
		}
		return response.json();
	});
}

function change(id, cost, enable) {
	const formData = new FormData();
	formData.append('id', id);
	formData.append('cost', cost);
	formData.append('enable', enable);
	fetch('./api/cart/change', {
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

