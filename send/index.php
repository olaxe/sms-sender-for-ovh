<?php
session_start();
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
?>
<!DOCTYPE html>
<html>
	<head>
     		<meta charset="utf-8">
     		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Website to send SMS</title>

	<body>
		<form method="post" action="init.php">
			Phone numebers format +336... :<br><textarea rows="20" cols="12" name="numeros"></textarea><br>
			Message: <input type="text" name="message" size="160"><br>
			<input type="submit" value="OK">
		</form>
	</body>
</html>
