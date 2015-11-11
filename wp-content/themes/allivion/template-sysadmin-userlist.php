<?php
	
$dircore->canAccess(array('roles' => 'administrator'));


/*
Template Name: Sysadmin user list
*/

//$job->canEdit($_REQUEST['i']);
$vals = $_REQUEST['i'] ? $job->getVals($_REQUEST['i']) : null;

	
get_template_part('header','sysadmin');
	
while (have_posts()) { 
		the_post();
		the_content();
 


?>

<div class="section">
	<div class="stage">
				
		<h1 class="purple"><?php the_title(); ?><a href="create"><input type="button" value="New" class="arrow_right" /></a></h1>
		
			<table class="searchresults">
				<thead>
					<tr>
						<td>Name</td>
						<td>Role</td>
					</tr>
				</thead>
				<tbody>

					<?php $user_query = $recruiter_admin->getUsers(); 
						
						
						if (!empty($user_query->results)) {
							foreach($user_query->results as $user) { echo '<pre>'; print_r($user); echo '</pre>';?>
							
								<tr class="clickable" data-href="/users/update?i=<?php echo $user->ID; ?>">
									<td><?php echo $user->display_name; ?></td>
									<td><?php echo $user->meta['recruiter_name']; ?></td>
								</tr>
							<?php }
						} else {
							echo 'No users found.';
						}
					?>
						

				</tbody>
			</table>

					
		<div class="clear"></div>
		
		<pre><?php //print_r($user_query); ?></pre>
		
	</div>
</div>

<?php } get_footer(); ?>