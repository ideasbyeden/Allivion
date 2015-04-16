<?php
	
	require('../wp-content/plugins/ibe-directory/directory_itemclass.php');
	require('../wp-content/plugins/ibe-directory/directory_coreclass.php');
	require('../wp-content/plugins/ibe-directory/itemdefs/job.php');
	
	class jobTest extends PHPUnit_Framework_TestCase {
		
		public function createObj(){

			$job = new itemdef;
			
		}
		
		
	}