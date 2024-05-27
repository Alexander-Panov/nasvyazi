<?php
    require_once 'header.php';

    if (!$loggedin)
    {
        //Редирект на главную страницу
        header("Location: index.php"); // заменять заголовки с одинаковыми именами
        exit;
    }

    $view = isset($_GET['view'])? sanitizeString($_GET['view']) : $user;

    if ($view == $user)
    {
        $name1 = $name2 = "Ваши";
        $name3 = "Вы";
    }
    else
    {
        $name1 = "<a data-transition='slide' href='members.php?view=$view'>$view</a>'s";
        $name2 = "$view";
        $name3 = "$view";
    }

    showProfile($view);

    $followers = array();
    $following = array();

    $result = queryMysql("SELECT * FROM friends WHERE user='$view'");
    $num = $result->num_rows;

    for ($j = 0; $j < $num; ++$j)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $followers[$j] = $row['friend'];
    }

    
    $result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
    $num = $result->num_rows;

    for ($j = 0; $j < $num; ++$j)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $following[$j] = $row['user'];
    }

    $mutual = array_intersect($followers, $following);

    $followers = array_diff($followers, $mutual);
    $following = array_diff($following, $mutual);
    $friends = FALSE;
    echo "<br>";

    if (sizeof($mutual))
    {
        echo "<span class='subhead'>$name2 друзья</span><ul>";
        foreach($mutual as $friend)
            echo "<li><a data-transition='slide' href='members.php?view=$friend'>$friend</a></li>";
        echo "</ul>";
        $friends = TRUE;
    }
    if (sizeof($followers))
    {
        echo "<span class='subhead'>$name2 подписечники</span><ul>";
        foreach($followers as $friend)
            echo "<li><a data-transition='slide' href='members.php?view=$friend'>$friend</a></li>";
        echo "</ul>";
        $friends = TRUE;
    }
    if (sizeof($following))
    {
        echo "<span class='subhead'>$name3 подписаны на</span><ul>";
        foreach($following as $friend)
            echo "<li><a data-transition='slide' href='members.php?view=$friend'>$friend</a></li>";
        echo "</ul>";
        $friends = TRUE;
    }

    if (!$friends) echo "<br>У вас пока нет друзей.<br><br>";

    if (isset($_GET['view']) && $view != $user)
        echo "<a data-role='button' data-transition='slide' href='messages.php?view=$view'>Посмотреть сообщения с $name2</a>";
    ?>
        </div>
    </body>
</html>