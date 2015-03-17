<?php

/*
Template Name: Recruiter dashboard
*/

//header('Location: '.admin_url('admin-ajax.php'));

	
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
		
		<h1 class="purple">Job advertisements</h1>
		
			<div class="halfcol">

				<form class="directory <?php echo $job->type; ?>" id="createjob" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
				
					<input type="hidden" name="post_id" value="<?php echo $_REQUEST['i']; ?>" />
					<input type="hidden" name="varnames" value="<?php echo implode(',', $job->getVarNames()); ?>" />
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_create_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_create" />
 					<input type="hidden" name="redirect" value="/job-details-form" />
 					<input type="hidden" name="type" value="job" />
 					<input type="hidden" name="status" value="active" />

					<div class="qpanel purplegrad">
						<h2>Create a new ad</h2>
						<?php $job->printQuestion('job_title',$vals); ?>
						<?php $job->printQuestion('job_ref',$vals); ?>
						<input type="submit" value="Save and add details" class="fr"/>
						<div class="clear"></div>
					</div>
					
				</form>
				
			</div>
			
			<div class="halfcol">
				

				<form class="directory <?php echo $job->type; ?> search" id="searchjobs" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="jobslist">
				
					<input type="hidden" name="type" value="job" />
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
					<input type="hidden" name="action" value="directory_search" />
				

					<div class="qpanel">
						<h2>Search jobs</h2>
						<label>Keywords</label><input type="text" name="keywords" value="" />
						<div class="clear"></div>
						<div class="halfcol">
						<?php $job->printQuestion('job_status'); ?>
						</div>
						<?php //$user->printQuestion('name'); ?>
						<input type="submit" value="Search" class="fr"/>
						<div class="clear"></div>
					</div>
					
				</form>
				
			</div>
			
			<div class="clear"></div>
			
			<?php 
				$params = $_GET ? $_GET : array();
				$params['type'] = 'job';
				$items = directory_search($params);
			?>

			
			<table id="jobslist" class="searchresults">
				<thead>
					<tr>
						<?php foreach($returnfields as $field){ ?>
						<td><?php $q = $job->getQuestion($field); echo $q['label']; ?></td>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
							
				<?php foreach ($items->posts as $item){ ?>
					<tr class="clickable" data-href="/job-details-form?i=<?php echo $item->ID; ?>">
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