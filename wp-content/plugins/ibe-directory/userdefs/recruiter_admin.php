<?php

///////////////////////////////////////////
//
// Define user role
// no spaces - letters, hyphen or underscore only
//
///////////////////////////////////////////
	
$role = 'recruiter_admin'; 


///////////////////////////////////////////
//
// Define item labelling (WordPress admin)
//
///////////////////////////////////////////

$label = 'Recruiter admin';


///////////////////////////////////////////
//
// Define user type admin root
//
///////////////////////////////////////////

$adminroot = '/recruiter-dashboard';


///////////////////////////////////////////
//
// Define questions / values for item type
// To add a question, add a new array to the end of $vars
//
// 	array(
//		'name' => 'question_2',
//		'label' => 'How question 2 is labelled?',
//		'instructions' => 'Further instructions on how to complete this question'
//		'placeholder' => 'field suggestion for question 2',
//		'fieldtype' => 'check', (can be 'text', 'textarea', 'richtext', 'dropdown', 'check', 'radio', 'password', 'email', 'file')
//		'value' => array(
//			'Option 1' 		=> '1',	
//			'Option 2' 		=> '2',	
//			'Option 3' 		=> '3'	
//		),
//		'group' => 'package',
//		'required' => 'publish', (can be 'save', 'publish'. Fields set to publish will also be required for save)
//		'extra_class' => 'myclass'
//	),
//
///////////////////////////////////////////



$vars = array(
	
	array(
		'name' => 'first_name',
		'label' => 'First name',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'basics',
		'required' => 'save',
		'keyword' => 'true'
	),

	array(
		'name' => 'last_name',
		'label' => 'Last name',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'basics'
	),
	
	array(
		'name' => 'user_email',
		'label' => 'Email',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'basics',
		'required' => 'save',
		'keyword' => 'true'
	),

	array(
		'name' => 'user_pass',
		'label' => 'Password',
		'placeholder' => '',
		'fieldtype' => 'password',
		'group' => 'basics',
		'required' => 'save',
		'keyword' => 'true'
	),

	array(
		'name' => 'confirm_user_pass',
		'label' => 'Confirm password',
		'placeholder' => '',
		'fieldtype' => 'password',
		'group' => 'basics',
		'required' => 'save',
		'keyword' => 'true'
	),
	
	array(
		'name' => 'recruiter_name',
		'label' => 'Name',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'profile',
		'required' => 'save',
		'keyword' => 'true'
	),

	array(
		'name' => 'logo',
		'label' => 'Logo',
		'placeholder' => '',
		'fieldtype' => 'file',
		'group' => 'profile'
	),
	
	array(
		'name' => 'boilerplate',
		'label' => 'Succinct profile / Boilerplate',
		'placeholder' => '',
		'fieldtype' => 'textarea',
		'group' => 'profile'
	),

	array(
		'name' => 'contact_phone',
		'label' => 'Contact phone no',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'profile'
	),
	
	array(
		'name' => 'default_app_email',
		'label' => 'Default application email',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'profile'
	),
);