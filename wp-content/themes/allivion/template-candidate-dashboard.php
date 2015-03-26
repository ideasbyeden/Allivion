<?php

/*
Template Name: Candidate dashboard
*/

$allivion->canAccess(array('roles' => 'candidate'));
	
get_template_part('header','recadmin');
	
while (have_posts()) { 
		the_post();
		the_content();
} 


/////////////////////////////////////////////
//
// Page config
//
/////////////////////////////////////////////

// Fields to be shown in search results

$returnfields = array('job_title','job_ref','location');


/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////



?>

<div class="section">
	<div class="stage">
		
		<h1 class="purple">My applications</h1>
			
			<?php 
				$params = $_GET ? $_GET : array();
				$params['type'] = 'application';
				$params['author'] = $user->ID;
				//echo pre($params); 
				$items = directory_search($params);
			?>

			
			<table id="appslist" class="searchresults">
				<thead>
					<tr>
						<?php foreach($returnfields as $field){ ?>
						<td><?php $q = $application->getQuestion($field); echo $q['label']; ?></td>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
							
				<?php foreach ($items->posts as $item){ ?>
					<tr class="clickable" data-href="/application-details?i=<?php echo $item->ID; ?>">
						<?php foreach($returnfields as $field){ ?>
						<td><?php echo $item->meta[$field]; ?></td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>			
			
<!-- 			<pre>Search results: <?php print_r($items); ?></pre> -->
				

		
		<div class="clear"></div>
		
	</div>
</div>

<?php get_footer(); ?>