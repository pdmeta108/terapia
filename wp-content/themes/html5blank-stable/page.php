<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

		<?php get_template_part('template-parts/breadcrumb'); ?>

<!-- Page Content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">

		<?php get_template_part('template-parts/sidebar-user'); ?>

		<div class="col-md-7 col-lg-8 col-xl-9">

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php the_content(); ?>

				<?php comments_template( '', true ); // Remove if you don't want comments ?>

				<br class="clear">

				<?php //edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Lo sentimos, nada que mostrar.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
		</div>
		</div>
					</div>

				</div>		
			<!-- /Page Content -->

		</section>
		<!-- /section -->
	</main>

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
