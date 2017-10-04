<?php 
session_start();

$query = $_POST['search_query'];
$ch = curl_init("https://myanimelist.net/api/anime/search.xml?q=" . urlencode($query));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $_SESSION['user'].":".$_SESSION['password']); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$output = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
try {
	$data = new SimpleXMLElement($output);
	foreach($data->entry as $a) {
		$score = $a->score;
		$year = substr($a->start_date, 0, 4);
		if ($a->status == 'Not yet aired') {
			$score = 'N/A';
		}
		if ($year == '0000') {
			$year = 'N/A';
		}
	    echo '<li class="mdc-list-item search_result_item" anime_id="' . $a->id . '" anime_title="' . $a->title . '">';
	    echo '<img class="mdc-list-item__start-detail search_result_thumb" style="width: 49px; height: 72px;" src="' . $a->image . '">';
	    echo '<span class="mdc-list-item__text anime_title">' . $a->title;
	    echo '<span class="mdc-list-item__text__secondary">(' . $a->type . ', ' . $year . ') <i class="material-icons list-icon">star_rate</i>' . $score;
	    echo '</span></span></li>';
	}
} catch (Exception $e) {
	echo '<li class="mdc-list-item">';
	echo '<span class="mdc-list-item__text">No results. Try searching something else.';
	echo '</span></li>';
}
?>