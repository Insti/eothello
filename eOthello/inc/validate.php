<?phpfunction needLoggedIn(){	echo '<p>You need to be logged in to access this page.</p>';}function valid_email($email){	$error = "";	//Valida el email	if (!preg_match('/^(.+)@(.+)\.(.{2,3})$/', $email))	{		$error .= "<li>Invalid e-mail</li>";	}	return $error;}function valid_username($username){	$username = trim($username);	$error = "";	if ((empty($username)) || (strlen($username) < 3))	{		$error .= "<li>At least 3 characters in username</li>";	}	if ((strlen($username) > 30))	{		$error .= "<li>Less than 30 characters in username</li>";	}	$result = preg_match('/^[A-Za-z0-9_\-]*$/',$username); //only A-Z, a-z and 0-9 are allowed	if (!$result)	{		$error .= "<li>Invalid character/s in username</li>";	}	return $error;}function valid_password($pass){	$pass = trim($pass);	$error = "";	if ((empty($pass)) || (strlen($pass) < 6))	{		$error .= "<li>At least 6 characters in password</li>";	}	if ((strlen($pass) > 15))	{		$error .= "<li>Less than 30 characters in password</li>";	}	$result = preg_match('/^[A-Za-z0-9_\-]*$/',$pass);	if (!$result)	{		$error .= "<li>Invalid character/s in password</li>";	}	return $error;}function validateNewUser($username, $password, $password2, $email){	global $dbh;	$errors = valid_username($username) . valid_password($password) . valid_email($email);	if($password != $password2)	{		$errors .= "<li>Passwords don't match</li>";	}	if(user_exist($username))	{		$errors .= "<li>User already exists</li>";	}		if(email_exist($email))	{		$errors .= "<li>Email already exists</li>";	}	return $errors;}function validateLogin($u, $p){	$errors = valid_username($u) . valid_password($p);	if(!user_exist($u))	{		$errors .= "<li>User not exists</li>";	}	elseif(!valid_pass($u,$p))	{		$errors .= "<li>Invalid pass</li>";	}	elseif(!active_user($u))	{		$errors .= "<li>User not active</li>";	}	return $errors;}function validateChangePassword($username,$currentpassword,$newpassword,$newpassword2){	$errors = valid_password($newpassword);	if(!valid_pass($username,$currentpassword))	{		$errors .="<li>Incorrect actual password</li>";	}	if ($newpassword != $newpassword2)	{		$errors .="<li>Passwords don't match</li>";	}	elseif($newpassword == $currentpassword)	{		$errors .="<li>Invalid Change</li>";	}	return $errors;}function validateLostPassword($username, $email){	$errors = valid_username($username) . valid_email($email);	if(!user_exist($username))	{		$errors .= "<li>User not exists</li>";	}	else	{		if(!active_user($username))		{			$errors .= "<li>User not active</li>";		}	}	if(!email_exist($email))	{		$errors .= "<li>Email not exists</li>";	}	return $errors;}?>