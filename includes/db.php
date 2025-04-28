<?php
    $host = 'mysql';
    $dbname = 'my_database';
    $user = 'root';
    $pass = 'root';


    try
    {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=$utf8",
            $user,
            $pass
        );
        echo 'Успех';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        die("Ошибка подключения: " . $e->getMessage());
    }
?>