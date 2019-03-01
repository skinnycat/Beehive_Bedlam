<?php

/**
 * This script will send a link to the game to the users friend
 */

// read post request string
$user_name = ($_POST['username']);
$user_email = ($_POST['useremail']);

$friend_name1 = ($_POST['friendname1']);
$friend_email1 = ($_POST['friendemail1']);

$opt_out = ($_POST['optOut']);

// setup mail properties
$to      = $friend_email1;
$subject = "Play Beehive Bedlam!";
$message = "It's great!";

$headers = 'From: ';
$headers .= $user_name;
$headers .= ' <';
$headers .= $user_email;
$headers .= '>' . "\r\n";

// send the mail
mail($to, $subject, $message, $headers);

// ------- DEBUG SECTION!!!! Remove for production server -----------------

// write output to log file to debug
$fp = fopen("sendtofriend.log.txt", "a+");
fwrite( $fp, 'Date: ' . date( DATE_COOKIE ) . "\r\n" );
fwrite( $fp, 'To: ' . $to . "\r\n" );
fwrite( $fp, $headers );
fwrite( $fp, 'Subject: ' . $subject . "\r\n" );
fwrite( $fp, 'Message: ' . $message . "\r\n\r\n" );
fclose( $fp );


// -------- END DEBUG ------------------------

//send variables back to Flash
echo "success=1";

?>