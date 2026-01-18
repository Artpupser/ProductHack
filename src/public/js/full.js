/* Подтверждение возраста 
window.onload = function() {
    //const ok = confirm("Подтвердите, что вам есть 18 лет");
    if (!ok) {
        document.body.innerHTML = "<h1 style='text-align:center; margin-top:100px;'>Доступ запрещён</h1>";
    }
};*/

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
/* Переключение с логина на авторизацию и на оборот */

function showLoginForm() {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
}

function showRegisterForm() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
}

//18 age
const overlay = document.getElementById('ageOverlay');
const yesBtn = document.getElementById('yesBtn');
const noBtn = document.getElementById('noBtn');

yesBtn.addEventListener('click', () => {
  localStorage.setItem('ageConfirmed', 'true');
  overlay.style.display = 'none';
});

noBtn.addEventListener('click', () => {
  window.open('', '_self');
  window.close();
});

if (localStorage.getItem('ageConfirmed') === 'true') {
  overlay.style.display = 'none';
}
