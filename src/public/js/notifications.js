function showNotification(message, type = 'error', duration = 3000) {
    const container = document.querySelector('.notifications_container');
    const notification = document.createElement('div');
    notification.classList.add('notification', type);
    notification.textContent = message;

    notification.addEventListener('click', () => hideNotification(notification));

    container.appendChild(notification);

    setTimeout(() => notification.classList.add('show'), 10);

    setTimeout(() => hideNotification(notification), duration);
}

function hideNotification(notification) {
    notification.classList.remove('show');
    setTimeout(() => {
        if (notification.parentNode) notification.parentNode.removeChild(notification);
    }, 300);
}

document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    showNotification('Не удалось загрузить данные', 'error'); 
});
