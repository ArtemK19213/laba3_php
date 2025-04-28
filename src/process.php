<?php

require "db.php";

function validateInput($data)
 {
    $errors = [];
    

    if (empty($data['film_title'])) 
    {
        $errors['film_title'] = 'Название фильма обязательно для заполнения';
    } 

    elseif (strlen($data['film_title']) < 2 || strlen($data['film_title']) > 100) 
    {
        $errors['film_title'] = 'Название фильма должно быть от 2 до 100 символов';
    }
    

    $allowedGenres = ['боевик', 'комедия', 'драма', 'фантастика', 'ужасы', 'триллер', 'мультфильм'];
    if (empty($data['genre'])) 
    {
        $errors['genre'] = 'Жанр обязателен для заполнения';
    } 

    elseif (!in_array($data['genre'], $allowedGenres)) 
    {
        $errors['genre'] = 'Указан недопустимый жанр';
    }
    

    if (empty($data['session_date'])) 
    {
        $errors['session_date'] = 'Дата сеанса обязательна для заполнения';
    } 

    else 
    {
        $sessionDate = DateTime::createFromFormat('Y-m-d', $data['session_date']);
        $today = new DateTime('today');
        
        if (!$sessionDate) 
        {
            $errors['session_date'] = 'Неверный формат даты';
        } 

        elseif ($sessionDate < $today)
        {
            $errors['session_date'] = 'Дата сеанса не может быть в прошлом';
        }
    }
    

    if (empty($data['session_time'])) 
    {
        $errors['session_time'] = 'Время сеанса обязательно для заполнения';
    } 

    elseif (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $data['session_time'])) 
    {
        $errors['session_time'] = 'Неверный формат времени';
    }
    

    if (empty($data['hall_number'])) 
    {
        $errors['hall_number'] = 'Номер зала обязателен для заполнения';
    } 

    elseif (!filter_var($data['hall_number'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 10]])) 
    {
        $errors['hall_number'] = 'Номер зала должен быть целым числом от 1 до 10';
    }
    

    if (empty($data['ticket_price'])) 
    {
        $errors['ticket_price'] = 'Цена билета обязательна для заполнения';

    } 

    elseif (!filter_var($data['ticket_price'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 100, 'max_range' => 5000]])) 
    {
        $errors['ticket_price'] = 'Цена билета должна быть от 100 до 5000 рублей';
    } 
    
    return $errors;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

    $formData = [
        'film_title' => trim(htmlspecialchars($_POST['film_title'] ?? '')),
        'genre' => trim(htmlspecialchars($_POST['genre'] ?? '')),
        'session_date' => trim(htmlspecialchars($_POST['session_date'] ?? '')),
        'session_time' => trim(htmlspecialchars($_POST['session_time'] ?? '')),
        'hall_number' => trim(htmlspecialchars($_POST['hall_number'] ?? '')),
        'ticket_price' => trim(htmlspecialchars($_POST['ticket_price'] ?? '')),
        'description' => trim(htmlspecialchars($_POST['description'] ?? ''))
    ];
    

    $errors = validateInput($formData);
    
    if (empty($errors)) 
    {

        $csvFile = 'sessions.csv';
        
        if (!file_exists($csvFile)) 
        {
            $header = [
                'Название фильма',
                'Жанр',
                'Дата сеанса',
                'Время сеанса',
                'Номер зала',
                'Цена билета',
                'Описание',
                'Дата добавления'
            ];
            $file = fopen($csvFile, 'w');
            fputcsv($file, $header, ';');
            fclose($file);
        }
        

        $file = fopen($csvFile, 'a');
        $dataToSave = [
            $formData['film_title'],
            $formData['genre'],
            $formData['session_date'],
            $formData['session_time'],
            $formData['hall_number'],
            $formData['ticket_price'],
            $formData['description'],
            date('Y-m-d H:i:s')
        ];
        fputcsv($file, $dataToSave, ';');
        fclose($file);
        


        $file = fopen($csvFile, "r");

        fgetcsv($file);
        
        while(($data = fgetcsv($file, 1000, ";")) != false)
        {
            $stmt = $pdo->prepare("INSERT INTO cinema (film_title, genre, session_date, session_time, hall_number, ticket_price, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]]);

        }

        fclose($file);
        header('Location: table.php');
        exit();
    } 

    else 
    {

        echo '<h1>Ошибки при заполнении формы</h1>';
        echo '<ul>';
        foreach ($errors as $error) 
        {
            echo '<li>' . $error . '</li>';
        }

        echo '</ul>';
        echo '<a href="index.php">Вернуться к форме</a>';
    }
}
 else 
{

    header('Location: index.php');
    exit();
}
?>