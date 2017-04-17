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
		jQuery.support.placeholder = (function() {
			var i = document.createElement('input');
			return 'placeholder' in i;
		})();
		
		if(jQuery.support.placeholder) {
			jQuery('form div.input-hold').each(function() {
				jQuery(this).addClass('js-hide-label');
			});
			
		}
	
	jQuery('form .input-hold').find('input, textarea').on('keyup blur focus', function(e) {
		// cache our selectors
		var $this = jQuery(this),
			$parent = $this.parent();
			
		if(e.type == 'keyup') {
			if($this.val() == '') {
				$parent.addClass('js-hide-label');
			} else {
				$parent.removeClass('js-hide-label');
			}
		} else if(e.type == 'blur') {
			if($this.val() == '') {
				$parent.addClass('js-hide-label');
			} else {
				$parent.removeClass('js-hide-label').addClass('js-unhighlight-label');
			}
		} else if(e.type == 'focus') {
			if($this0.val() !== '') {
				$parent.removeClass('js-unhighlight-label');
			}	
		}
	});

		jQuery('#top-menu .et-social-icon a').addClass('icon');
		
		jQuery('.csa-plan-description .et-learn-more').click(function() {
			jQuery(this).find('.heading-more').toggleClass('open');
			jQuery(this).find('.learn-more-content').toggleClass('reveal-hide');
			
			if(jQuery(this).find('.heading-more.open').length) {
				$hash = jQuery(this).closest('.csa-plan-description').attr('id');
				console.log('window hash '+$hash);
				window.location.hash = 'details-'+$hash;
			} 
		});

		
		function sectionLineUp() {
			if(jQuery(window).width() > 980) {

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


		if(window.location.hash) {
			hash = window.location.hash.substr(1);
			console.log(hash);
			
			//jumpto = hash.replace('details-','');
			
			//jQuery('#'+jumpto).find('.learn-more-content').trigger('click');
			jQuery('#'+hash).find('.learn-more-content').trigger('click');
			
			jQuery('html, body').animate({
			  	scrollTop: jQuery('#'+hash).offset().top+(-210)
			}, {
				queue:false,
				duration:100
			});
			
					
		
		}

	</script>
</body>
</html>