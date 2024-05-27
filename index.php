<?php
    //session_start(); // ?
    require_once 'header.php';

    echo "<div class='center'>Добро пожаловать в НаСвязи, ";

    if ($loggedin) echo "$user, вы вошли на свою страницу";
    else echo "пожалуйста, зарегистрируйтесь или войдите";

    echo <<<_END
                </div><br>
            </div>
            <div data-role="footer">
                <h4>©Александр Панов, 2022<br>
                Сайт сделан по проекту книги <i><a href='https://lpmj.net/5thedition' target='_blank'>Создаем динамические веб-сайты с помощью PHP, MySQL, JavaScript, CSS и HTML5 [2019] Никсон Робин</a></i></h4>
            </div>
        </div>
    </body>
</html>
_END;
?>