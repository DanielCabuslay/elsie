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
// $xml = file_get_contents($output);
$data = new SimpleXMLElement($output);
foreach($data->entry as $a) {
    echo '<li class="mdc-list-item search_result_item" anime_id="' . $a->id . '" anime_title="' . $a->title . '">';
    echo '<img class="mdc-list-item__start-detail search_result_thumb" src="' . $a->image . '">';
    echo '<span class="mdc-list-item__text anime_title">' . $a->title;
    echo '<span class="mdc-list-item__text__secondary">(' . $a->type . ', ' . substr($a->start_date, 0, 4) . ') <i class="material-icons list-icon">star_rate</i>' . $a->score;
    echo '</span></span></li><hr class="mdc-list-divider">';
}
// foreach($data->entry as $a) {
//     echo '<img src=' . $a->image . '>';
//     echo $a->title . '<br>';
// }
?>