<?php
//-----------------------------------------------------------------------------
// BellaBuzz v2 Copyright © Jem Turner 2008,2009 unless otherwise noted
// http://www.jemjabella.co.uk/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License. See README.txt
// or LICENSE.txt for more information.
//-----------------------------------------------------------------------------

require('prefs.php');

if ($_SERVER['REQUEST_METHOD'] != "POST")
	doError("This page must not be accessed directly.");

$bots = "/(Indy|Blaiz|Java|libwww-perl|Python|OutfoxBot|User-Agent|PycURL|AlphaServer|DigExt|Jakarta|Missigua|psycheclone|LinkWalker|ZyBorg|Waterunicorn|ICS)/i";
if (preg_match($bots, $_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT']) || $_SERVER['HTTP_USER_AGENT'] == " ")
	doError("Tests on your user agent indicate that there's a high possibility you're a spam bot, and as such <strong>your question has been deleted</strong>.");

$ipPattern = '/\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/i';
if (doIpCheck($_SERVER['REMOTE_ADDR']) === false)
	doError("Invalid IP; no need to fiddle with the SERVER array.");

if (isset($_POST['human']))
	doError("Sorry, humans only!");
if (empty($_POST['question']) || strlen($_POST['question']) < 10)
	doError("No empty/spammy questions please.");
if ($namefield == 'no' && !empty($_POST['name']))
	doError("You're not allowed to fill your name in.");
if ($namereq == 'yes' && (empty($_POST['name']) || $_POST['name'] = ' '))
	doError("You must fill your name in.");

if ($blockurls == "yes") {
	if (substr_count($_POST['question'], 'http://') > 0 || substr_count($_POST['question'], 'url=') > 0)
		doError("To prevent link spamming, no URLs can be posted.");
}
if ($floodcontrol == "yes") {
	$questions = file(ANSWERED);
	list($name,$question,$dateask,$ip,$answer,$dateanswer) = preg_split("/,(?! )/", $questions[0]);
	$ip = trim($ip);

	if ($ip == $_SERVER['REMOTE_ADDR'])
		doError("Flood protection in force; you cannot ask a question twice in a row.");
}

if (doCount("open") == 0)
	$question = trim(strip_tags($_POST['name'])).',"'.preg_replace("/,(?! )/", ", ", trim(strip_tags($_POST['question']))).'",'.date("Y-m-d H:i:s", time()).','.$_SERVER['REMOTE_ADDR'].",,";
else 
	$question = "\r\n".trim(strip_tags($_POST['name'])).',"'.preg_replace("/,(?! )/", ", ", trim(strip_tags($_POST['question']))).'",'.date("Y-m-d H:i:s", time()).','.$_SERVER['REMOTE_ADDR'].",,";

doWrite(UNANSWERED, $question, "a");

if ($emailonask == "yes")
	mail($admin_email, "New question asked", "A question has been asked:\r\n".$_POST['question']."\r\nIP: ".$_SERVER['REMOTE_ADDR'], "From: $admin_email");
?>


<p>Your question was successfully added :) thank you! <a href="questions.php">return to questions?</a></p>