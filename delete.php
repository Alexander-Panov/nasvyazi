<?php
    require_once "header.php";

    if (isset($_SESSION['user']))
    {
        $user = $_SESSION['user'];

        $result = queryMysql("DELETE FROM members WHERE user='$user'");
        $result = queryMysql("DELETE FROM messages WHERE auth='$user' OR recip='$user'");
        $result = queryMysql("DELETE FROM friends WHERE user='$user' OR friend='$user'");
        $result = queryMysql("DELETE FROM profiles WHERE user='$user'");

        echo "<script type='text/javascript'>alert('Ваш аккаунт успешно удален!');</script>";

        destroySession();
    }

    //Редирект на главную страницу
    header("Location: index.php"); // заменять заголовки с одинаковыми именами
    exit;

?>