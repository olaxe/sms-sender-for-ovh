<?php
session_start();
$page = $_SERVER['PHP_SELF'];
$sec = "30";
is_array($_SESSION["numeros"]) ?: die("You cannot connect directly to this page!");
count($_SESSION["numeros"])>0 ?: die('Finished, all the SMS have been sent!');
?>
<html>
    <head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
<body>
<?php

$numero = array_shift($_SESSION["numeros"]);

echo $numero."<br>";
echo $_SESSION["message"];
echo "<br>";

function getip() {
	// IP si internet partagé
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	// IP derrière un proxy
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	// Sinon : IP normale
	else {
		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}
}
function sendsms($numero){
	$ch = curl_init();
	$curlConfig = array(
		CURLOPT_URL            => "https://www.ovh.com/cgi-bin/sms/http2sms.cgi",
        	CURLOPT_POST           => true,
        	CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 300,
		CURLOPT_TIMEOUT => 300,
        	CURLOPT_POSTFIELDS     => array(
        		'account' => $_ENV["OVH_ACCOUNT"],
        		'login' => $_ENV["OVH_LOGIN"],
			'password' => $_ENV["OVH_PASSWORD"],
			'from' => $_ENV["OVH_FROM"],
			'to' => $numero,
			'message' => $_SESSION["message"],
			'noStop' => '1'
        	)
	);
	curl_setopt_array($ch, $curlConfig);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
$mysqli = new mysqli($_ENV["SMS_DB_HOST"], $_ENV["SMS_USER"], $_ENV["SMS_PASSWORD"], $_ENV["SMS_DB"]);

/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
}

$ret=sendsms($numero);

$query = "INSERT INTO logs VALUES (NULL, 'Admin', '".getip()."' , current_timestamp(), '".$_ENV["OVH_FROM"]."', '".$numero."', '".$_SESSION["message"]."', 1, '".$ret."')";
if (!$mysqli->query($query)) {
	printf("Message d'erreur : %s\n", $mysqli->error);
}

//$ret=sendsms($numero);
print_r($ret);
echo "<br>";
printf($ret);
echo "<br>";

/* Fermeture de la connexion */
$mysqli->close();

echo '<meta http-equiv="refresh" content="3">';
?>
</body>
</html>
