/* Каталог поиск */
const searchInput = document.getElementById('search');
const cards = document.querySelectorAll('.card');

searchInput.addEventListener('input', function() {
    const query = this.value.trim().toLowerCase();

    cards.forEach(card => {
        const titleEl = card.querySelector('.card_title');
        const title = titleEl ? titleEl.textContent.toLowerCase() : '';
        if (title.includes(query)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
});

document.querySelectorAll('.card').forEach(card => {
	const stock = parseInt(card.dataset.stock);
	const qtyNumber = card.querySelector('.qty-number');
	const plusBtn = card.querySelector('.plus');
	const minusBtn = card.querySelector('.minus');

	var current = 1;

	plusBtn.addEventListener('click', () => {
		if (current < stock) {
			current++;
			
		}
		qtyNumber.textContent = current;
	});

	minusBtn.addEventListener('click', () => {
		if (current > 1) {
			current--;
			
		}
		qtyNumber.textContent = current;
	});
});

