<?php
    require_once 'header.php';

    if (!$loggedin)
    {
        //Редирект на главную страницу
        header("Location: index.php"); // заменять заголовки с одинаковыми именами
        exit;
    }

    $view = isset($_GET['view'])? sanitizeString($_GET['view']) : $user;

    if (isset($_POST['text']))
    {
        $text = sanitizeString($_POST['text']);

        if ($text != "")
        {
            $pm = substr(sanitizeString($_POST['pm']), 0, 1);
            $time = time();
            queryMysql("INSERT INTO messages VALUES(NULL, '$user', '$view', '$pm', '$time', '$text')");
        }
    }

    if ($view != "")
    {
        if ($view == $user) $name1 = $name2 = "Ваши";
        else
        {
            $name1 = "<a href='members.php?view=$view'>$view</a>";
        }

        echo "<h3>$name1 Сообщения</h3>";
        showProfile($view);

        echo <<<_END
            <form method='post' action='messages.php?view=$view' id='messageForm'>
                <fieldset data-role="controlgroup" data-type="horizontal">
                    <legend>Напишите ваше сообщение здесь</legend>
                    <input type='radio' name='pm' id='public' value='0' checked='checked'>
                    <label for="public">Публичное</label>
                    <input type='radio' name='pm' id='private' value='1'>
                    <label for="private">Частное</label>
                </fieldset>
                <textarea name='text' id="message"></textarea>
                <input data-transition='slide' type='submit' value='Отправить сообщение'>
            </form><br>
        _END;

        date_default_timezone_set('UTC');

        if (isset($_GET['erase']))
        {
            $erase = sanitizeString($_GET['erase']);
            queryMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
        }

        $query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
        $result = queryMysql($query);
        $num = $result->num_rows;

        for ($j = 0; $j < $num; ++$j)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
            {
                echo date ('M jS \'y g:ia:', $row['time']);
                echo "<a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth'] . "</a> ";

                if($row['pm'] == 0)
                    echo "пишет " . ($row['recip'] == $row['auth']? "всем" : $row['recip']) . ": &quot;" . $row['message'] . "&quot;";
                else
                    echo "шепчет " . ($row['recip'] == $user? "вам" : $row['recip']) . ": <span class='whisper'>&quot;" . $row['message'] . "&quot;</span>";

                if ($row['auth'] == $user)
                    echo "[<a href='messages.php?view=$view" . "&erase=" . $row['id'] . "'>Стереть</a>]";

                echo "<br>";
            }
        }
    }

    if (!$num)
        echo "<br><span class='info'>У вас пока нет сообщений</span><br><br>";
    
    echo <<<_REFRESH
    <br><form method='post' action='messages.php?view=$view'>
    <div data-role='fieldcontain'>
        <input data-transition='slide' type='submit' value='Обновить сообщения'>
    </div>
    _REFRESH;

    //echo "<a data-role='button' href='messages.php?view=$view'>Обновить сообщения</a>";

    echo "<script>
        $(document).ready(function() {
            $('#message').keydown(function(e) {
            if(e.keyCode === 13) {
                // можете делать все что угодно со значением текстового поля 
                // console.log($(this).val());
                $('#messageForm').submit();
            }
            });
        });
    </script>";
?>

        </div><br>
    </body>
</html>