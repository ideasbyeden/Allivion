<?php

global $user, $usermeta;

if(!isset($_REQUEST['i'])) $_REQUEST['i'] = $user->ID;
$dircore->canAccess(array('id' => $_REQUEST['i'].','.get_user_meta($_REQUEST['i'],'group_id',true)));


/*
Template Name: Update user
*/

session_start();
	
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

$this_user = get_user_by('id',$_REQUEST['i']);
$usercustom = get_user_meta($_REQUEST['i']);
foreach($usercustom as $k=>$v){
	$this_usermeta[$k] = $v[0];
}
//echo '<pre>'; print_r($user); echo '</pre>';
//echo '<pre>'; print_r($usermeta); echo '</pre>';


?>

<div class="section">
	<div class="stage">
		
		<h1 class="purple">Update user</h1>
		
			<div class="halfcol">

				<form class="directory" id="createuser" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
				
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_update_user_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_update_user" />
 					<input type="hidden" name="redirect" value="/users" />
 					<input type="hidden" name="ID" value="<?php echo $this_user->ID; ?>" />
 					<input type="hidden" name="role" value="<?php echo $this_user->roles[0]; ?>" />
 					<input type="hidden" name="origin" value="updateuser" />

					<div class="qpanel">
						<div class="question">
							<label>First Name</label>
							<input type="text" name="first_name" value="<?php echo $_SESSION ? $_SESSION['userdata']['first_name'] : $this_user->first_name; ?>"/>
						</div>
						<div class="question">
							<label>Last Name</label>
							<input type="text" name="last_name" value="<?php echo $_SESSION ? $_SESSION['userdata']['last_name'] :  $this_user->last_name; ?>" />
						</div>
						<div class="question">
							<label>Email</label>
							<input type="text" name="user_email" value="<?php echo $_SESSION ? $_SESSION['userdata']['user_email'] :  $this_user->user_email; ?>" />
						</div>
						<div class="question">
							<label>Password</label>
							<input type="password" name="user_pass" value="" />
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