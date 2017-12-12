<?php
session_start();
$id = $_POST['id'];
$anime_xml = file_get_contents('http://myanimelist.net/malappinfo.php?u=' . $_SESSION['user'] . '&status=all&type=anime');
$anime_data = new SimpleXMLElement($anime_xml);
foreach($anime_data->anime as $anime) {
	if ($anime->series_animedb_id == $id) {
		$array = [
			"id" => $anime->series_animedb_id,
			"title" => $anime->series_title,
			"image" => $anime->series_image,
			"type" => $anime->series_type,
			"episodes" => $anime->series_episodes,
			"status" => $anime->series_status,
			"start_date" => $anime->series_start,
			"end_date" => $anime->series_end,
			"user_status" => $anime->my_status,
			"user_episodes" => $anime->my_watched_episodes,
			"user_score" => $anime->my_score,
			"user_start_date" => $anime->my_start_date,
			"user_end_date" => $anime->my_finish_date
		];
		echo json_encode($array);
	}
}
?>