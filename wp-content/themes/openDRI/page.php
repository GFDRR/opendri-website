<?php get_header(); ?>
<?php
if ( is_page( 'resources' ) ) {
?>
			<div id="content" class="resources-page-list">
				<span class="corner-map"></span>
				<div class="blue-bar-top resources" id="blue-bar">
					<div class="wrap wrapper">
						<span><a href="#publications">guides</a></span>
						<span><a href="#tools">tools and training materials</a></span>
						<span><a href="#notes">short notes</a></span>
						<span><a href="#newsletters">newsletters</a></span>
						<span><a href="#other">other resources</a></span>
						&nbsp;
					</div>
				</div>
				<div id="inner-content" class="wrap cf">

						<div id="main" class="m-all cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
							<?php if (have_posts()) : while (have_posts()) : the_post();
								the_content();
							endwhile; endif; ?>
						</div>

						<?php /* get_sidebar();*/ ?>

				</div>

			</div>
<?php } // end resources

elseif ( is_page( 'about' ) ) {
?>
			<div id="content">
				<span class="corner-map about"></span>
				<div class="blue-bar-top about" id="blue-bar">
					<div class="wrap wrapper">
						<span><a href="#principles">our principles</a></span>
						<span><a href="#members">the team</a></span>
						<!--<span><a href="#partners">partners</a></span>-->
						<span><a href="#newsletter">Newsletter</a></span>
						<span><a href="#contact">contact</a></span>
						<span><a href="#more-content">related web pages</a></span>
					</div>
				</div>

				<div id="inner-content" class="wrap cf">
				<?php if (have_posts()) : while (have_posts()) : the_post();
										the_content();
									endwhile; endif; ?></div>

			</div>
<?php } // end about
	// default
	else {
		?>
		<div id="content">

				<div id="inner-content" class="wrap cf">
			<h1><?php echo get_the_title(); ?></h1>
		<?php if (have_posts()) : while (have_posts()) : the_post();
				the_content();
			endwhile;
		endif;
	}
?>
</div>

			</div>
<?php get_footer(); ?>
