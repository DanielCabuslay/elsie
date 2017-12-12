<?php 
session_start();

$user = $_POST['mal_user'];
$xml = file_get_contents('http://myanimelist.net/malappinfo.php?u=' . $user . '&status=all&type=anime');
$data = new SimpleXMLElement($xml);
if ($data->count() == 0) {
	$_SESSION['message'] = 'Invalid username. Please enter a valid username.';
	header('Location: .');
} else {
	$_SESSION['user'] = $user;
	header('Location: app');
}
?>