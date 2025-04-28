<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление сеанса в кинотеатре</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1 style="text-align: center; font-size: 25px;">Добавить новый сеанс</h1>
    
    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
    <div class="success">Сеанс успешно добавлен!</div>
        <script>
            setTimeout(function() {
                document.querySelector('.success').style.display = 'none';
                // Убираем параметр success из URL без перезагрузки страницы
                history.replaceState(null, null, window.location.pathname);
            }, 5000);
        </script>
    <?php endif; ?>
    
    <form id="sessionForm" action="process.php" method="post" onsubmit="return validateForm()">
        <label for="film_title">Название фильма:</label>
        <input type="text" id="film_title" name="film_title" required>
        <span id="film_title_error" class="error"></span>
    
        <label for="genre">Жанр:</label>
        <select id="genre" name="genre" required>
            <option value="">Выберите жанр</option>
            <option value="боевик">Боевик</option>
            <option value="комедия">Комедия</option>
            <option value="драма">Драма</option>
            <option value="фантастика">Фантастика</option>
            <option value="ужасы">Ужасы</option>
            <option value="триллер">Триллер</option>
            <option value="мультфильм">Мультфильм</option>
        </select>
        <span id="genre_error" class="error"></span>

    

        <label for="session_date">Дата сеанса:</label>
        <input type="date" id="session_date" name="session_date" required>
        <span id="session_date_error" class="error"></span>

    

        <label for="session_time">Время сеанса:</label>
        <input type="time" id="session_time" name="session_time" required>
        <span id="session_time_error" class="error"></span>

    

        <label for="hall_number">Номер зала:</label>
        <input type="number" id="hall_number" name="hall_number" min="1" max="10" required>
        <span id="hall_number_error" class="error"></span>
    

        <label for="ticket_price">Цена билета (руб):</label>
        <input type="number" id="ticket_price" name="ticket_price" min="100" max="5000" required>
        <span id="ticket_price_error" class="error"></span>

    

        <label for="description">Описание фильма:</label>
        <textarea id="description" name="description" rows="4"></textarea>

        
        <button type="submit">Добавить сеанс</button>
    </form>

    <script>
        function validateForm() 
        {
            let isValid = true;
            
            
            const filmTitle = document.getElementById('film_title').value.trim();
            if (filmTitle.length < 2 || filmTitle.length > 100) 
            {
                document.getElementById('film_title_error').textContent = 'Название фильма должно быть от 2 до 100 символов';
                isValid = false;
            } 

            else
            {
                document.getElementById('film_title_error').textContent = '';
            }
            
            
            const genre = document.getElementById('genre').value;
            if (genre === '') 
            {
                document.getElementById('genre_error').textContent = 'Пожалуйста, выберите жанр';
                isValid = false;
            }

            else 
            {
                document.getElementById('genre_error').textContent = '';
            }
            
            
            const sessionDate = new Date(document.getElementById('session_date').value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (isNaN(sessionDate.getTime()))
            {
                document.getElementById('session_date_error').textContent = 'Пожалуйста, введите корректную дату';
                isValid = false;
            }

             else if (sessionDate < today) 
            {
                document.getElementById('session_date_error').textContent = 'Дата сеанса не может быть в прошлом';
                isValid = false;
            } 

            else 
            {
                document.getElementById('session_date_error').textContent = '';
            }
            
            return isValid;
        }
    </script>
</body>
</html>