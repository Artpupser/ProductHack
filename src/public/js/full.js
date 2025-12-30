/* Подтверждение возраста */
window.onload = function() {
    //const ok = confirm("Подтвердите, что вам есть 18 лет");
    if (!ok) {  
        document.body.innerHTML = "<h1 style='text-align:center; margin-top:100px;'>Доступ запрещён</h1>";
    }
};

/* Слайдер */
const images = document.querySelectorAll('.slider-img');
const controlls = document.querySelectorAll('.controlls');
let imageIndex = 0;

function show(index) {
    images[imageIndex].classList.remove('active');
    images[index].classList.add('active');
    imageIndex = index;
}

controlls.forEach((e) => {
    e.addEventListener('click', (event) => { 
        const target = event.target;

        if (target.classList.contains('left')) {
            let index = imageIndex - 1;
            if (index < 0) index = images.length - 1;
            show(index);
        } else if (target.classList.contains('right')) {
            let index = imageIndex + 1;
            if (index >= images.length) index = 0;
            show(index);
        }
    });
});

show(imageIndex);

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

