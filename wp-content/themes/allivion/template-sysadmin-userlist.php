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

<div class="container a2apad">
	<div class="row">
				
		<div class="col-md-8">
			<h1 class="purple"><?php the_title(); ?></h1>
		</div>
		<div class="col-md-4" style="text-align: right">
			<a href="sysadmin-create-use">
				<button type="button" class="btn btn-default" style="margin-top: 20px;">New</button>
			</a>
		</div>
		
		<div class="col-md-12" style="padding-top: 20px; padding-bottom: 20px;">
			<table class="searchresults" id="sysadmin-users"> 
				<thead>
					<tr>
						<td>Name</td>
						<td>Organisation</td>
						<td>Registered</td>
					</tr>
				</thead>
				<tbody>

					<?php $params = array('orderby' => 'user_registered','order' => 'DESC'); $user_query = $recruiter_admin->getUsers($params); 
						
						
						if (!empty($user_query->results)) {
							foreach($user_query->results as $user) { 

								//echo '<pre>'; print_r($user); echo '</pre>';
								
								?>
							
								<tr class="clickable" data-href="/sysadmin-userprofile?i=<?php echo $user->ID; ?>">
									<td><?php echo $user->display_name; ?></td>
									<td><?php echo $user->meta['recruiter_name']; ?></td>
									<td><?php echo date('jS M Y',strtotime($user->user_registered)); ?></td>
								</tr>
							<?php }
						} else {
							echo 'No users found.';
						}
					?>
						

				</tbody>
			</table>
		</div>

					
		<div class="clear"></div>
		
		
	</div>
</div>

<?php } get_footer(); ?>