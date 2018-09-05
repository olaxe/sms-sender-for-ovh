<?php
session_start();

if( isset($_POST['numeros']) )
{
        $_SESSION["numeros"]=array_map('rtrim',array_map('trim',explode("\n",htmlspecialchars($_POST['numeros']))));
	$_SESSION["numeros"]=array_filter($_SESSION["numeros"]);
}
if( isset($_POST['message']) )
{
        $_SESSION["message"]=htmlspecialchars($_POST['message']);
}

print_r($_SESSION["numeros"]);
echo "<br>";
print_r($_SESSION["message"]);
echo "<br>";
?>
<html>
<body>
<form action="send.php" method="post">
<input type="submit">
</form>
</body>
</html>
