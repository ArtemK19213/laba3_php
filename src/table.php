<?php
require "db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Список сеансов</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .success {
            color: green;
            margin: 10px 0;
            padding: 10px;
            background-color: #e8f5e9;
        }
    </style>
</head>
<body>
    <?php
        $stmt = $pdo->query("SELECT * FROM cinema");
        $cinemas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($cinemas) > 0) {
            echo '<table>';
            echo '<tr><th>Название фильма</th><th>Жанр</th><th>Дата</th><th>Время</th><th>Номер зала</th><th>Стоимость билета</th><th>Описание</th></tr>';
            
            foreach ($cinemas as $cinema) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($cinema['film_title']) . '</td>';
                echo '<td>' . htmlspecialchars($cinema['genre']) . '</td>';
                echo '<td>' . htmlspecialchars($cinema['session_date']) . '</td>';
                echo '<td>' . htmlspecialchars($cinema['session_time']) . '</td>';
                echo '<td>' . htmlspecialchars($cinema['hall_number']) . '</td>';
                echo '<td>' . htmlspecialchars($cinema['ticket_price']) . '</td>';
                echo '<td>' . htmlspecialchars($cinema['description']) . '</td>';
                echo '</tr>';
            }
            echo '<a href="index.php">Возвращение</a>';
            echo '</table>';
        } else {
            echo 'Нет данных для отображения.';
        }
    ?>
</body>
</html>