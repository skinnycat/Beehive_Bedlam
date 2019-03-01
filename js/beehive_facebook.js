/*
	JS File for communication between Flash and Facebooks API
*/

// Sky's Facebook application ID
var fb_app_id = '364822814313';

// Sky Test application ID
//var fb_app_id = '350625974965866';

// The games base URL (Where it is hosted)
var game_server_url = 'http://games.sky.com/play-beehive-bedlam/';

// the url that is featured in the FB messages
var game_link_url = 'http://games.sky.com/play-beehive-bedlam/';

//id of the swf embedded in the page
var swf_id = 'divFlashContent';

// is the Flash ready for JS calls?
var flash_ready = false;

// are we ready / connected to Facebook?
var facebook_ready = false;
var user_connected = false;

// user data
var fb_user_data;
var fb_user_friends;


/**
 * sets up the app to connect to Facebook via JavaScript
 * Called once the Facebook JS API has been loaded by the holding page
 */ 

var fbApiInit = false;

function setupFacebook () {
	// initialise the FB API
	FB.init( { appId: fb_app_id, status: true, cookie: true, xfbml: true,  oauth: true } );
	
	// Get the users FB login status
	fbApiInit = true; //init flag
}

/**
 * Whilst this code isn't strictly necessary it helps stops multiple calls.
 */

function fbEnsureInit(callback) {
	
    if( !window.fbApiInit ) {
        setTimeout( function() { fbEnsureInit(callback); }, 50);
    } else {
    	
        if( callback ) {
            callback();
        }
    }
}

fbEnsureInit( readyCallback );

function readyCallback() {
	
	//NOTE: 05/09/2011 There is a bug with Facebook where if you're in sandbox mode and not logged in, the callback from FB.getLoginStatus never fires.
	//Move out of sandbox mode to test.
	FB.getLoginStatus( onInitLoginStatus );

}



/**
 * handle user login status from Facebook
 * @param response The response object from Facebook
 * @return
 */

function onInitLoginStatus( response ) {
	// do something with response
	
	if( response.session ) {
		user_connected = true;
	} else {
		user_connected = false;
	}
	
	// set the Facebook ready flag
	facebook_ready = true;
	
	if( facebook_ready && flash_ready ) {
	
		flashMovie().facebookAPIReady( FB.getAuthResponse () );
		
		if( user_connected ) {
			loadUserData();
		}
	}
	
}

/**
 * Sets a flag to say that the Flash is ready for JS calls
 * Called from the Flash JS Proxy once it is ready
 */

function flashReady() {
	// set the Flash ready flag
	flash_ready = true;
	
	if( facebook_ready && flash_ready ) {
		
		flashMovie().facebookAPIReady( FB.getAuthResponse () );
		
		if( user_connected ) {
			loadUserData();
		}
	}
}

/** 
 * Shares the users score on their Facebook stream.
 * Called from the Flash.
 */

function fbShareScore ( score ) {
	
	FB.ui(
			{
				method		: 'feed',
				name		: 'I got a Hi Score on Beehive Bedlam!',
				caption		: '{*actor*} got a Hi Score of ' + score + ' while playing Beehive Bedlam!.',
				description	: 'Match flowers and play through 25 fantastic levels.',
				link		: game_link_url,
				picture		: 'http://stage-games.sky.com/beehive/images/beehive_thumb.jpg',
				actions 	: [ { name : 'Play', link : game_link_url } ]
			}
	);
	
}

/**
 * 
 * @return
 */

function fbUserLogin() {
	
	//alert("fbUserLogin already connected : " + user_connected );
	
	if( user_connected ) {
		//alert('User already logged in');
		loadUserData();
		
	} else {
		
		FB.login( onUserLogin, { scope: 'email' } );
	}
}

/**
 * 
 * @param response
 * @return
 */

function onUserLogin( response ) {
	
	// do something with response
	if (response.authResponse) {
		
		// set the user as connected
		user_connected = true;
		
		// make sure the Flash has the session data
		//flashMovie().facebookAPIReady( FB.getSession() );
		flashMovie().facebookAPIReady( FB.getAuthResponse () );
		
		// get the users data!
		loadUserData();
		
	} else {
		user_connected = false;
		
		// there is no session. fail!
//		alert( 'Failed to login: ' + response.status + ' ' + response.session );
	}
	
}

/**
 * Loads the users Facebook data
 * @return
 */

function loadUserData() {
	// get the users data and friends data!
//	FB.api( '/me', onUserDataLoaded );
	FB.api(
			{ 
				method: 'fql.query', 
				query: 'SELECT uid, first_name, last_name, pic_square, email, birthday, locale FROM user WHERE uid = me()'
			},
			onUserDataLoaded
	);
}

/**
 * Handle the loaded user data, then load the users friends
 * @param response
 * @return
 */
function onUserDataLoaded(response) {
	fb_user_data = response[0];
	if( fb_user_data ) {
		FB.api( '/me/friends', onUserFriendsLoaded );
	}
}

/**
 * Handle the loaded friends and pass all the user data to the Flash
 * @param response
 * @return
 */
function onUserFriendsLoaded(response) {
	fb_user_friends = response;
	flashMovie().facebookUserLoaded( fb_user_data, fb_user_friends );
}

/**
 * Opens an invite dialog so the user can send the app to their friends.
 * Called from the Flash.
 */

function fbInviteFriends() {
	// make sure user is connected to Facebook
	if( user_connected ) {
		// they are, open the dialog
		openFBInviteDialog();
	} else {

		FB.login( onInviteLogin, { scope: 'email' } );
		
	}
}

/**
 * handle user login status from Facebook when attempting to login for inviting friends
 * @param response The response object from Facebook
 * @return
 */

function onInviteLogin (response) {
	
	// do something with response
	if (response.authResponse) {
		
		// set the user as connected
		user_connected = true;
		
		// make sure the Flash has the session data
		flashMovie().facebookAPIReady( FB.getAuthResponse() );
		
		// we have a session, open the dialog
		openFBInviteDialog();
		
	} else {
		user_connected = false;
		// there is no session. fail!
//		alert( 'Failed to login: ' + response.status + ' ' + response.session );
	}
}

function openFBInviteDialog() {
	
//	alert("openFBInviteDialog()");
	
	// create FBML invite string
	FB.ui(
		{
			method : 'apprequests',
			message: 'Play Beehive Bedlam online now!'
		}
	);
	
}

/**
 * 
 * @param response
 * @return
 */

function onInviteDialogResponse ( response ) {
	// this is only called when the form has not been submitted. If the form is submitted, the page is reloaded.
	flashMovie().inviteDialogClosed();
}

/**
 * Grab a reference to the swf
 */

function flashMovie() {
    if (navigator.appName.indexOf("Microsoft") != -1) {
        return window[swf_id];
    } else {
        return document[swf_id];
    }
}