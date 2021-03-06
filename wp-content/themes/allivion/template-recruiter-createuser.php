<?php
	
$dircore->canAccess(array('roles' => 'recruiter_admin'));
	
session_start();


/*
Template Name: Create user
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



/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////



?>

<div class="container a2apad">
	<div class="row">
		<div class="col-md-12">
			<h1 class="purple">Create user</h1>
		</div>
		<div class="col-md-6">

			<form class="directory" id="createuser" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">


					<input type="hidden" name="group_id" value="<?php echo $user->ID ?>" />
					<input type="hidden" name="role" value="recruiter" />
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_create_user_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_create_user" />
  					<input type="hidden" name="redirect" value="/users/" />
  					<input type="hidden" name="submitfail" value="/createuser" />

					<input type="hidden" name="readterms" value="true" />
			


				<div class="qpanel">
					<div class="question">
						<label>First Name</label>
						<input type="text" name="first_name" value="<?php echo $_SESSION['userdata']['first_name']; ?>"/>
					</div>
					<div class="question">
						<label>Last Name</label>
						<input type="text" name="last_name" value="<?php echo $_SESSION['userdata']['last_name']; ?>" />
					</div>
					<div class="question">
						<label>Email</label>
						<input type="text" name="user_email" value="<?php echo $_SESSION['userdata']['user_email']; ?>" />
					</div>
					<div class="question">
						<label>Confirm email</label>
						<input type="email" name="confirm_user_email" value="<?php echo $_SESSION['userdata']['confirm_user_email']; ?>" />
					</div>
					<div class="question">
						<label>Password</label>
						<input type="password" name="user_pass" value="<?php echo $_SESSION['userdata']['user_pass']; ?>" />
					</div>
					<div class="question">
						<label>Confirm password</label>
						<input type="password" name="confirm_user_pass" />
					</div>
					<?php
						if($_SESSION){ 
							foreach($_SESSION['errors'] as $error) { echo '<p class="formerror">'.$error.'</p>'; }
							session_unset();
						}
					?>
					<input type="submit" value="Save" class="btn btn-default fr"/>
					<div class="clear"></div>
				</div>
				
			</form>
			
		</div>
			
						
			<div class="clear"></div>
			
			
<!-- 			<pre>Search results: <?php print_r($items); ?></pre> -->
				

		
		
	</div>
</div>

<?php get_footer(); ?>