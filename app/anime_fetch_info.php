<?php
session_start();

unset($_SESSION['searchResultsXml']);

$id = $_POST['id'];
$title = $_POST['title'];
// echo $id;
// echo $title;

$ch = curl_init("https://myanimelist.net/api/anime/search.xml?q=" . urlencode($title));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $_SESSION['user'].":".$_SESSION['password']); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$output = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$_SESSION['searchResultsXml'] = $output;
?>