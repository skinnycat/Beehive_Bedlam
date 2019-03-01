<?php

session_start ();

$full_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url_parts = explode("/", $full_url);
array_pop($url_parts);
$base_url = implode("/", $url_parts)."/";

// set the session string so that mac's can call urls and retain their session id's
$session_string = urlencode (session_name()."=".session_id());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
		
		<title>Beehive Bedlam</title>
		<script type="text/javascript" src="js/swfobject.js"></script>
		<script type="text/javascript" src="js/facebookconnect.js"></script>
		<script type="text/javascript" src="http://static.ak.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" ></script>
		
		<link rel="stylesheet" type="text/css" href="style/beehive.css" />
		
	</head>

	<body scroll="no">
		
		<div id="divWholeGameContent">
			
			<div id="divFlashContent">
				<p>In order to view this page you need <b>JavaScript</b> enabled and <b>Flash Player 9+</b> support!</p>
				<p>
					<a href="http://www.adobe.com/go/getflashplayer">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" border="0" />
					</a>
				</p>
			</div>
			
		</div>
		
		<script type="text/javascript">
			
			/**
			 * Embed the swf
			 */
            
            var flashVars = {
                    baseUrl: "<?php echo $base_url; ?>",
                    as_swf_name: "divFlashContent"
                 };
            
            var swfAttributes = {
                    bgcolor: "#FFFFFF",
                    id: "divFlashContent"
                 };
            
            var params = {
                wmode: "transparent"
            };

            // beehive bedlam
//            var api_key = "7398bcf83394c68381eedf6ec7afe34f";

            // Team Cooper Test
            var api_key = "5d888ca858458ed8cffae74ec4749e99";
            
            swfobject.embedSWF("flash/beehivebedlam_promotion.swf?v=1.2", "divFlashContent", "100%", "100%", "9", "flash/expressinstall.swf" , flashVars, params, swfAttributes);
            
            fbInit("divFlashContent", api_key, "xd_receiver.htm");
            
        </script>
		
		<div id="divCredits">
			<a href="http://www.teamcooper.co.uk/">Built by Team Cooper</a>
		</div>
		
	</body>

</html>