<?php

/*
Template Name: Sysadmin Candidate Search
*/

$dircore->canAccess(array('roles' => 'administrator'));
	
get_template_part('header','sysadmin');
	
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
$returnfields = array('first_name','last_name','personal_summary');




/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////



?>

<div class="container a2apad">
	<div class="row">
		
		<div class="container">
			<div class="row">

				<div class="col-md-6">
					<h2>Candidate Search</h2>
					<p>Search for candidates using keywords or phrases to find the best matches for your requirements</p>
					<div class="alert alert-warning">
						<strong>Need help?</strong>
						To ask a question, simply get in touch with our support team on 0208 310 3131 or email us at
						<a href="mailto:info@allivion.com">info@allivion.com</a> 
					</div> 
				</div>
				
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="qpanel">
						<h3>Search for the perfect candidate</h3>
						<form class="directory <?php echo $candidate->type; ?> searchuser" id="searchcandidates" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="userslist" clickableurl="/candidate-details">
	
							<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
							<input type="hidden" name="action" value="directory_search_user" />
						
							<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('role=candidate'); ?>" />
					
							<label>Keywords&nbsp;</label><input type="text" name="keywords" value="" />
							<input type="submit" value="Search" class="fr btn btn-default"/>

							<?php $candidate->printQuestion('industry',null,'dropdown',true); ?>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
			
	<div class="clear"></div>

	<div class="row">
		<div class="container">
			
			<?php 
				$params = $_GET ? $_GET : array();
				$params['encrypted'] = $dircore->encrypt('role=candidate&profile_status=active');
				$users = directory_search_user($params);
			?>



				<table class="searchresults">
					<thead>
						<tr>
							<!-- <?php foreach($returnfields as $field){ ?>
							<td><?php $q = $candidate->getQuestion($field); echo $q['label']; ?></td>
							<?php } ?> -->
						</tr>
					</thead>
					<tbody id="userslist">
							
						<tr class="prototype" data-href="/candidate-details?i=">
							<td>[first_name] <span class="firstinitial">[last_name]</span></td>
							<td>[personal_summary]</td>
						</tr>

					</tbody>
				</table>
							
		</div>
	</div>
</div>

<script>
jQuery(f)
</script>


<?php get_footer(); ?>