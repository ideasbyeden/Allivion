<?php

/*
Template Name: User list
*/

//$job->canEdit($_REQUEST['i']);
$vals = $_REQUEST['i'] ? $job->getVals($_REQUEST['i']) : null;

	
get_header();
	
while (have_posts()) { 
		the_post();
		the_content();
} 


?>

<div class="section">
	<div class="stage">
		
		<h1 class="purple">Manage users</h1>
		
			<table class="searchresults">
				<thead>
					<tr>
						<td>Name</td>
					</tr>
				</thead>
				<tbody>

					<?php $user_query = getGroupUsers(); 
						
						
						if (!empty($user_query->results)) {
							foreach($user_query->results as $user) { ?>
								<tr class="clickable" data-href="<?php echo DIRECTORY_UDPATEUSERPATH; ?>?i=<?php echo $user->ID; ?>">
									<td><?php echo $user->display_name; ?></td>
								</tr>
							<?php }
						} else {
							echo 'No users found.';
						}
					?>
						

				</tbody>
			</table>

<pre><?php print_r($user_query); ?></pre>
					
		<div class="clear"></div>
		
	</div>
</div>

<?php get_footer(); ?>