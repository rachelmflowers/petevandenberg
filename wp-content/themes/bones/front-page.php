<?php
/*
 Template Name: Front Page
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
				        
				    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				    <?php echo do_shortcode( '[a3_responsive_slider id="42" inline_post="true" description="" align="center" width="100" width_type="%" tall_type="fixed" height="300" margin_top="0" margin_bottom="15" margin_left="50" margin_right="50" desc_margin_top="10" desc_margin_bottom="10" desc_margin_left="10" desc_margin_right="10"]' ) ?>

					<div id="main" class="cf" role="main">
  
						<section class="entry-content cf">
							<?php
								// the content (pretty self explanatory huh)
								the_content();

								/*
								 * Link Pages is used in case you have posts that are set to break into
								 * multiple pages. You can remove this if you don't plan on doing that.
								 *
								 * Also, breaking content up into multiple pages is a horrible experience,
								 * so don't do it. While there are SOME edge cases where this is useful, it's
								 * mostly used for people to get more ad views. It's up to you but if you want
								 * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
								 *
								 * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
								 *
								*/
								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								) );
							?>
						</section>
						
						<?php endwhile; else : ?>

						<article id="post-not-found" class="hentry cf">
								<header class="article-header">
									<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
							</header>
								<section class="entry-content">
									<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
							</section>
							<footer class="article-footer">
									<p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
							</footer>
						</article>

					</div>

                    <?php endif; ?>

				</div>

			</div>


<?php get_footer(); ?>