<?php
session_start();
$status = $_POST['status'];
$sort = $_POST['sort'];
$anime_xml = file_get_contents('http://myanimelist.net/malappinfo.php?u=' . $_SESSION['user'] . '&status=all&type=anime');
$anime_data = new SimpleXMLElement($anime_xml);
$list_array = [];
foreach($anime_data->anime as $anime) {
	if ($anime->my_status == $status) {
		$anime_info = [
			"id" => $anime->series_animedb_id,
			"title" => $anime->series_title,
			"image" => $anime->series_image,
			"type" => $anime->series_type,
			"episodes" => $anime->series_episodes,
			"status" => $anime->series_status,
			"start_date" => $anime->series_start,
			"end_date" => $anime->series_end,
			"episodes" => $anime->series_episodes,
			"user_episodes" => $anime->my_watched_episodes,
			"user_score" => $anime->my_score
		];
		array_push($list_array, $anime_info);
	}
}
usort($list_array, function($a,$b) {
	return strnatcasecmp($a['title'], $b['title']);
});	
if ($sort == 2) {
	usort($list_array, function($a,$b) {
		return intval($a['type']) > intval($b['type']);
	});
} else if ($sort == 3) {
	usort($list_array, function($a,$b) {
		return intval($a['episodes']) > intval($b['episodes']);
	});
} else if ($sort == 4) {
	usort($list_array, function($a,$b) {
		return intval($a['status']) > intval($b['status']);
	});
}
echo json_encode($list_array);
?>