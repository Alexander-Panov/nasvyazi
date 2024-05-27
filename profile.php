<?php
    require_once 'header.php';

    if (!$loggedin)
    {
        //Редирект на главную страницу
        header("Location: index.php"); // заменять заголовки с одинаковыми именами
        exit;
    }

    echo "<h3>Ваш профиль</h3>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if (isset($_POST['text']))
    {
        $text = sanitizeString($_POST['text']);
        $text = preg_replace('/\s\s+/', ' ', $text);

        if ($result->num_rows)
            queryMysql("UPDATE profiles SET text='$text' WHERE user='$user'");
        else
            queryMysql("INSERT INTO profiles VALUES('$user', '$text')");
    }
    else
    {
        if ($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $text = stripslashes($row['text']);
        }
        else
            $text = "";
    }

    $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

    if (isset($_FILES['image']['name']))
    {
        $saveto = "$user.jpg";
        move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
        $typeok = TRUE;

        switch($_FILES['image']['type'])
        {
            case "image/gif": $src = imagecreatefromgif($saveto); break;
            case "image/pjpeg": // для обычного и прогрессивного формата jpeg
            case "image/jpeg": $src = imagecreatefromjpeg($saveto); break;
            case "image/png": $src = imagecreatefrompng($saveto); break;
            default: $typeok = FALSE; break;
        }

        if ($typeok)
        {
            list($w, $h) = getimagesize($saveto);
    
            $max = 100;
            $tw = $w;
            $th = $h;
    
            if ($w > $h && $max < $w)
            {
                $th = $max / $w * $h;
                $tw = $max;
            }
            elseif ($h > $w && $max < $h)
            {
                $tw = $max / $h * $w;
                $th = $max;
            }
            elseif ($max < $w)
            {
                $tw = $th = $max;
            }
    
            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imageconvolution($tmp, array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
            imagejpeg($tmp, $saveto);
            imagedestroy($tmp);
            imagedestroy($src);
        }
    }

    showProfile($user);   

    //Сделать кнопку удаления аккаунта

    echo <<<_END
                <!-- multipart/form-data - для отправки нескольких видов файлов -->
                <form data-ajax="false" method="post" action="profile.php" enctype="multipart/form-data">
                    <h3>Расскажите что-нибудь о себе</h3>
                    <textarea name="text">$text</textarea><br>
                    <h3>Загрузить аватарку</h3>
                    <input type="file" name="image" size="14">
                    <input type="submit" data-theme="b" value="Сохранить профиль">
                </form>
                <form data-ajax="false" method="post" action="delete.php" onSubmit='return confirm("Вы точно хотите удалить аккаунт? Все ваши сообщения, действия, данные будут безвозвратно удалены")'>
                    <input type="submit" value="Удалить аккаунт">
                </form>
            </div><br>
        </body>
    </html>
    _END;
?>