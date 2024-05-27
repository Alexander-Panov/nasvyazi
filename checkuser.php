<?php
    require_once 'functions.php';
    require_once 'check.php';

    //После ошибочной отправки формы почему-то не работает
    if (isset($_POST['user']))
    {
        $user = sanitizeString($_POST['user']);
        $error = check_username($user);

        if ($error)
            echo "<span class='taken'>&nbsp;&#x2718;$error</span>";
        else
            echo "<span class='available'>&nbsp;&#x2714;Имя $user свободно</span>";
    }
?>