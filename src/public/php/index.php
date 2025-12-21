<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Винный магазин</title>
  <link rel="stylesheet" href="./public/css/full.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="http://localhost:8000/"><img src="../../assets/logo.png" alt="Логотип"></a> 
        </div>
        <p class="wineshop">Винный магазин</p>
        <div class="place flex-center flex-row">
            <div class="img-place">
                <img src="../../assets/place.png" alt="Местоположение">
            </div>
            <div class="flex-column">
                <p class="my_font">г. Санкт-Петербург,</p>
                <p class="my_font">ул. Куйбышева 31</p>
            </div>
        </div>
        <div class="contacts flex-center flex-row">
            <a href="/public/html/user.html"><img src="../../assets/profile.png" alt="Профиль" class="profile"></a>
            <a href="#"><img src="../../assets/basket.png" alt="Корзина" class="basket"></a>
        </div>
    </header>
    <main>
        <div class="background-container">
            <div class="bg-1">
                <h1 class="vinishko" >Винишко на все <br> случаи жизни</h1>
                <button class="button_catalog" onclick="window.location.href='./public/html/catalog.html'">Перейти в каталог</button>
            </div>
            <div class="bg-2">
 
            <div class="slider">
                <img class="slider-img" src="./assets/wine_1.jpg" alt="Слайд 1">
                <img class="slider-img" src="./assets/wine_2.jpg" alt="Слайд 2">
                <img class="slider-img" src="./assets/wine_3.jpg" alt="Слайд 3">
                <div class="controls">
                    <img style="opacity: 1; height: 40px;" class="left controlls" src="./assets/left.jpg" alt="Слева">
                    <img style="opacity: 1; height: 40px;" class="right controlls" src="./assets/right.jpg" alt="Справа">
                </div>
            </div>
            <a href="./public/html/catalog.html" class="link_catalog">Перейти в каталог</a>
            </div>
            <div class="acii">
                <img src="../../assets/acii.png" alt="">
            </div>
    </main>
            <footer class="footer">
            <div class="left_foot">
                <h2 class="title_foot">Винный магазин</h2>
                <div class="icon_wine_foot">
                    <img src="./assets/logo.png" alt="Логотип">
                </div>
                <p class="copy">© 2025 Wine Store Rights Reserved.</p>
            </div>
                <div class="right_foot">
                <nav class="menu_foot">
                    <a href="./public/html/catalog.html">Pricing</a>
                    <a href="./public/html/aboutus.html">About Us</a>
                    <a href="./public/html/contacts.html">Contact</a>
                </nav>
                <div class="social">
                    <a href="https://web.telegram.org/a/" target="_blank" class="telegram">TG</a>
                    <a href="https://vk.com/" target="_blank" class="vk">VK</a>
                </div>
                </div>
            </footer>
    <script src="./public/js/full.js"></script>
</body>
</html>
