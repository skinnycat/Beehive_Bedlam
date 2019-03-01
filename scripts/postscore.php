<?php
/**
 * This PHP script needs to read variables that are posted to it and write them to the scores database.
 */

// read post request string (username, email, score)
$user_name = ($_REQUEST['username']);
$user_email = ($_REQUEST['useremail']);
$user_mobile = ($_REQUEST['userMobile']);
$user_dob = ($_REQUEST['userDob']);
$score = ($_REQUEST['score']);
$opt_out = ($_REQUEST['optOut']);
$todays_date = date("Y-n-j");
$current_time = date("H:i");


// ------------------------- write data to database here ------------------------------

mysql_connect("10.20.88.46", "SkyGames", "h1ghd1v3") or die(mysql_error());
mysql_select_db("highscores") or die(mysql_error());

// ------------------------- write data to database here ------------------------------

mysql_connect("10.20.88.46", "SkyGames", "h1ghd1v3") or die(mysql_error());
mysql_select_db("highscores") or die(mysql_error());

// --***-- BEEHIVE COMPETITION ID : 4 --***--

$replace_this = array ('/\</','/\>/');
$with_this = array ('','');

$user_name = preg_replace($replace_this, $with_this, $user_name);

$score_query = "insert into tblEntry values ( '', '$todays_date', '$current_time', '$score', '4', '$user_name', '$user_email' , '$user_mobile' , '$user_dob', '', '', '$opt_out', '', '','','','');";

mysql_query($score_query);

//send success variables back to Flash
echo "success=1";
?>