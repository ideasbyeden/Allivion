<?php

if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
		$user = fetch();
		populateForm($user);
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else {
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        //$_SESSION = array();
    }
}
  
function getAccessToken() {
	
	$url = 'https://www.linkedin.com/uas/oauth2/accessToken';
    
    $postfields = array(
		'grant_type' => 'authorization_code',
		'code' => $_GET['code'],
		'redirect_uri' => get_bloginfo('url').'/careers',
		'client_id' => '7705nq4xobzlx1',
		'client_secret' => 'N43QKGZrRnBukG8y'
    );
    
    foreach($postfields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
			
    //cURL starts
    $token = curl_init();
    curl_setopt($token, CURLOPT_URL, $url);
    curl_setopt($token, CURLOPT_POST, 5);
    curl_setopt($token, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($token, CURLOPT_POSTFIELDS, $fields_string);
    $reply = curl_exec($token);

    //error handling for cURL
    if ($reply === false) {
       // throw new Exception('Curl error: ' . curl_error($crl));
       print_r('Curl error: ' . curl_error($token));
    }
    curl_close($token);
    //cURL ends

    //decoding the json data
    $tokendata = json_decode($reply, true);
    $_SESSION['access_token'] = $tokendata['access_token']; // guard this!
    $_SESSION['expires_in']   = $tokendata['expires_in']; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time

	return true;
	
}
 
function fetch() {
	              
    $profile = curl_init();
    curl_setopt($profile, CURLOPT_URL, 'https://api.linkedin.com/v1/people/~:(first-name,last-name,email-address,phone-numbers,date-of-birth,summary,main-address,public-profile-url)?oauth2_access_token='.$_SESSION['access_token'].'&format=json');
    curl_setopt($profile, CURLOPT_RETURNTRANSFER, true);
    $reply = curl_exec($profile);

    //error handling for cURL
    if ($reply === false) {
       // throw new Exception('Curl error: ' . curl_error($crl));
       print_r('Curl error: ' . curl_error($profile));
    }
    curl_close($profile);
    
    return $reply;
    //return simplexml_load_string($reply);
	
}

function populateForm($user){ 
	
?>
	
	<script>
		jQuery(function(){
			var user = <?php echo $user ?>;
			console.log(user);
			if(typeof user.firstName != 'undefined') jQuery('input[name="first_name"]').val(user.firstName);
			if(typeof user.lastName != 'undefined') jQuery('input[name="last_name"]').val(user.lastName);
			if(typeof user.emailAddress != 'undefined') jQuery('input[name="email"]').val(user.emailAddress);
			if(typeof user.summary != 'undefined') jQuery('[name="message"]').val(user.summary);						
		});
	</script>
		
 <? } ?>