<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройка базы данных</title>
</head>
<body>
    <h3>Настройка...</h3>
    <?php
    // setup.php - настройка используемых SQL таблиц

    require_once 'functions.php';


    createTable('members', 'user VARCHAR(16) NOT NULL UNIQUE,
                            password VARCHAR(255) NOT NULL,
                            INDEX(user(6))');

    createTable('messages', 'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                             auth VARCHAR(16),
                             recip VARCHAR(16),
                             pm CHAR(1),
                             time INT UNSIGNED,
                             message VARCHAR(4096),
                             INDEX(auth(6)),
                             INDEX(recip(6))');

    createTable('friends', 'user VARCHAR(16), 
                            friend VARCHAR(16),
                            INDEX(user(6)),
                            INDEX(friend(6))');
                            
    createTable('profiles', 'user VARCHAR(16), 
                            text VARCHAR(4096),
                            INDEX(user(6))');

    ?>
    <br>... завершена.
</body>
</html>
