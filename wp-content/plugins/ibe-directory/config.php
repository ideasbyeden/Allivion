<?php
	
define('DIRECTORY_LOGINPATH', '/');
define('DIRECTORY_RECADMIN', '/recruiter-dashboard');
define('DIRECTORY_ADVADMIN', '/advertiser-dashboard');
define('DIRECTORY_CANDADMIN', '/candidate-dashboard');
define('DIRECTORY_CREATEUSERPATH', '/user/create');
define('DIRECTORY_UPDATEUSERPATH', '/user/update');
define('POSTTITLEFIELD', 'job_title');

// define urls for pages using specific templates
// limit template usage to n pages

/*-------------------------
	
URLs
----

Recruiter admin urls

/recruiter/dashboard
/recruiter/users
/recruiter/users/create
/recruiter/users/update

Recruiter urls

/recruiter/dashboard
/recruiter/profile
/recruiter/<itemtype>

/candidate/dashboard
/candidate/profile
/candidate/<itemtype>

/advertiser/dashboard