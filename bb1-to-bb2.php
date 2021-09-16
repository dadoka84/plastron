<?php
/*
	CONVERT BELLABUZZ 1 TO
	BELLABUZZ 2
*/

?>

<style type="text/css">
p { font: 11px Arial, Verdana, Sans-Serif; }
</style>

<h1>Answered</h1>
<p>
<?php
$answered = file("answered.txt");
foreach ($answered as $line)
	echo ",".$line."<br>";
?>
</p>

<h1>Unanswered</h1>
<p>
<?php
$unanswered = file("unanswered.txt");
foreach ($unanswered as $line)
	echo ",".$line."<br>";
?>
</p>