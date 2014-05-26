			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap cf">
				    

					<nav id="footer-nav" role="navigation">
						<?php wp_nav_menu(array(
    					'container' => '',                              // remove nav container
    					'container_class' => 'footer-links cf',         // class of container (should you choose to use it)
    					'menu' => __( 'Footer Links', 'bonestheme' ),   // nav name
    					'menu_class' => 'nav footer-nav cf',            // adding custom nav class
    					'theme_location' => 'footer-links',             // where it's located in the theme
    					'before' => '',                                 // before the menu
        			'after' => '',                                  // after the menu
        			'link_before' => '',                            // before each link
        			'link_after' => '',                             // after each link
        			'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
						)); ?>
					</nav>

    				<div id="footer-contact">
    					<h3>Contact</h3>
    					<p><img src="<?php echo get_template_directory_uri(); ?>/library/images/phone.png" alt="Call Us" /> 517.669.HOME (4663)</p>
    					<p><img src="<?php echo get_template_directory_uri(); ?>/library/images/email.png" alt="Email Us" /> pvbuilder@aol.com</p>
    					<p class="source-org copyright">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?> LLC. All Rights Reserved.</p>
    				</div>
			</div>
            <p class="pixelplay clear">Website brought to you by: <a href="http://www.pixelplaycreative.com">Pixel Play Creative</a></p>
		</footer>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

	</body>

</html> <!-- end of site. what a ride! -->
