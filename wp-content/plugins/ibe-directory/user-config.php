<?php
	
$caps = array(	'delete_posts' => true,
				'delete_published_posts' => true,
				'edit_posts' => true,
				'edit_published_posts' => true,
				'publish_posts' => true,
				'read' => true,
				'upload_files' => true
				);
				
add_role( 'advertiser', 'Advertiser', $caps );

$caps = array(	'delete_posts' => true,
				'delete_published_posts' => true,
				'edit_posts' => true,
				'edit_published_posts' => true,
				'publish_posts' => true,
				'read' => true,
				'upload_files' => true
				);
				
add_role( 'advertiser_admin', 'Advertiser Admin', $caps );

$caps = array(	'delete_posts' => false,
				'delete_published_posts' => false,
				'edit_posts' => false,
				'edit_published_posts' => false,
				'publish_posts' => false,
				'read' => true,
				'upload_files' => true
				);
				
add_role( 'candidate', 'Candidate', $caps );