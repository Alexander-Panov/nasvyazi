<?php
    require_once 'header.php';
    require_once 'check.php';

    $error = $user = $pass = "";

    if (isset($_POST['user']))
    {
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        if ($user == "" || $pass == "")
            $error = 'Не все поля были заполнены';
        else
        {
            // !Сделать проверку сначало имени, потом пароля ()
            $result = queryMysql("SELECT * FROM members WHERE user='$user'");

            // Сначало смотрим сходимость по логину
            if (!$result->num_rows)
                $error .= "Пользователя с именем \"$user\" не существует";
            else
            {
                // Затем подключаем вместе с логином и пароль 
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if (password_verify($pass, $row['password']))
                {
                    $_SESSION['user'] = $user;
                    $_SESSION['pass'] = $pass;
        
                    //Редирект
                    header("Location: members.php?view=$user"); // заменять заголовки с одинаковыми именами
                    exit;
        
                    //die("Вы вошли в сеть. Пожалуйста <a data-transition='slide href='members.php?view=$user'>нажмите сюда</a> чтобы продолжить.</div></body></html>");
                }
                else
                {
                    $error .= "Неправильно набран пароль!";
                }
            }
        }
    }

    echo <<<_END
                <form method='post' action='login.php'>
                <div data-role='fieldcontain'>
                    <label></label>
                    <span class='error'>$error</span>
                </div>
                <div data-role='fieldcontain'>
                    <label></label>
                    Пожалуйста заполните поля чтобы войти
                </div>
                <div data-role='fieldcontain'>
                    <label>Имя пользователя</label>
                    <input type='text' maxlength='16' name='user' value='$user'
                    <label></label><div id="used">&nbsp;</div>
                </div>
                <div data-role='fieldcontain'>
                    <label>Пароль</label>
                    <input type='password' maxlength='16' name='pass' value='$pass'>
                </div>
                <div data-role='fieldcontain'>
                    <label></label>
                    <input data-transition='slide' type='submit' value='Войти'> 
                </div>
            </div>
        </body>
    </html>
    _END;
?>