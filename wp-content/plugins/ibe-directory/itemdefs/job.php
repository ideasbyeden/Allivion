<?php

///////////////////////////////////////////
//
// Define item type
// no spaces - letters, hyphen or underscore only
//
///////////////////////////////////////////
	
$type = 'job'; 


///////////////////////////////////////////
//
// Define item labelling (WordPress admin)
//
///////////////////////////////////////////

$label = 'jobs';
$single_label ='job';


///////////////////////////////////////////
//
// Define value arrays for multiple use
//
///////////////////////////////////////////

$sectors = array(
			'Agrictulture, Food & Veterinary' 		=> 'agri/food/vet',	
			'Architecture, Building & Planning' 	=> 'architecture/building',	
			'Biological Sciences' 					=> 'biological_science',
			'IT'									=> 'it'
			);


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
//		'fieldtype' => 'check', (can be 'text', 'date', 'textarea', 'richtext', 'dropdown', 'check', 'radio', 'password', 'email', 'file')
//		'value' => array(
//			'Option 1' 		=> '1',	
//			'Option 2' 		=> '2',	
//			'Option 3' 		=> '3'	
//		),
//		'datedisplay' => 'relative' (can be 'relative' for '3 days ago' or use PHP date function syntax eg 'jS M Y' for '12th Jan 2015'. Only affects field of type 'date')
//		'group' => 'package',
//		'required' => 'publish', (can be 'save', 'publish'. Fields set to publish will also be required for save)
//		'extra_class' => 'myclass'
//	),
//
///////////////////////////////////////////



$vars = array(
	
	array(
		'name' => 'job_title',
		'label' => 'Job title',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'headline',
		'required' => 'save',
		'keyword' => 'true'
	),

	array(
		'name' => 'job_ref',
		'label' => 'Job reference',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'headline'
	),
	
	array(
		'name' => 'job_func',
		'label' => 'Job function',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'headline',
		'keyword' => 'true'
	),

	array(
		'name' => 'job_level',
		'label' => 'Job level',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'headline',
		'keyword' => 'true'
	),
	
	array(
		'name' => 'salary_range',
		'label' => 'Salary range',
		'placeholder' => '',
		'fieldtype' => 'check',
		'value' => array(
			'£0 - £9999' 		=> '0-9999',	
			'£10,000 - £14,999' => '10000-14999',	
			'£15,000 - £19,999' => '15000-19999',	
			'£20,000 - £29,999' => '20000-29999',	
			'£30,000 - £39,999' => '30000-39999',	
			'£40,000 - £49,999' => '40000-49999',	
			'£50,000 - £69,999' => '50000-69999',	
			'£70,000 - £99,999' => '70000-99999',	
			'£100,000+' 		=> '100000',	
		),
		'group' => 'package',
		//'required' => 'publish'
	),

	array(
		'name' => 'salary_currency',
		'label' => 'Salary currency',
		'placeholder' => '',
		'fieldtype' => 'dropdown',
		'value' => array(
			'British pounds'	=> 'GBP',	
			'Euro' 				=> 'EUR',	
			'US Dollars' 		=> 'USD'	
		),
		'group' => 'package'
	),
	
	array(
		'name' => 'salary_details',
		'label' => 'Salary details',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'package'
	),

	array(
		'name' => 'benefits',
		'label' => 'Benefits',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'package'
	),
	
	array(
		'name' => 'hours',
		'label' => 'Hours',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'package'
	),
	
	array(
		'name' => 'contract',
		'label' => 'Contract',
		'placeholder' => '',
		'fieldtype' => 'check',
		'value' => array(
			'Part time' 		=> 'parttime',	
			'Full time'			=> 'fulltime',	
			'Contract' 			=> 'contract',	
			'Job share' 		=> 'jobshare'
		),
		'group' => 'package'
	),
	
	array(
		'name' => 'industry',
		'label' => 'Industry',
		'placeholder' => '',
		'fieldtype' => 'check',
		'value' => $sectors,
		'group' => 'industry_location',
		'keyword' => 'true'
	),

	array(
		'name' => 'region',
		'label' => 'Region',
		'placeholder' => '',
		'fieldtype' => 'check',
		'value' => array(
			'South East'		=> 'southeast',	
			'South West'		=> 'southwest',	
			'West Midlands'		=> 'westmidlands',	
			'East Midlands'		=> 'eastmidlands',	
			'East Anglia'		=> 'eastanglia',	
			'North West'		=> 'northwest',	
			'North East'		=> 'northeast',	
			'Scotland'			=> 'scotland',	
			'Ireland'			=> 'ireland',	
			'Wales'				=> 'wales',	
			'Europe'			=> 'europe',	
			'Asia'				=> 'asia',	
			'Americas'			=> 'americas',	
			'International'		=> 'international',	
		),
		'group' => 'industry_location'
	),

	array(
		'name' => 'location',
		'label' => 'Location',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'industry_location'
	),

	array(
		'name' => 'summary',
		'label' => 'Advert summary',
		'placeholder' => '',
		'fieldtype' => 'textarea',
		'group' => 'details'
	),

	array(
		'name' => 'full_description',
		'label' => 'Advert full description',
		'placeholder' => '',
		'fieldtype' => 'richtext',
		'group' => 'details'
	),

	array(
		'name' => 'spec_upload',
		'label' => 'Job specification upload',
		'placeholder' => '',
		'fieldtype' => 'file',
		'group' => 'details',
		'extra_class' => 'widelabel'
	),

	array(
		'name' => 'link_text',
		'label' => 'Job specification link text',
		'fieldtype' => 'text',
		'value' => 'Download full job specification',
		'group' => 'details',
		'extra_class' => 'widelabel'
	),

	array(
		'name' => 'extra_info',
		'label' => 'Extra information',
		'instructions' => 'If you\'d like candidates to provide extra information, please detail below what you\'d like them to provide',
		'placeholder' => '',
		'fieldtype' => 'textarea',
		'group' => 'extra'
	),

	array(
		'name' => 'application_method',
		'label' => 'Application method',
		'placeholder' => '',
		'fieldtype' => 'dropdown',
		'value' => array(
			'Send an email'		=> 'email',	
			'Link to website'	=> 'website',	
			'Application form'	=> 'form'
		),
		'group' => 'extra'
	),

	array(
		'name' => 'application_email',
		'label' => 'Send applications to',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'extra'
	),
	array(
		'name' => 'publish_from',
		'label' => 'Publish from',
		'fieldtype' => 'date',
		'datedisplay' => 'relative',
		'group' => 'extra'	
	),
	array(
		'name' => 'closing_date',
		'label' => 'Closing date',
		'fieldtype' => 'date',
		'datedisplay' => 'jS M Y',
		'group' => 'extra'	
	),
	array(
		'name' => 'promote',
		'label' => 'Promote for',
		'fieldtype' => 'dropdown',
		'addblank' => true,
		'value' => $sectors,
		'group' => 'admin'
	),
	array(
		'name' => 'job_status',
		'label' => 'Status',
		'placeholder' => '',
		'fieldtype' => 'dropdown',
		'value' => array(
			'Active'	=> 'active',	
			'Archived' 	=> 'archived'	
		),
		'group' => 'admin'
	),
	array(
		'name' => 'group_id',
		'fieldtype' => 'hidden',
		'group' => 'admin'
	),
	array(
		'name' => 'search_count',
		'label' => 'Search count',
		'fieldtype' => 'hidden',
		'group' => 'admin'
	)


);