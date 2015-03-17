<?php

/*
Template Name: User list
*/

//$job->canEdit($_REQUEST['i']);
$vals = $_REQUEST['i'] ? $job->getVals($_REQUEST['i']) : null;

	
get_template_part('header','recadmin');
	
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
								<tr class="clickable" data-href="/update-user?i=<?php echo $user->ID; ?>">
									<td><?php echo $user->display_name; ?></td>
								</tr>
							<?php }
						} else {
							echo 'No users found.';
						}
					?>
						

				</tbody>
			</table>

					
		<div class="clear"></div>
		
	</div>
</div>

<?php get_footer(); ?>