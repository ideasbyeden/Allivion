<form class="directory" id="login" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
				
	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_login_nonce"); ?>" />
	<input type="hidden" name="action" value="directory_login" />


	<a class="close" href=""><img src="<?php bloginfo('template_url'); ?>/img/close.png" /></a>
    <h1>Login</h1>
    <p class="status"></p>
    <div class="qpanel">
	    <div class="question">
		    <label for="username">Username</label>
		    <input id="username" type="text" name="username">
	    </div>
	    <div class="question">
		    <label for="password">Password</label>
		    <input id="password" type="password" name="password">
	    </div>
    <input class="submit_button" type="submit" value="Go" name="submit">
    <p class="lost"><a href="<?php echo wp_lostpassword_url(); ?>">Lost your password?</a></p>
    <div class="clear"></div>
    </div>
    
    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
</form>