<?php if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif; ?>

<!-- add map, etc -->
<div id="map-it" class="et_pb_section et_pb_section_200 et_pb_with_background et_section_regular">
	<div class="et_pb_row">
		<div class="et_pb_text et_pb_module et_pb_bg_layout_dark">
			<p><strong>Riehm Produce Farm, LLC</strong><br>7244 N. State Route 53<br>Tiffin, OH 44883<br>419.992.4392
			<br><a href="mailto:riehmfarms@gmail.com" target="_blank">riehmfarms@gmail.com</a></p><br>
			<div class="et_pb_button_module_wrapper et_pb_module">
				<a class="et_pb_button  et_pb_button_1 et_pb_module et_pb_bg_layout_dark" href="https://www.google.com/maps/place/Riehm+Produce+Farm,+LLC/@41.2334108,-83.163455,13.98z/data=!4m5!3m4!1s0x883bdca8863c7db3:0x58bf229373523f74!8m2!3d41.2296218!4d-83.1687623" target="_blank">Find Us</a>
			</div>
		</div>
	</div>
</div>

<?php if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer">
				<div id="footer-bottom">
					<div class="container clearfix">
						<?php if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
							get_template_part( 'includes/social_icons', 'footer' );
						}
						echo et_get_footer_credits(); ?>
					</div>	<!-- .container -->
				</div>
				
				<?php get_sidebar( 'footer' ); ?>


		<?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

				<div id="et-footer-nav">
					<div class="container">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>
					</div>
				</div> <!-- #et-footer-nav -->

			<?php endif; ?>

			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
	<script type="text/javascript">
		jQuery('#top-menu .et-social-icon a').addClass('icon');
		
		jQuery('.csa-plan-description .et-learn-more').click(function() {
			jQuery(this).find('.heading-more').toggleClass('open');
			jQuery(this).find('.learn-more-content').toggleClass('reveal-hide');
		});

/*
		jQuery('.et-learn-more').click(function() {
			var parentRow = jQuery(this).closest('.et_pb_row');
			if(parentRow.hasClass('et_pb_equal_columns') || parentRow.find('.et_pb_column').hasClass('make-equal-again')) {
				parentRow.toggleClass('et_pb_equal_columns display-box');
				jQuery(this).closest('.et_pb_column').toggleClass('make-equal-again');
			}
		});
*/


		
		function sectionLineUp() {
			if(jQuery(window).width() > 980) {
/*
				var introHeight = 
					jQuery('.et_pb_equal_columns .et_pb_column .intro').map(function(){
						return jQuery(this).height()+20;
					}).get();
				var maxHeight = Math.max.apply(null, introHeight);
				
				jQuery('.et_pb_equal_columns .et_pb_column .intro').height(maxHeight);
*/
/*
				var introHeight = 
					jQuery('.et_pb_equal_columns').each(function(){
						console.log(jQuery(this).find('.et_pb_column .intro').height()+20);
						return jQuery(this).find('.et_pb_column .intro').height()+20;
					}).get();
				
				var maxHeight = Math.max.apply(null, introHeight);
				
				jQuery('.et_pb_equal_columns .et_pb_column .intro').height(maxHeight);
*/
				jQuery('.et_pb_equal_columns').each(function(){
						console.log(jQuery(this).find('.et_pb_column .intro').height()+20);
						var setheight = jQuery(this).find('.et_pb_column .intro').height()+30;
						jQuery(this).find('.et_pb_column .intro').height(setheight);
				});
				
				
				
				var descHeight = 
					jQuery('.et_pb_equal_columns .et_pb_column .plan-description-list').map(function(){
						//return jQuery(this).height()+20;
						return jQuery(this).height()-20;
					}).get();
				var maxDescHeight = Math.max.apply(null, descHeight);
				
				jQuery('.et_pb_equal_columns .et_pb_column .plan-description-list').height(maxDescHeight);
			} else {
				jQuery('.et_pb_equal_columns .et_pb_column .intro').css('height', 'auto');
			}
		}

		sectionLineUp();
		jQuery(window).resize(function() {
			sectionLineUp();
		});

/*
		var $icon = jQuery('.et-pb-icon[style*="color"]');
		if($icon.length) {
			alert('add fill');
			jQuery(this).find('svg').style('fill');
		}
*/
		

	</script>
</body>
</html>