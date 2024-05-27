<?php
    require_once 'header.php';

    if (!$loggedin)
    {
        //Редирект на главную страницу
        header("Location: index.php"); // заменять заголовки с одинаковыми именами
        exit;
    }

    if (isset($_GET['view']))
    {
        $view = sanitizeString($_GET['view']);

        $name = $view == $user? "Ваш профиль" : "$view";

        echo "<h3>$name</h3>";
        showProfile($view);
        if ($view != $user)
            echo "<a class='button' data-transition='slide' href='messages.php?view=$view'>Написать</a>";
        if ($view != $user)
            echo "<br><a class='button' data-transition='slide' href='friends.php?view=$view'>Друзья</a>";
        die("</div></body></html>");
    }

    if (isset($_GET['add']))
    {
        $add = sanitizeString($_GET['add']);

        $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
        if (!$result->num_rows)
            queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
    }
    elseif (isset($_GET['remove']))
    {
        $remove = sanitizeString($_GET['remove']);
        queryMysql("DELETE FROM friends WHERE user='$remove' AND friend = '$user'");
    }

    $result = queryMysql("SELECT user FROM members ORDER BY user");
    $num = $result->num_rows;
    echo "<h3>Члены сообщества</h3><ul>";

    for ($j = 0; $j < $num; ++$j)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row['user'] == $user) continue;

        echo "<li><a data-transition='slide' href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a>";
        $follow = "Отправить заявку";

        $result1 = queryMysql("SELECT * FROM friends WHERE user = '" . $row['user'] . "' AND friend='$user'");
        $t1 = $result1->num_rows;

        $result1 = queryMysql("SELECT * FROM friends WHERE user = '$user' AND friend='" . $row['user'] . "'");
        $t2 = $result1->num_rows;

        if (($t1 + $t2) > 1) echo " &harr; ваш друг";
        elseif ($t1) echo " &larr; заявка отправлена";
        elseif ($t2)
        {
            echo " &rarr; хочет стать вашим другом";
            $follow = "Принять заявку";
        }

        if (!$t1) echo " [<a data-transition='slide' href='members.php?add=" . $row['user'] . "'>$follow</a>]";
        else echo " [<a data-transition='slide' href='members.php?remove=" . $row['user'] . "'>Удалить из друзей</a>]";
    }
?>

        </ul></div>
    </body>
</html>