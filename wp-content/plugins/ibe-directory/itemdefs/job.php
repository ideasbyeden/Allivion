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
// Item type is hierarchical
//
///////////////////////////////////////////

$hierarchical = false;


///////////////////////////////////////////
//
// Define value arrays for multiple use
//
///////////////////////////////////////////

/*
$sector_vals = array(
			'Agrictulture, Food & Veterinary' 		=> 'agri/food/vet',	
			'Architecture, Building & Planning' 	=> 'architecture/building',	
			'Biological Sciences' 					=> 'biological_science',
			'IT'									=> 'it'
			);
*/


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

//$sector_vals = &$sector->getTerms();


$vars = array(
	
	array(
		'name' => 'ad_type',
		'label' => 'Ad type',
		'placeholder' => '',
		'fieldtype' => 'dropdown',
		'value' => array(
			'Standard' 	=> array('slug' => 'standard'),	
			'Premium'	=> array('slug' => 'premium'),	
			'Sponsored' => array('slug' => 'sponsored'),		
		),
		'group' => 'publishing',
	),
	array(
		'name' => 'job_status',
		'label' => 'Status',
		
		'placeholder' => '',
		'fieldtype' => 'dropdown',
		'value' => array(
			'Draft'		=> array('slug' => 'draft'),	
			'Published'	=> array('slug' => 'published'),	
			'Archived' 	=> array('slug' => 'archived')
		),
		'group' => 'publishing'
	),
	array(
		'name' => 'publish_from',
		'label' => 'Publish from',
		'fieldtype' => 'date',
		'datedisplay' => 'j M Y',
		'group' => 'publishing'	
	),
	array(
		'name' => 'closing_date',
		'label' => 'Closing date',
		'fieldtype' => 'date',
		'datedisplay' => 'j M Y',
		'group' => 'publishing'	
	),
	
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
		'name' => 'role_func',
		'label' => 'Role function',
		'fieldtype' => 'dropdown',
		'value' => array(
			'Academic, Research, Teaching'		=> array('slug' => 'acadamic'),	
			'PhD'								=> array('slug' => 'phd'),	
			'Professional & Managerial' 		=> array('slug' => 'professional')
			'Clerical & Administrative' 		=> array('slug' => 'clerical')
			'Technical'					 		=> array('slug' => 'technical')
			'Craft & Manual' 					=> array('slug' => 'craftmanual')
			'Masters'					 		=> array('slug' => 'masters')
		),
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
		'name' => 'department',
		'label' => 'Department/Faculty',
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
			'£0 - £9999' 		=> array('slug' => '0-9999'),	
			'£10,000 - £14,999' => array('slug' => '10000-14999'),	
			'£15,000 - £19,999' => array('slug' => '15000-19999'),	
			'£20,000 - £29,999' => array('slug' => '20000-29999'),	
			'£30,000 - £39,999' => array('slug' => '30000-39999'),	
			'£40,000 - £49,999' => array('slug' => '40000-49999'),	
			'£50,000 - £69,999' => array('slug' => '50000-69999'),	
			'£70,000 - £99,999' => array('slug' => '70000-99999'),	
			'£100,000+' 		=> array('slug' => '100000'),	
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
			'British pounds'	=> array('slug' => 'GBP'),	
			'Euro' 				=> array('slug' => 'EUR'),	
			'US Dollars' 		=> array('slug' => 'USD')	
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
		'name' => 'hours',
		'label' => 'Hours',
		'fieldtype' => 'dropdown',
		'value' => array(
			'Full time'			=> array('slug' => 'fulltime'),	
			'Part time' 		=> array('slug' => 'parttime'),	
			'Variable hours' 	=> array('slug' => 'variablehours')	
		),
		'group' => 'package'
	),
	
	array(
		'name' => 'contract',
		'label' => 'Contract',
		'placeholder' => '',
		'fieldtype' => 'check',
		'value' => array(
			'Permanent' 		=> array('slug' => 'permanent'),	
			'Fixed Term'		=> array('slug' => 'fixedterm'),	
			'Job share' 		=> array('slug' => 'jobshare')
		),
		'group' => 'package'
	),
	
	array(
		'name' => 'industry',
		'label' => 'Industry',
		'placeholder' => '',
		'fieldtype' => 'check',
		'value' => $sector->taxTree(),
		'taxonomy' => 'sector',
		'group' => 'industry_location',
		'keyword' => 'true',
		'select_parent' => 'false'
	),

	array(
		'name' => 'region',
		'label' => 'Region',
		'placeholder' => '',
		'fieldtype' => 'check',
		'value' => array(
			'London'				=> array('slug' => 'london'),	
			'Midlands of England'	=> array('slug' => 'midlandsengland'),	
			'Northern England'		=> array('slug' => 'northengland'),	
			'Northern Ireland'		=> array('slug' => 'northernireland'),	
			'Republic of Ireland'	=> array('slug' => 'republicireland'),	
			'Scotland'				=> array('slug' => 'scotland'),	
			'South East England'	=> array('slug' => 'southeastengland'),	
			'South West England'	=> array('slug' => 'southwestengland'),	
			'Wales'					=> array('slug' => 'wales'),	
			'North, South & Central America' => array('slug' => 'americas'),	
			'Europe'				=> array('slug' => 'europe'),	
			'Asia & Middle East'	=> array('slug' => 'asia'),	
			'Australasia'			=> array('slug' => 'australasia'),	
			'Africa'				=> array('slug' => 'africa'),	
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
		'name' => 'full_description_limited',
		'label' => 'Advert summary',
		'placeholder' => '',
		'fieldtype' => 'richtext',
		'group' => 'details',
		'limit' => '600'
	),
	
	array(
		'name' => 'full_description',
		'label' => 'Advert summary',
		'placeholder' => '',
		'fieldtype' => 'richtext',
		'group' => 'details',
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
			'Send an email'		=> array('slug' =>'email'),	
			'Link to website'	=> array('slug' =>'website'),	
			'Application form'	=> array('slug' =>'form')
		),
		'group' => 'extra'
	),

	array(
		'name' => 'application_website',
		'label' => 'Application website',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'extra'
	),


	array(
		'name' => 'application_email',
		'label' => 'Email applications to',
		'placeholder' => '',
		'fieldtype' => 'text',
		'group' => 'extra'
	),

	array(
		'name' => 'promote',
		'label' => 'Promote for',
		'fieldtype' => 'dropdown',
		'addblank' => true,
		'value' => $sector->taxTree(),
		'group' => 'admin'
	),
	array(
		'name' => 'promote_from',
		'label' => 'Promote from',
		'fieldtype' => 'date',
		'datedisplay' => 'j M Y',
		'group' => 'admin'	
	),
	array(
		'name' => 'promote_to',
		'label' => 'Promote to',
		'fieldtype' => 'date',
		'datedisplay' => 'j M Y',
		'group' => 'admin'	
	),
	array(
		'name' => 'promote_enabled',
		'label' => 'Promotion enabled',
		'fieldtype' => 'check',
		'value' => array(
			'Enabled' 		=> array('slug' => 'enabled') // labelled as tick
		),
		'group' => 'sysadmin'
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