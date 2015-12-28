<?php
	
//$dircore->canAccess(array('roles' => 'recruiter_admin'));
//
// Should this only allow access for non-logged in users?
	
session_start();


/*
Template Name: Register
*/

//header('Location: '.admin_url('admin-ajax.php'));

	
get_header();
	
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
		
		<div class="col-md-8">
			<h1 class="purple">Register</h1>
		</div>
		
			<div class="col-md-6">

				<form class="directory" id="createuser" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
				
 					<input type="hidden" name="role" value="candidate" />
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_create_user_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_create_user" />
					<input type="hidden" name="notify" value="user_email" />
					<input type="hidden" name="notify_subject" value="Allivion registration" />
					<input type="hidden" name="notify_template" value="new_registration" />
  					<input type="hidden" name="redirect" value="/register-success/" />

					<div class="qpanel">
						<div class="question">
							<label>I am a:</label><br />
							<select name="role">
								<option value="candidate" <?php echo $_SESSION['userdata']['role'] == 'candidate' ? 'SELECTED' : ''; ?>>Candidate</option>
								<option value="recruiter_admin" <?php echo $_SESSION['userdata']['role'] == 'recruiter_admin' ? 'SELECTED' : ''; ?>>Recruiter</option>
							</select>
						</div>
						<div class="question recruiter_admin" style="display:none;">
							<label>Sector:</label><br />
							<select name="recruiter_sector">
								<option value="private" <?php echo $_SESSION['userdata']['role'] == 'private' ? 'SELECTED' : ''; ?>>Private</option>
								<option value="public" <?php echo $_SESSION['userdata']['role'] == 'public' ? 'SELECTED' : ''; ?>>Public/Charity/University/HE</option>
							</select>
						</div>

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
						<input type="submit" value="Save" class="btn btn-default fr" />
						<div class="clear"></div>
					</div>
					
				</form>
				
			</div>
			
						
			<div class="clear"></div>
			
			
<!-- 			<pre>Search results: <?php print_r($items); ?></pre> -->
				

		
		
	</div>
</div>

<?php get_footer(); ?>

<script>
	jQuery(function(){
		jQuery('select[name="role"]').change(function(){
			var dd = jQuery(this);
			jQuery('.'+dd.val()).fadeIn();
			dd.find('option:not(:selected)').each(function(){
				var hideclass = jQuery(this).val();
				//hideclass = this.val();
				jQuery('.'+hideclass).fadeOut();
			});
		});
	});
	
</script>