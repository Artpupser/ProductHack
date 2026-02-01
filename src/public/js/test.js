
function get() {
	const formData = new FormData();
	fetch('./api/cart/get', {
	method: 'POST',
	body: formData
	})
	.then(response => response.json())
	.then(data => {
		console.log(data["status"])
		console.log(data["result"])
	});
}

function remove(id) {
	const formData = new FormData();
	formData.append('id', id);
	fetch('./api/cart/delete', {
	method: 'POST',
	body: formData
	})
	.then(response => response.json())
	.then(data => {
		console.log(data["status"])
	});
}

function change(id, cost) {
	const formData = new FormData();
	formData.append('id', id);
	formData.append('cost', cost);
	fetch('./api/cart/change', {
	method: 'POST',
	body: formData
	})
	.then(response => response.json())
	.then(data => {
		console.log(data["status"])
		console.log(data["result"])
	});
}

function clear() {
	const formData = new FormData();
	fetch('./api/cart/clear', {
	method: 'POST',
	body: formData
	})
	.then(response => response.json())
	.then(data => {
		console.log(data["status"])
	});
}


get();
clear();
get();
change("3", 1);
change("3", 2);
get();
remove("3");
get();

