<?php
session_start();

// Détruit toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, effacez également
// le cookie de session.
// Note : cela détruira la session et pas seulement les données de session !
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalement, on détruit la session.
session_destroy();
?>
<!DOCTYPE html>
<html>
	<head>
     		<meta charset="utf-8">
     		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Site Free Runners pour envoyer les SMS</title>

	<body>
		<form method="post" action="init.php">
			Numéro(s) format +336... :<br><textarea rows="20" cols="12" name="numeros"></textarea><br>
			Message : <input type="text" name="message" size="160"><br>
			<input type="submit" value="OK">
		</form>
	</body>
</html>
