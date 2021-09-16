<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Plastron doo Sarajevo</title>
<link href="css.css" rel="stylesheet" type="text/css" />

<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<script type="text/javascript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
<style type="text/css">
.nazad {
	text-align: right;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #333;
}
a:link {
	color: #c00000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #C00000;
}
a:hover {
	text-decoration: underline;
	color: #700;
}
a:active {
	text-decoration: none;
	color: #C00000;
}
</style>
</head>
<body>
<table width="1100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="nazad"><a href="index.html">Nazad</a></td>
  </tr>
  <tr>
    <td><img src="img/preko2.jpg" width="1100" height="286" alt="a" /></td>
  </tr>
  <tr>
    <td><?php
//-----------------------------------------------------------------------------
// BellaBuzz v2 Copyright © Jem Turner 2008,2009 unless otherwise noted
// http://www.jemjabella.co.uk/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License. See README.txt
// or LICENSE.txt for more information.
//-----------------------------------------------------------------------------

@require('prefs.php');

if (isset($_COOKIE['bellabuzz'])) {
	if ($_COOKIE['bellabuzz'] == md5($admin_pass.$secret)) {
		if (isset($_GET['page'])) $page = $_GET['page'];
		else $page = NULL;
		
		doAdminHeader();
		switch($page) {
		case "answer":
			if (!isset($_GET['ques']) || !is_numeric($_GET['ques']))
				exit("Invalid question.");
			
			doQuestionForm($_GET['ques'], UNANSWERED);
		break;
		case "edit":
			if (!isset($_GET['ques']) || !is_numeric($_GET['ques']))
				exit("Invalid question.");
			
			doQuestionForm($_GET['ques'], ANSWERED);
		break;
		case "editprocess":
			if ($_SERVER['REQUEST_METHOD'] != "POST")
				doError("This page must not be accessed directly.");

			if (doIpCheck($_SERVER['REMOTE_ADDR']) === false)
				doError("Invalid IP; no need to fiddle with the readonly form elements.");

			foreach ($_POST as $key => $val) {
				$$key = preg_replace("/,(?! )/", ", ", trim(strip_tags($val)));
			}

			$answer = str_replace("<br /><br /><br /><br />", "<br /><br />", preg_replace("([\r\n])", "<br />", $answer));
			$storeit = $name.',"'.$question.'",'.$dateask.','.$ip.',"'.$answer.'",'.$dateanswer."\r\n";

			if ($file == "answered.txt") {
				$questions = file(ANSWERED);
				$questions[$quesid] = $storeit;
				doWrite(ANSWERED, implode($questions), "w");
			} elseif ($file == "unanswered.txt") {
				$openquestions = file(UNANSWERED);
				unset($openquestions[$quesid]);
				doWrite(UNANSWERED, implode($openquestions), "w");
				
				$questions = file(ANSWERED);
				$questions[] = "\r\n".$storeit;
				doWrite(ANSWERED, implode($questions), "w");
			}
			
			echo '<p>Question answered. <a href="admin.php">Return to main?</a></p>';
		break;
		case "delete":
			if (!isset($_GET['ques']) || !is_numeric($_GET['ques']))
				exit("Invalid question.");
				
			if (!isset($_GET['file']) && ($_GET['file'] != "answered.txt" || $_GET['file'] != "unanswered.txt"))
				exit("Invalid file");
			
			$questions = file($_GET['file']);
			unset($questions[$_GET['ques']]);
			doWrite($_GET['file'], implode($questions), "w");
			
			echo '<p>Question deleted. <a href="admin.php">Return to main?</a></p>';
		break;
		case "viewall":
			if (!isset($_GET['file']) && ($_GET['file'] != "answered.txt" || $_GET['file'] != "unanswered.txt"))
				exit("Invalid file");
			
			if ($_GET['file'] == "unanswered.txt") {
				echo '<h1>Unanswered Questions</h1>';
				doDisplayQuesAdmin("answer", UNANSWERED, doCount("open"));
			} else {
				echo '<h1>Answered Questions</h1>';
				doDisplayQuesAdmin("edit", ANSWERED, doCount("done"));
			}
		break;
		default:
?>
			<h1>Latest Unanswered Questions</h1>
<?php
			if (doCount("open") > 0) doDisplayQuesAdmin("answer", UNANSWERED, $perpage);
			else echo '<p>No unanswered questions.</p>';
?>
			<p><a href="admin.php?page=viewall&amp;file=unanswered.txt">View all unanswered</a></p>
			
			<h1>Latest Answered Questions</h1>
<?php
			if (doCount("done") > 0) doDisplayQuesAdmin("edit", ANSWERED, $perpage);
			else echo '<p>No answered questions.</p>';
?>
			<p><a href="admin.php?page=viewall&amp;file=answered.txt">View all answered</a></p>
<?php
		break;
		}
		doAdminFooter();
		exit;
	} else {
		exit("<p>Bad cookie. Clear 'em out and start again.</p>");
	}
}

if (isset($_GET['p']) && $_GET['p'] == "login") {
	if ($_POST['name'] != $admin_name || $_POST['pass'] != $admin_pass) {
		doAdminHeader();
?>
			<p>Sorry, that username and password combination is not valid. Try again.</p>

		    <form method="post" action="admin.php">
		    Username:<br>
		    <input type="text" name="name"><br>
		    Password:<br>
		    <input type="password" name="pass"><br>
		    <input type="submit" name="submit" value="Login">
		    </form>
<?php
		doAdminFooter();
		exit;
	} else if ($_POST['name'] == $admin_name && $_POST['pass'] == $admin_pass) {
		setcookie('bellabuzz', md5($_POST['pass'].$secret), time()+(31*86400));
		header("Location: admin.php");
		exit;
	} else {
		setcookie('bellabuzz', NULL, NULL);
		header("Location: admin.php");
		exit;
	}
}
doAdminHeader();
?>
    <form method="post" action="admin.php?p=login">
    Username:<br>
    <input type="text" name="name"><br>
    Password:<br>
    <input type="password" name="pass"><br>
    <input type="submit" name="submit" value="Login">
    </form>
<?php
doAdminFooter();
?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="footer">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>