

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