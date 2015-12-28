<?php
	
$dircore->canAccess(array('roles' => 'recruiter_admin,recruiter'));


/*
Template Name: User list
*/

//$job->canEdit($_REQUEST['i']);
$vals = $_REQUEST['i'] ? $job->getVals($_REQUEST['i']) : null;

	
get_template_part('header','recadmin');
	
while (have_posts()) { 
		the_post();
		the_content();
 


?>

<div class="container a2apad">
	<div class="row">
		

		
		<div class="col-md-8">
			<h1 class="purple"><?php the_title(); ?></h1>
		</div>
		<div class="col-md-4" style="text-align: right">
			<a href="create">
				<button type="button" class="btn btn-default" style="margin-top: 20px;">New</button>
			</a>
		</div>

		<div class="col-md-12" style="padding-top: 20px; padding-bottom: 20px;">
			<table class="searchresults">
				<thead>
					<tr>
						<td>Name</td>
						<td>Role</td>
					</tr>
				</thead>
				<tbody>

					<?php $user_query = getGroupUsers(); 
						
						
						if (!empty($user_query->results)) {
							foreach($user_query->results as $user) { ?>
								<tr class="clickable" data-href="/users/update?i=<?php echo $user->ID; ?>">
									<td><?php echo $user->display_name; ?></td>
									<td><?php echo $wp_roles->roles[$user->roles[0]]['name']; ?></td>
								</tr>
							<?php }
						} else {
							echo 'No users found.';
						}
					?>
						

				</tbody>
			</table>
		</div>
					
		
	</div>
</div>

<?php } get_footer(); ?>