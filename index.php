<?php

session_start ();

$full_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url_parts = explode("/", $full_url);
array_pop($url_parts);
$base_url = implode("/", $url_parts)."/";

// set the session string so that mac's can call urls and retain their session id's
$session_string = urlencode (session_name()."=".session_id());

// the url to direct users to in Facebook
$fb_link_url = "http://games.sky.com/play-beehive-bedlam/";

// the css file that determines the size the page is displayed at
$css_file = "styles/beehivelanding.css";

// do we want to show the like button?
$show_like_btn = false;

// do we want to display a footer image (To hide tha gap needed for FB share dialog)
$show_footer = true;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />

		<meta property="og:title" content="Beehive Bedlam"/>
		<meta property="og:type" content="game"/>
		<meta property="og:url" content="<?php echo $fb_link_url; ?>"/>
		<meta property="og:image" content="http://stage-games.sky.com/beehive/images/beehive_thumb.jpg"/>

		<title>Beehive Bedlam</title>

		<script type="text/javascript" src="js/swfobject.js"></script>
		<script type="text/javascript" src="js/beehive_facebook.js"></script>

		<link rel="stylesheet" type="text/css" href="<?php echo $css_file; ?>" />

	</head>

	<body scroll="no">

		<div id="fb-root"></div>

		<script>

			// setup FB loading
			window.fbAsyncInit = setupFacebook;
			(function() {
				var e = document.createElement('script');
				e.async = true;
				e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
				document.getElementById('fb-root').appendChild(e);
			}());
		</script>

		<?php if( $show_like_btn ) { ?>

		<div id="divHeader">
			<fb:like show_faces="false" colorscheme="dark" />
		</div>

		<?php } ?>

		<div id="gameBox">
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

	        // Flash vars passed to the embedded SWF
            var flashVars = {
                    baseUrl: "<?php echo $base_url; ?>"
            };

            // Flash movie attributes
            var swfAttributes = {
				bgcolor: "#FFFFFF",
				id: "divFlashContent"
            };

			// Opera and IE6 need to be wmode 'window', everything else 'opaque'
			var user_agent = navigator.userAgent;
			var version_offset;
			var swf_wmode = "opaque";

//			alert( user_agent + '\n' + navigator.appVersion );

			if ( ( version_offset = user_agent.indexOf("MSIE")) != -1 ) {

				var full_version = user_agent.substring( version_offset + 5 );
				var major_version = parseInt( '' + full_version, 10 );

				if ( isNaN( major_version ) ) {
					major_version = parseInt( navigator.appVersion, 10 );
				}

				if ( major_version < 7 ) {
					// IE6 Does not like wmode 'opaque'
					swf_wmode = "window";
				}
			} else if( user_agent.indexOf("Opera") != -1 ) {
				// wmode 'opaque' causes Opera to crash alot
				swf_wmode = "window";
			}

//			alert(swf_wmode);

            // Flash movie params
            var params = {
				wmode: swf_wmode
            };

            // embed SWF in HTML
            swfobject.embedSWF( "flash/beehivebedlam.swf?build=62", "divFlashContent", "100%", "100%", "9", "flash/expressinstall.swf" , flashVars, params, swfAttributes );

        </script>

		<?php if( $show_footer ) { ?>

        <div id="divFooterBar">
        	<!-- A footer image will go here to hide the gap created by space needed for Facebook share dialog -->
        </div>

		<?php } ?>

	</body>

</html>