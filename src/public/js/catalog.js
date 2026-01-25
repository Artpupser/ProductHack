

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