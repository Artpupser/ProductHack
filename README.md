<<<<<<< HEAD
# ProductHack
=======
# ProductHack

# Шаг 1. Инициализация репозитория на виртуальной машине.
- Создайте папку под проект `mkdir <имя_директории>`, например, в домашней директории `cd ~`.
- Проверьте успешность создания `ls -la | grep "<имя_директории>"`.
- Перейдите в директорию `cd <имя_директории>`
<img width="694" height="496" alt="image" src="https://github.com/user-attachments/assets/d46f9caa-f410-409e-b6a8-f80169a717b2" />

- Склонируйте репозиторий _ProductHack_ в директорию `git clone https://github.com/Artpupser/ProductHack.git`.
- Проверьте, что появилась одноимённая директория `ls -la`.
- Перейдите в директорию репозитория `cd ProductHack`.
- Проверьте, что директория склонирована успешно `git status`.
<img width="732" height="344" alt="image" src="https://github.com/user-attachments/assets/2e314115-4545-4ab7-8436-4a620456ba58" />

*Для получения обновлений репозитория используйте команду* `git pull`<br>
*Для отправления обновлений в репозиторий выполните следующий набор команд*
```
# Проверьте состояние репозитория
git status

# Добавьте все изменения
git add .

# Создайте коммит
git commit -m "Комментарий"

# Загрузите изменения на GitHub
git push origin <имя_ветки>
```
В качестве пароля требуется ввести токен, который можно получить в настройках разработчика.

# Шаг 2. Настройка сервера.
_Подпункт 1: базовые команды Linux._
- `ls` - отображение файлов в директориии. Ключ `-a` - отображение скрытых файлов (`.htaccess`). Ключ `-l` структурированное отображение с правами доступа и прочими данными.
<img width="694" height="270" alt="image" src="https://github.com/user-attachments/assets/8eabea3a-aa0a-4e75-a27e-e0e99534ab1b" />

- `cd` - смена директории. Можно переходить по относительному пути `./ | <ничего>`, или по абсолютному `/var/www/html/...`
<img width="512" height="42" alt="image" src="https://github.com/user-attachments/assets/e15b0997-81e4-4308-9cdf-21fd03db624b" />

- `touch <имя_файла>` - создание / изменение даты обновления указанного файла.
<img width="761" height="163" alt="image" src="https://github.com/user-attachments/assets/b13d7191-ab8b-4d29-817e-171d662c628b" />

- `chmod NNN <имя_файла>` - изменение прав доступа к файлу.
<img width="755" height="184" alt="image" src="https://github.com/user-attachments/assets/358d681e-614e-42cc-9f37-da9532182ae6" />

- `mkdir <имя_директории>` - создать директорию.
- `mv /my/file/example.txt /new/file/pos/example.txt` - перемещение файла в другую директорию.
- `cp /my/file/example.txt /copy/file/pos/example.txt` - копирование файла в новое место.
<img width="754" height="345" alt="image" src="https://github.com/user-attachments/assets/f6b7b41b-4dc0-4faf-9e24-21bb48d4fd25" />

- `rm -f <имя_директории>` - удалить директорию или файл. Тег `-r` - рекурсивное удаление (в основном для папок).
<img width="567" height="136" alt="изображение" src="https://github.com/user-attachments/assets/ac168204-71f4-4d59-ac1f-3bb9614be717" />


_Подпункт 2: Конфигурация сервера._



# Шаг 3. Разработка FrontEnd.
Теги в HTML:

- `<!DOCTYPE html>`: Указывает, что документ является HTML5.
- `<html></html>`: Корневой элемент HTML-документа.
- `<head></head>`: Содержит метаданные, такие как заголовок и ссылки на стили.
- `<body></body>`: Основной контент страницы, отображаемый пользователю.
- `<p></p>`: Параграф текста.
- `<a href=""></a>`: Ссылка на другую страницу или ресурс.
- `<div></div>`: Блочный элемент для структурирования контента.
- `<header></header>`: Заголовок документа или секции (может содержать логотип, навигацию и т.д.).
- `<footer></footer>`: Нижний колонтитул страницы, часто содержит информацию об авторских правах.
- `<nav></nav>`: Элемент навигации, содержащий ссылки на другие страницы или разделы.

- `<ul><li></li></ul>`: Ненумерованный список, содержащий элементы списка.
- `<ol><li></li></ol>`: Нумерованный список, содержащий элементы списка.

- `<img src="" alt="" />`: Элемент изображения, отображающий графический файл.
  - `src`: Атрибут, указывающий путь к изображению.
  - `alt`: Атрибут, предоставляющий текстовое описание изображения для доступности и случаев, когда изображение не может быть загружено.


Возможности CSS:
```
/*Стили для тегов*/
div{background-color: #000;}

/*Стили для классов*/
div.classname{background-color: #000;}

/*Стили для id-шников*/
div#idname{background-color: #000;}

/*Стили для псевдоклассов, позволяющие обрабатывать состояния объектов*/
a:hover{color: #5d5d5d;}
```

Возможности JavaScript:

```
console.log("index.js") // Логирование
document.onload(foo(10))

function foo(variable){ // Общий синтаксис
    if(variable == 10){
        alert("The var is 10!");  // Уведомления
    } 
    for(var i = 0; i < 10; i++){
        console.log(variable++);
    }
}

let response = await fetch(url);

if (response.ok) { // если HTTP-статус в диапазоне 200-299
  // получаем тело ответа (см. про этот метод ниже)
  let json = await response.json();
} else {
  alert("Ошибка HTTP: " + response.status);
}

// Работа со структурой веб-документа, в данном случае - добавление обработчика событий и изменение отображения элемента
document.getElementById('residence').addEventListener('change', function() {
            const otherField = document.getElementById('residence_other_field');
            if (this.value === 'Другое') {
                otherField.style.display = 'block';
            } else {
                otherField.style.display = 'none';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const residenceSelect = document.getElementById('residence');
            const otherField = document.getElementById('residence_other_field');
            
            if (residenceSelect.value === 'Другое') {
                otherField.style.display = 'block';
            }
        });
```

# Шаг 4. Разработка BackEnd.

_Проектирование базы данных_
1. Установка PostgreSQL
2. Установка менеджера БД DBeaver
3. Проектирование БД
4. Создание БД

<img width="337" height="187" alt="image" src="https://github.com/user-attachments/assets/6d1746a8-06b3-4045-ad11-70ede7a9879e" />

```
create database WineShop;

create type roles_of_users as enum ('admin', 'customer');

create table users(
	id int primary key,
	full_name varchar,
	email varchar,
	role roles_of_users
);

create type statuses as enum ('created', 'sended', 'delivered');

create table orders(
	id int primary key,
	user_id int,
	total_amount int,
	status statuses,
	created_at timestamp,
	constraint usr_id_fk foreign key(user_id) references users(id)
);
```

# Шаг 5. Создание SPA.

# Шаг 6. Создание сайта с помощью фреймворка.

# Шаг 7. Тестирование проекта.
>>>>>>> ba86e0d7ceb131a82f5759f491ce560b2ed5bf99
