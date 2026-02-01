const container = document.querySelector('.notifications_container');

container.querySelectorAll('div').forEach(element => {
	element.addEventListener('click', () => hideNotification(element));
	setTimeout(() => element.classList.add('show'), 10);
	setTimeout(() => hideNotification(element), 10 * 1000);
});


function hideNotification(notification) {
    notification.classList.remove('show');
    setTimeout(() => {
        if (notification.parentNode) notification.parentNode.removeChild(notification);
    }, 3000);
}
