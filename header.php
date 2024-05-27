<?php
    //header.php - один и тот же набор функций для всех файлов
    session_start(); // начало пользовательской сессии

    echo <<<_INIT
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <link rel='stylesheet' href='styles.css'/>
        <script src='javascript.js'></script>

        <!-- Подключение jQuery через CDN -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <!-- Подключение jQuery Mobile через CDN -->
        <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"/>
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    _INIT;

    require_once 'functions.php';

    $userstr = 'Добро пожаловать, гость!';

    if (isset($_SESSION['user']))
    {
        $user = $_SESSION['user'];
        $loggedin = TRUE;
        $userstr = "Вы вошли как: $user";
    }
    else $loggedin = FALSE;

    echo <<<_MAIN
        <title>НаСвязи: $userstr</title>
    </head>
    <body>
        <div data-role='page'>
            <div data-role='header'>
                <div id='logo' class='center'>НаСвязи</div>
                <div id='slogan' class='center'>Будь всегда На Связи!</div>
                <div class='username'>$userstr</div>
            </div>
            <div data-role='content'>
    _MAIN;

    if ($loggedin)
    {
        echo <<<_LOGGEDIN
            <div class='center'>
                <a data-role='button' data-inline='true' data-icon='home' data-transition='slide' href='members.php?view=$user'>Домой</a>
                <a data-role='button' data-inline='true' data-transition='slide' href='members.php'>Найти друзей</a>
                <a data-role='button' data-inline='true' data-transition='slide' href='friends.php'>Друзья</a>
                <a data-role='button' data-inline='true' data-transition='slide' href='messages.php'>Сообщения</a>
                <a data-role='button' data-inline='true' data-transition='slide' href='profile.php'>Редактировать профиль</a>
                <a data-role='button' data-inline='true' data-transition='slide' href='logout.php'>Выйти</a>
            </div>
        _LOGGEDIN;
    }
    else{
        echo <<<_GUEST
            <div class='center'>
                <a data-role='button' data-inline='true' data-icon='home' data-transition='slide' href='index.php'>Домой</a>
                <a data-role='button' data-inline='true' data-icon='plus' data-transition='slide' href='signup.php'>Зарегистрироваться</a>
                <a data-role='button' data-inline='true' data-icon='check' data-transition='slide' href='login.php'>Войти</a>
            </div>
            <p class='info'>(Вы должны войти, чтобы начать общаться)</p>
        _GUEST;
    }
?>