//Проверка со стороны JS: Валидация пароля и логина

function checkUser(user)
{
	var error = validateUsername(user.value);
	if (error)
		$('#used').html("<span class='taken'>&nbsp;&#x2718;" + error + "</span>")
	else
		$.post
		(
			'checkuser.php',
			{user : user.value },
			function(data)
			{
				$('#used').html(data)
			}
		)
}

function checkPass(pass)
{
	var error = validatePassword(pass.value)
	if (error)
		$('#pass').html("<span class='taken'>&nbsp;&#x2718;" + error + "</span>")
	else
		$('#pass').html("<span class='available'>&nbsp;&#x2714;Пароль надежный</span>")
}

function checkRepPass(rep_pass, pass)
{
	var error = validateRepPassword(rep_pass.value, pass.value);
	if (error)
		$('#repeat').html("<span class='taken'>&nbsp;&#x2718;" + error + "</span>")
	else
		$('#repeat').html("<span class='available'>&nbsp;&#x2714;Пароли совпадают</span>")
}

function validateUsername(field)
{
    if (field == "") return "Не веден никнейм пользователя\n";
    else if (field.length < 3)
    return "В никнейме должно быть не менее 3 символов\n";
    else if (/[^a-zA-Z0-9_-]/.test(field))
    return "В никнейме пользователя разрешены только a-z, A-Z, 0-9, - и _\n";
    else return "";
}

function validatePassword(field)
{
    if (field == "") return "Не веден пароль\n";
    else if (field.length < 6)
    return "В пароле должно быть не менее 6 символов\n";
    else if (!/[a-z]/.test(field) || !/[A-Z]/.test(field) || !/[0-9]/.test(field))
    return "Пароль требует 1 символ из каждого набора a-z, A-Z, 0-9\n";
    else return "";
}

function validateRepPassword(field, pass)
{
    if (field == "") return "Не веден повторный пароль\n";
    else if (field != pass)
    return "Пароли не совпадают\n";
    else return "";
}

function validate(form) {
    var fail = validateUsername(form.user.value);
    fail += validatePassword(form.pass.value);
    fail += validateRepPassword(form.rep_pass.value, form.pass.value);

    if (fail == "") return true;
    else {alert(fail); return false;}
}