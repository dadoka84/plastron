//--------------------
// READ ME
//--------------------

BellaBuzz v2 Copyright © Jem Turner 2007,2008,2009 unless otherwise noted
http://www.jemjabella.co.uk/

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.



Support is given at my leisure. If you need help, first check:
http://codegrrl.com/forums/index.php?showforum=39
..to make sure your problem isn't covered there. If it isn't, post there or 
feel free to contact me: jem@jemjabella.co.uk




//--------------------
// INSTRUCTIONS
//--------------------
1. Customise prefs.php - set your username, password and various preferences
2. Upload ALL of the files to a directory or the root folder of your webspace
3. CHMOD the .txts file to 666 - this makes it writeable
4. Customise the script to fit into your layout



__________________________ HOW DO I CHMOD/CHANGE FILE PERMISSIONS?

There are lots of tutorials on CHMODing which can be found through Google:
http://www.google.com/search?q=chmod+tutorial


__________________________ HOW DO I FIT THE SCRIPT INTO MY EXISTING LAYOUT?

The script has been designed to fit really easily into existing layouts :)

If you use PHP includes, open questions.php and replace from line:
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

up to line:
<body>

..with your header include (e.g. include('header.php'); )

Then replace:
</body>
</html>

with your footer include (e.g. include('footer.php'); )

If you're not using includes, leave the HTML in place, and simply style and 
customise those to suit. To change the appearance of the questions, use the 
following thre classes: .question, .answer and .dates


__________________________ HOW DO I CONVERT FROM WAK'S ASK & ANSWER?

Upload waks-converter.php to your waks folder, then visit it in your browser.
E.g. http://www.your-website.com/ask/waks-converter.php

Your questions should appear converted to the BellaBuzz format - copy the 
unanswered questions to unanswered.txt and the answered questions to 
answered.txt (these two files come with your copy of BellaBuzz)

Upload the txt files to your site with the rest of BellaBuzz, and your 
questions should work straight away.

Delete waks-converter.php and your Wak's install when you're done; the
script is very insecure and I do not recommend anyone continue using it.




//--------------------
// FEATURES
//--------------------
* Security on ask box to prevent spam bots
* Stripping of HTML and pointless special chars (security)
* Block URLs in questions to help prevent spam
* Admin panel to easily answer/delete questions
* Optional name field
* Hidden field spambot trap

//--------------------
// FIXES IN VERS 2
//--------------------
Editing answered question breaks previous answered question
New: optional name field
New: extra spam protection 
New: credit line (optional - remove it if you're skanky :p)

//--------------------
// FIXES IN VERS 1b
//--------------------
Fixed empty/short questions allowed bug - ask.php
Proper sorting by newest/oldest - prefs.php/questions.php



//--------------------
// CREDITS
//--------------------
Mucho thanks go to the following people for helping with BellaBuzz:

Amelie		- http://not-noticeably.net/ (reluctant testing)
Hannah		- http://creativeburst.org/ (testing, testing 123)
famfamfam	- http://www.famfamfam.com/lab/icons/silk/ (lovely icons)