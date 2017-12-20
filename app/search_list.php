<?php
session_start();
$query = $_POST['search_query'];
$anime_xml = file_get_contents('http://myanimelist.net/malappinfo.php?u=' . $_SESSION['user'] . '&status=all&type=anime');
$anime_data = new SimpleXMLElement($anime_xml);
$list_array = [];
foreach($anime_data->anime as $anime) {
	$similarity = 0;
	similar_text(strtolower($query), strtolower(substr($anime->series_title, 0, strlen($query))), $similarity);
	if ($similarity >= 75) {
		$anime_info = [
			"similarity" => $similarity,
			"id" => $anime->series_animedb_id,
			"title" => $anime->series_title,
			"image" => $anime->series_image,
			"episodes" => $anime->series_episodes,
			"user_episodes" => $anime->my_watched_episodes,
			"user_score" => $anime->my_score
		];
		array_push($list_array, $anime_info);
	}
}
usort($list_array, function($a,$b) {
	return $a['id'] < $b['id'];
});
usort($list_array, function($a,$b) {
	return $a['similarity'] < $b['similarity'];
});
echo json_encode($list_array);
?>