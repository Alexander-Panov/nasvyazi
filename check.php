<?php
    require_once 'functions.php';

    function validate_username($field)
    {
        if ($field == "") return "Не введен никнейм пользователя<br>";
        else if (strlen($field) < 3)
        return "В имени пользователя должно быть не менее 3 символов<br>";
        else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
        return "В никнейме пользователя разрешены только a-z, A-Z, 0-9, - и _<br>";
        else return "";
    }
    function validate_password($field)
    {
        if ($field == "") return "Не веден пароль<br>";
        else if (strlen($field) < 6)
        return "В пароле должно быть не менее 6 символов<br>";
        else if (!preg_match("/[a-z]/", $field) || 
                !preg_match("/[A-Z]/", $field) || 
                !preg_match("/[0-9]/", $field))
        return "Пароль требует 1 символ из каждого набора a-z, A-Z, 0-9<br>";
        else return "";
    }

    function validate_rep_password($field, $pass)
    {
        if ($field == "") return "Не веден повторный пароль<br>";
        else if ($field != $pass)
        return "Пароли не совпадают<br>";
        else return "";
    }

    function check_username($field)
    {
        $result = queryMysql("SELECT * FROM members WHERE user='$field'");

        if ($result->num_rows)
            return "Имя $field уже занято";
        else return "";
    }
?>