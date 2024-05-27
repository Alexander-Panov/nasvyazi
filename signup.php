<?php
    require_once 'header.php';
    require_once 'check.php';

    echo <<<_END
        <script src='check.js'></script>
    _END;

    $error = $user = $pass = $rep_pass = "";
    if (isset($_SESSION['user'])) destroySession();

    // !Сделать проверку со стороны JS и со стороны PHP

    if (isset($_POST['user']))
    {
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);
        $rep_pass = sanitizeString($_POST['rep_pass']);

        $error .= validate_username($user);
        $error .= validate_password($pass);
        $error .= validate_rep_password($rep_pass, $pass);
        $error .= check_username($user);

        if (!$error)
        {
            //!Хэширование паролей
            $pass = password_hash($pass, PASSWORD_DEFAULT);

            queryMysql("INSERT INTO members VALUES('$user', '$pass')");

            
            // !Автоматический вход на сайт после регистрации
            //Редирект на страницу с профилем
            header("Location: login.php"); // заменять заголовки с одинаковыми именами
            exit;
        }
    }

    // !Сменить text -> password
    echo <<<_END
                <form method='post' action='signup.php' onSubmit="return validate(this)">$error
                <div data-role='fieldcontain'>
                    <label></label>
                    Пожалуйста заполните поля чтобы зарегистрироваться
                </div>
                <div data-role='fieldcontain'>
                    <label>Логин</label>
                    <input type='text' maxlength='16' name='user' value='$user'
                    onBlur='checkUser(this)' placeholder="Введите логин">
                    <label></label>
                    <div id="used">&nbsp;</div>
                </div>
                <div data-role='fieldcontain'>
                    <label>Пароль</label>
                    <input type="password" placeholder="Введите пароль" name="pass" maxlength='16' value='$pass' autocomplete="off"
                    onBlur='checkPass(this)'>
                    <label></label>
                    <div id="pass">&nbsp;</div>
                </div>
                <div data-role='fieldcontain'>
                    <label>Повторно пароль</label>
                    <input type="password" placeholder="Повторно введите пароль" name="rep_pass" maxlength='16' value='$rep_pass' autocomplete="off"
                    onBlur='checkRepPass(this, pass)'>
                    <label></label>
                    <div id="repeat">&nbsp;</div>
                </div>
                <div data-role='fieldcontain'>
                    <label></label>
                    <input data-transition='slide' type='submit' value='Зарегистрироваться'> 
                </div>
            </div>
        </body>
    </html>
    _END;
    ?>
