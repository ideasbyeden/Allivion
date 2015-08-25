<?php
	session_name('linkedin');
	session_start();

    define('API_KEY',      '77sbnvi17cstc9');
	define('API_SECRET',   '2pVkUEjDZHIhqO3a');
	define('REDIRECT_URI', 'http://allivion/job');
	define('SCOPE',        'r_fullprofile r_emailaddress rw_nus r_contactinfo' );


    if ($_GET['linkedin'] == 'login') {
	    
	
	    $params = array('response_type' => 'code',
                    'client_id' => API_KEY,
                    'scope' => SCOPE,
                    'state' => uniqid('', true), // unique long string
                    'redirect_uri' => REDIRECT_URI,
              );
 
	    // Authentication request
	    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
	 
	    // Needed to identify request when it returns to us
	    $_SESSION['state'] = $params['state'];
	 
	    // Redirect user to authenticate
	    header("Location: $url");

	}