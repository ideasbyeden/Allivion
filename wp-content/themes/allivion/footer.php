<div class="section" id="footer">
	<div class="stage">
		
		<div class="thirdcol">
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
		
		<div class="twothirdscol">
			<h4>Latest news, posts and advice</h4>
			<?php footer_feed(); ?>
		</div>
		
		<div class="clear"></div>

		<div class="legal">
			&copy; <?php echo date('Y'); ?>. <a href="http://www.ibecreative.co.uk/expertise/cambridge-web-design" target="_blank">Website design</a> by ibe.
		</div>
		
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>