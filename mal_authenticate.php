<?php 
session_start();

$user = $_POST['mal_user'];
$password = $_POST['mal_pw'];
$ch = curl_init("https://myanimelist.net/api/account/verify_credentials.xml");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$output = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($status == '200') {
	$credentialsXml = new SimpleXMLElement($output);
	$_SESSION['user'] = (string) $credentialsXml->username;
	$_SESSION['id'] = (string) $credentialsXml->id;
	// $_SESSION['user'] = $user;
	$_SESSION['password'] = $password;
	echo $_SESSION['user'];
	header('Location: app/index.php');
} else {
	// header('Location: index.php');
}
?>