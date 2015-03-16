<?php
	
session_start();
define('DIRECTORY_UDPATEUSERPATH', $_SERVER['REQUEST_URI']);


/*
Template Name: Update user
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

$user = get_user_by('id',$_REQUEST['i']);
$usercustom = get_user_meta($_REQUEST['i']);
foreach($usercustom as $k=>$v){
	$usermeta[$k] = $v[0];
}
echo '<pre>'; print_r($usermeta); echo '</pre>';

?>

<div class="section">
	<div class="stage">
		
		<h1 class="purple">Update user</h1>
		
			<div class="halfcol">

				<form class="directory" id="createuser" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
				
					<input type="hidden" name="group_id" value="<?php echo $usermeta['group_id']; ?>" />
 					<input type="hidden" name="role" value="editor" />
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_update_user_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_update_user" />
 					<input type="hidden" name="redirect" value="/user-list" />

					<div class="qpanel">
						<div class="question">
							<label>First Name</label>
							<input type="text" name="first_name" value="<?php echo $user->first_name; ?>"/>
						</div>
						<div class="question">
							<label>Last Name</label>
							<input type="text" name="last_name" value="<?php echo $user->last_name; ?>" />
						</div>
						<div class="question">
							<label>Email</label>
							<input type="text" name="user_email" value="<?php echo $user->user_email; ?>" />
						</div>
						<div class="question">
							<label>Password</label>
							<input type="password" name="user_pass" value="" />
						</div>
						<div class="question">
							<label>Confirm password</label>
							<input type="password" name="confirm_user_pass" />
						</div>
						<?php foreach($_SESSION['errors'] as $error) { echo '<p class="formerror">'.$error.'</p>'; } ?>
						<input type="submit" value="Save" class="fr"/>
						<div class="clear"></div>
					</div>
					
				</form>
				
			</div>
			
						
			<div class="clear"></div>
			
			
<!-- 			<pre>Search results: <?php print_r($items); ?></pre> -->
				

		
		
	</div>
</div>

<?php get_footer(); ?>