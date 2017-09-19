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
	$_SESSION['user'] = $user;
	header('Location: app/index.php');
} else {
	header('Location: index.php');
}
?>