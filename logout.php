<?php
    //Создать код на php или JS, который сразу бы все делал, без вспомогательной страницы
    require_once 'header.php';

    if (isset($_SESSION['user']))
    {
        destroySession();
    }

    //Редирект на главную страницу
    header("Location: index.php"); // заменять заголовки с одинаковыми именами
    exit;
?>
        </div>
    </body>
</html>