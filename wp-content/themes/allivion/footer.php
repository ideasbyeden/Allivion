<div class="container">
	<div class="row" id="addtoany">
		<div class="col-md-12">
		<h3 class="purple">Share our content</h3>

			<?php //get_template_part('includes/addtoany'); ?>
		</div>
	</div>
</div>
<div class="container-fluid" id="footer">
	<div class="container">
		<div class="row">
			
			<div class="col-md-4">
				<h4>Connect with Allivion</h4>
					<img src="<?php bloginfo('template_url'); ?>/img/footer_socnet_fb.png" />
					<img src="<?php bloginfo('template_url'); ?>/img/footer_socnet_li.png" />
					<img src="<?php bloginfo('template_url'); ?>/img/footer_socnet_tw.png" />
					<img src="<?php bloginfo('template_url'); ?>/img/footer_socnet_yt.png" />
				
				<h4>Memberships</h4>
				<p>List trade memberships etc.</p>
				<a href="/contact" class="footer_button">Contact us</a>
				<a href="/blog" class="footer_button">Blog</a>
			</div>
			
			<div class="col-md-8">
				<h4>Latest news, posts and advice</h4>
				<?php footer_feed(); ?>
			</div>
			
			<div class="clear"></div>
	
			<div class="col-md-12 legal">
				&copy; <?php echo date('Y'); ?>. <a href="http://www.ibecreative.co.uk/expertise/cambridge-web-design" target="_blank">Website design</a> by ibe.
			</div>
		</div>
	</div>
</div>

<div class="containerfluid" id="supportedby">
	<div class="container">
		<div class="row">
			<div class="col-sm-12"><h2>Supported by</h2></div>
			<?php for($s=1; $s<=6; $s++){ ?>
			<div class="col-sm-2"><?php dynamic_sidebar('footer_col'.$s); ?></div>
			<?php } ?>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

 	<!-- can't do this - cross domain -->
 	<script>
	 	jQuery(function(){
		 	jQuery('iframe#a3f7c9f1').on('load', function(){
			 	var content = jQuery('iframe#a3f7c9f1').contents();
			 	console.log(content);
			 	//jQuery('iframe').contents().find('img').css({'width':'225px !important', 'height':'175px !important', 'opacity': '0.5'});			 	
		 	});
	 	});
 	</script>


</body>
</html>