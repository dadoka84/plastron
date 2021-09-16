<?php
//-----------------------------------------------------------------------------
// BellaBuzz v2 Copyright © Jem Turner 2008,2009 unless otherwise noted
// http://www.jemjabella.co.uk/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License. See README.txt
// or LICENSE.txt for more information.
//-----------------------------------------------------------------------------

error_reporting(0);

function doError($message) {
	echo '<p style="color: red;">ERROR: '.$message.'</p>';
	exit;
}
function doIpCheck($ip) {
	$ipPattern = '/\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/i';
	if (!preg_match($ipPattern, $ip)) return false;
	else return true;
}

function doAskBox($showname) {
?>
	<form action="ask.php" method="post">
		<p>
			<span style="display: none;"><input type="checkbox" name="human" id="human"> <label for="human">Leave this unticked if you're human :)</label></span><br>
<?php
		if ($showname == "yes") {
?>
			<input type="text" name="name" id="name"> <label for="name">Name</label><br>
<?php
		}
?>
			<input type="text" name="question" id="question"> <label for="question">Question</label>
			<input type="submit" value="Ask">
		</p>
	</form>		
<?php
}

function doCount($cntype) {
	if ($cntype == "all")
		return count(file(ANSWERED)) + count(file(UNANSWERED));
	elseif ($cntype == "open")
		return count(file(UNANSWERED));
	elseif ($cntype == "done")
		return count(file(ANSWERED));
}

function doAdminHeader() {
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

	<html>
	<head>
		<title>BellaBuzz Control Panel</title>
		<style type="text/css">
			* { font: 11px/15px Verdana, Sans-Serif; }
			h1, th { font-weight: bold; }
			td, th { border: 1px solid #eee; padding: 2px 4px; }
			table { border-collapse: collapse; width: 500px; }
			img { border: 0; }
		</style>
	</head>
	<body>
<?php
}
function doAdminFooter() {
	echo "</body>\r\n</html>";
}

function doQuestionForm($quesid, $file) {
	$questions = file($file);
	list($name,$question,$dateask,$ip,$answer,$dateanswer) = preg_split("/,(?! )/", $questions[$quesid]);
?>
	<form action="admin.php?page=editprocess" method="post">
		<p>
			<input type="hidden" name="file" id="file" value="<?php echo $file; ?>" />
			<input type="hidden" name="quesid" id="quesid" value="<?php echo $quesid; ?>" />
			<input type="text" name="name" id="name" value="<?php echo stripslashes($name); ?>" /> <label for="name">Name</label><br>
			<input type="text" name="question" id="question" value="<?php echo stripslashes(trim($question, "\"\x00..\x1F")); ?>" /> <label for="question">Question</label><br>
			<textarea name="answer" id="answer" rows="5" cols="35"><?php echo stripslashes(trim($answer, "\"\x00..\x1F")); ?></textarea> <label for="answer">Answer</label><br>
			<input type="text" name="dateanswer" id="dateanswer" value="<?php echo date("Y-m-d H:i:s", time()); ?>"> <label for="dateanswer">Date Answered</label>
		</p>
		<p>
			<input type="text" name="ip" id="ip" value="<?php echo $ip; ?>" readonly="readonly"> <label for="ip">IP Address</label><br>
			<input type="text" name="dateask" id="dateask" value="<?php echo $dateask; ?>" readonly="readonly"> <label for="dateask">Date Asked</label><br>
			<input type="submit" value="Answer" />
		</p>
	</form>
<?php
}
function doDisplayQuesAdmin($mode, $file, $limit) {
	global $timestamp;

	$questions = file($file);
?>
	<table>
	<tr><th>Name</th> <th>Question</th> <th>Date Asked</th> <th>IP</th> <th>Admin</th></tr>
<?php
	$i = 0;
	if (count($questions) >= $limit) $limit = $limit;
	else $limit = count($questions);
	
	while ($i < $limit) {
		$rowColour = ($i % 2) ? ' style="background: #fff;"' : ' style="background: #ffe;"';
		list($name,$question,$date,$ip,$answer,$dateanswer) = preg_split("/,(?! )/", $questions[$i]);
		$ip = trim($ip, "\"\x00..\x1F");
	
		echo '<tr'.$rowColour.'><td>'.$name.'</td> <td>'.$question.'</td> <td>'.date($timestamp, strtotime($date)).'</td> <td><a href="http://www.geobytes.com/IpLocator.htm?GetLocation&amp;ipaddress='.$ip.'"><img src="admin-icons/spy.gif" title="look-up IP: '.$ip.'" alt="look-up ip"></a></td> <td><a href="admin.php?page='.$mode.'&amp;ques='.$i.'"><img src="admin-icons/pencil.gif" title="'.$mode.' question" alt="'.$mode.'"></a> <a href="admin.php?page=delete&amp;ques='.$i.'&amp;file='.$file.'" onclick="javascript:return confirm(\'Are you sure you want to delete this question?\')"><img src="admin-icons/stop.gif" title="delete question" alt="delete"></a></td></tr>';
	
		$i++;
	}
?>
	</table>
<?php
}

function doWrite($file2open, $data, $writetype) {
	$file = fopen($file2open, $writetype) or die("Couldn't open the right questions file: the question could not be answered.");
	if (flock($file, LOCK_EX)) {
		fwrite($file, $data);
		flock($file, LOCK_UN);
	} else {
		exit("Couldn't open the right questions file: the question could not be answered.");
	}
	fclose($file);
}

function blanklinefix($inputfile) {
	ignore_user_abort(true);
	$content = file($inputfile);

	if (count($content) > 0) {
		$content = array_diff(array_diff($content, array("")), array("\r\n"));

		$newContent = array();
		foreach ($content as $line) {
			$newContent[] = trim($line);
		}
		$newContent = implode("\r\n", $newContent);
	
		$fl = fopen($inputfile, "w+");
		if (flock($fl, LOCK_EX)) {
			fwrite($fl, $newContent);
			flock($fl, LOCK_UN);
		} else {
			echo 'The file: '.$inputfile.' could not be locked for writing; the blanklinefix function could not be applied at this time.';
		}
		fclose($fl);
	}
	ignore_user_abort(false);
}

blanklinefix(UNANSWERED);
blanklinefix(ANSWERED);
?>