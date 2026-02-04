const images = document.querySelectorAll('.slider-img');
const controls = document.querySelectorAll('.controls img');
let imageIndex = 0;

function show(index) {
    images.forEach(img => img.classList.remove('active'));
    images[index].classList.add('active');
    imageIndex = index;
}

controls.forEach(control => {
    control.addEventListener('click', event => {
        const target = event.target;
        if (target.classList.contains('left_controlls')) {
            let index = imageIndex - 1;
            if (index < 0) index = images.length - 1;
            show(index);
        } else if (target.classList.contains('right_controlls')) {
            let index = imageIndex + 1;
            if (index >= images.length) index = 0;
            show(index);
        }
    });
});

show(imageIndex);
