<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/api/public/file/?name=css/style.css">
    <title>Винишко</title>
</head>
<body>

<main class="body_main">
    <div class="background-container">

        <div class="bg-1">
            <h1 class="vinishko">Винишко на все <br> случаи жизни</h1>
            <button class="butcat" onclick="window.location.href='/catalog'">Перейти в каталог</button>
        </div>
        <div class="bg-2">
            <div class="slider">
                <?php 
                $slideCount = 4; 
                for ($i = 1; $i <= $slideCount; $i++): ?>
                    <div class="big-image-frame">
                        <img src="/api/public/file/?name=imgs/<?= $i ?>.webp" alt="Слайд <?= $i ?>">
                    </div>
                <?php endfor; ?>

                <div class="controls">
                    <img class="left_controlls" src="/api/public/file/?name=imgs/left_switch_icon.webp" alt="Слева">
                    <img class="right_controlls" src="/api/public/file/?name=imgs/right_switch_icon.webp" alt="Справа">
                </div>
            </div>

            
        </div>

        <div class="acii">
            <img src="/api/public/file/?name=imgs/sale_banner.webp" alt="Баннер">
        </div>

    </div>
</main>

<script src="/api/public/file/?name=js/slider.js"></script>
</body>
</html>
