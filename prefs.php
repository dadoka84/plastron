<?php
//-----------------------------------------------------------------------------
// BellaBuzz v2 Copyright © Jem Turner 2008,2009 unless otherwise noted
// http://www.jemjabella.co.uk/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License. See README.txt
// or LICENSE.txt for more information.
//-----------------------------------------------------------------------------


// ADMIN SETTINGS
$admin_name = "admin";   // admin username (numbers and letters only)
$admin_pass = "buonarte";   // admin password
$admin_email = "dadoka84@hotmail.com";   // admin e-mail address
$secret = "damir123";   // this is like a second password. you won't have to remember it, so make it random


// GENERAL SETTINGS
$namefield = "yes"; // (yes or no) show/accept name field
$namereq = "no"; // (yes or no) name field required? (only works if $showname is set to yes)
$emailonask = "no";	// (yes or no) email admin when new question is asked
$floodcontrol = "yes"; // (yes or no) basic flood control - allows only 1 unanswered question per person at a time
$blockurls = "yes"; // (yes or no) block urls to help prevent spam

$perpage = 10;   // number of questions per page
$timestamp = "dS F, y";   // timestamp for last update on index.php (see php.net/date)
$showall = "yes"; // (yes or no) show unanswered questions as well as answered
$sortby = "newest"; // (newest or oldest) sort questions preference





// REQUIRED TO WORK
define("ANSWERED", "answered.txt");
define("UNANSWERED", "unanswered.txt");
require_once('functions.php');
?>