<?php
/*
	CONVERT WAKS ASK N ANSWER TO
	BELLABUZZ 2
*/
$waksquestions = file("askanswer.txt");
$total = count($waksquestions);

$unanswered = array();
$answered = array();

$i = 0;
while ($i<$total) {
	list($id,$question,$answer,$ip,$dateask,$dateanswer) = explode("\¦", $waksquestions[$i]);
	if (!empty($question) && date('Y', $dateask) != "1970") {
		if (date('Y', $dateanswer) != "1970")
			$answered[] = ','.trim($question).",".date('Y-m-d H:i:s', $dateask).",".$ip.",".trim(str_replace("\r", " ", str_replace("\n", " ", strip_tags($answer)))).",".date('Y-m-d H:i:s', $dateanswer);
		else
			$unanswered[] = ','.trim($question).",".date('Y-m-d H:i:s', $dateask).",".$ip.",".trim(str_replace("\r", " ", str_replace("\n", " ", strip_tags($answer)))).",".date('Y-m-d H:i:s', $dateanswer);
	}
	$i++;
}
?>

<style type="text/css">
p { font: 11px Arial, Verdana, Sans-Serif; }
</style>

<h1>Answered</h1>
<p>
<?php
foreach ($answered as $line)
	echo $line."<br>";
?>
</p>

<h1>Unanswered</h1>
<p>
<?php
foreach ($unanswered as $line)
	echo $line."<br>";
?>
</p>