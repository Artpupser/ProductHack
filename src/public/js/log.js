
document.addEventListener('DOMContentLoaded', () => {
    const signInContainer = document.querySelector('.sign-in-container');
    const signUpContainer = document.querySelector('.sign-up-container');
    
    // Показываем форму входа по умолчанию
    signInContainer.classList.add('active');

    const toggleToLogin = document.getElementById('toggle-to-login');
    const toggleToRegister = document.getElementById('toggle-to-register');

    toggleToLogin.addEventListener('click', (event) => {
        event.preventDefault();
        signInContainer.classList.add('active');
        signUpContainer.classList.remove('active');
    });

    toggleToRegister.addEventListener('click', (event) => {
        event.preventDefault();
        signUpContainer.classList.add('active');
        signInContainer.classList.remove('active');
    });
});