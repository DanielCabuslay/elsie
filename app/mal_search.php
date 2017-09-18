<?php 
session_start();

$query = $_POST['search_query'];
$query = str_replace(" ", "+", $query);
$ch = curl_init("https://myanimelist.net/api/anime/search.xml?q=" . $query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $_SESSION['user'].":".$_SESSION['password']); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$output = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
var_dump($output);
?>