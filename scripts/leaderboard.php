<?php

//*** This PHP script accesses the server database and echos the data formatted as XML.***
//*** Written  by Chris Bowen BSkyB Ltd 10-03-2010

//*** uncomment to write file leaderboard.xml ***
//$File = "leaderboard.xml";
//*** uncomment to write file leaderboard.xml ***
//$Handle = fopen($File, 'w');

//*** Connect to DB
mysql_connect("10.20.88.46", "SkyGames", "h1ghd1v3") or die(mysql_error());
mysql_select_db("highscores") or die(mysql_error());

//*** Gets top 100 scores
$result = mysql_query("SELECT * FROM tblEntry WHERE compId=4 order By score desc limit 100");
$Data = "<leaderboard>\n\n";

//*** uncomment to write file leaderboard.xml ***
//fwrite($Handle, $Data);

echo $Data;

//** Enter results loop
while($row = mysql_fetch_array($result))
  {
  $Data = "\t<entry>\n\t\t<username>";

//*** uncomment to write file leaderboard.xml ***
//  fwrite($Handle, $Data);
echo $Data;

//*** uncomment to write file leaderboard.xml ***
//  fwrite($Handle, $row['uName']);
echo $row['uName'];

  $Data = "</username>\n\t\t<score>";

//*** uncomment to write file leaderboard.xml ***
//  fwrite($Handle, $Data);
echo $Data;

//*** uncomment to write file leaderboard.xml ***
//  fwrite($Handle, $row['score']);
echo $row['score'];

  $Data = "</score>\n\t</entry>\n\n";

//*** uncomment to write file leaderboard.xml ***
//  fwrite($Handle, $Data);
echo $Data;


  }

$Data = "</leaderboard>\n";
//*** uncomment to write file leaderboard.xml ***
//fwrite($Handle, $Data);
echo $Data;


//*** uncomment to write file leaderboard.xml ***
//fclose($Handle);



mysql_close($con);


//*** uncomment to write file leaderboard.xml ***
//include "leaderboard.xml";

?>